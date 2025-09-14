<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\QualifyingResult;
use App\Models\Race;
use App\Models\RaceLog;
use App\Models\RaceResult;
use App\Models\Schedule;
use App\Models\Team;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index(Request $request)
    {
        $raceId = $request->input('race_id') ?? 1; // contoh race_id aktif
        $lapsTotal = 5;

        // Ambil driver dengan pace dari calculatePace
        $drivers = $this->calculatePace($raceId);

        $title = 'Race';
        $subtitle = 'Race';

        return view('race.index', compact('drivers', 'lapsTotal', 'raceId', 'title', 'subtitle'));
    }

    public function result($id)
    {
        $title = 'Race';
        $subtitle = 'Race';

        $results = RaceResult::with('driver.teams')
            ->where('race_id', $id)
            ->get()
            ->groupBy('driver_id');

        $summary = [];

        foreach ($results as $driverId => $laps) {
            $driver = $laps->first()->driver;
            $team = $driver->teams->first()->team->name ?? '';
            $laps = $laps->sortBy('lap_number');

            $totalTime = $laps->sum('lap_time');
            $bestLap = $laps->min('lap_time');

            $summary[] = [
                'driver_id' => $driverId,
                'driver' => $driver->name,
                'team' => $team,
                'code' => $driver->code ?? substr($driver->name, 0, 3),
                'laps' => $laps->count(),
                'total_time' => $totalTime,
                'best_lap' => $bestLap,
                'lap_details' => $laps->mapWithKeys(function ($lap) {
                    return [
                        $lap->lap_number => [
                            's1' => $lap->sector1_time,
                            's2' => $lap->sector2_time,
                            's3' => $lap->sector3_time,
                        ]
                    ];
                })->toArray(),
                'dnf' => $laps->contains(fn($l) => $l->dnf),
            ];
        }

        // Urutkan sesuai juara: totalTime terendah, lalu DNF terakhir
        $summary = collect($summary)->sortBy(function ($d) {
            return $d['dnf'] ? INF : $d['total_time'];
        })->values();

        return view('race.result', compact('summary', 'id', 'title', 'subtitle'));
    }


    public function calculatePace($schedule)
    {

        // ==== Tim Player ====
        $myTeam = Team::with(['drivers', 'cars.drivers', 'cars.raceEngineer', 'teamStaff'])
            ->where('created_by', auth()->user()->id)
            ->first();

        $teamDriverIds = $myTeam->drivers->pluck('driver_id')->toArray();

        // ==== Rival Drivers ====
        $rivals = Driver::whereNotIn('id', $teamDriverIds)
            ->whereHas('teams')
            ->whereHas('cars')
            ->whereHas('teams')
            ->with(['cars.raceEngineer', 'cars', 'teams'])
            ->get();

        $results = [];

        // fungsi perhitungan umum (player & rival sama)
        $calculatePace = function ($driver, $car, $schedule) {
            $circuit = $schedule->circuit;

            // DRIVER SCORE (1–100 scaling)
            $driverScore =
                $driver->cornering * 0.15 +
                $driver->braking * 0.10 +
                $driver->reactions * 0.10 +
                $driver->control * 0.10 +
                $driver->smoothness * 0.10 +
                $driver->adaptability * 0.10 +
                $driver->overtaking * 0.10 +
                $driver->defending * 0.10 +
                $driver->accuracy * 0.15;

            // CAR SCORE (weighted with circuit profile)
            $carScore =
                ($car->top_speed * ($circuit->straight_length / 100)) +
                ($car->cornering * ($circuit->corner_density / 100)) +
                ($car->braking * ($circuit->brake_wear_level / 100)) +
                ($car->tyre_management * ($circuit->tyre_wear_level / 100)) +
                ($car->reliability * 0.8) +
                ($car->fuel_efficiency * ((100 - $schedule->average_pit_time) / 100)) +
                ($car->cooling * ($schedule->track_temp ? min(1, $schedule->track_temp / 50) : 0.5)) +
                ($car->aero_efficiency * ($circuit->grip_level / 100));

            // STRATEGY SCORE (race engineer impact)
            $strategyScore = $car->raceEngineer
                ? ($car->raceEngineer->strategy * 0.6 + $car->raceEngineer->communication * 0.4)
                : 0;

            // BASE SCORE
            $base = ($driverScore * 0.4) + ($carScore * 0.4) + ($strategyScore * 0.2);

            // WEATHER FACTOR
            $weatherFactor = 1.0;
            if (in_array(strtolower($schedule->actual_weather), ['rainy', 'stormy'])) {
                $weatherFactor = 0.85 - ($driver->adaptability / 500); // driver adaptability helps
            } elseif (strtolower($schedule->actual_weather) === 'sunny' && $schedule->track_temp > 40) {
                $weatherFactor = 0.90 - ($car->cooling / 500); // cooling helps in heat
            } elseif (strtolower($schedule->actual_weather) === 'cloudy') {
                $weatherFactor = 1.05;
            }

            // FINAL PACE (scaled & randomized slightly)
            $pace = max(
                0.5,
                min(
                    1.5,
                    ($base / 100) *
                        (1 + (rand(-3, 3) / 100)) *
                        $weatherFactor
                )
            );

            return [
                'schedule_id'       => $schedule->id,
                'driver_id'         => $driver->id,
                'driver'            => $driver->name,
                'code'              => $driver->code ?? strtoupper(substr($driver->name, 0, 3)),
                'pace'              => round($pace, 3),
                'driver_score'      => round($driverScore, 2),
                'car_score'         => round($carScore, 2),
                'strategy_score'    => round($strategyScore, 2),
                'base'              => round($base, 2),
                'weather_factor'    => $weatherFactor,
                'team_id'           => $driver->teams->first()->team_id,
                'color'             => $driver->teams->first()->team->color_primary
                    ?? sprintf("#%06X", mt_rand(0, 0xFFFFFF)),
            ];
        };

        // ==== Player Drivers ====
        foreach ($myTeam->cars as $car) {
            $driver = $car->drivers->first();
            if ($driver) {
                $results[] = $calculatePace($driver, $car, $schedule);
            }
        }

        // ==== Rival Drivers ====
        foreach ($rivals as $rival) {
            $car = $rival->cars->first();
            if ($car) {
                $results[] = $calculatePace($rival, $car, $schedule);
            }
        }

        return $results;
    }


    //RACE
    public function race(Request $request, $id)
    {
        $schedule = Schedule::with(['raceResults', 'qualifyingResults'])->find($id);

        // ambil hasil qualifying: driver_id + position
        $qualifying = $schedule->qualifyingResults->pluck('position', 'driver_id');


        $weatherOptions = ['sunny', 'cloudy', 'rainy', 'overcast', 'stormy'];
        $actualWeather = $weatherOptions[array_rand($weatherOptions)];

        switch ($actualWeather) {
            case 'Sunny':
                $airTemp = rand(25, 35);   // derajat Celcius
                break;
            case 'Cloudy':
                $airTemp = rand(20, 30);
                break;
            case 'Overcast':
                $airTemp = rand(18, 28);
                break;
            case 'Rainy':
                $airTemp = rand(15, 25);
                break;
            case 'Stormy':
                $airTemp = rand(12, 20);
                break;
            default:
                $airTemp = rand(20, 30);
        }
        // track temp biasanya lebih panas
        $trackTemp = $airTemp + rand(3, 15);

        $airTemp = max(1, min(100, round(($airTemp / 50) * 100)));
        $trackTemp = max(1, min(100, round(($trackTemp / 60) * 100)));

        $schedule->update([
            'actual_weather' => $actualWeather,
            'air_temp'       => $airTemp,
            'track_temp'     => $trackTemp,
        ]);

        // ambil data driver dengan pace
        $drivers = $this->calculatePace($schedule);

        // urutkan $drivers sesuai position di qualifying
        $drivers = collect($drivers)->sortBy(function ($d) use ($qualifying) {
            return $qualifying[$d['driver_id']] ?? PHP_INT_MAX; // kalau ga ada → taruh paling belakang
        })->values()->toArray();


        $raceResults = [];
        if ($schedule->raceResults->isNotEmpty()) {
            foreach ($schedule->raceResults->groupBy('driver_id') as $driverId => $laps) {
                $driver = $laps->first()->driver;
                $team = $driver->teams->first()->team->name ?? '';
                $teamColor = $driver->teams->first()->team->color_primary ?? '';
                $laps = $laps->sortBy('lap_number');

                $totalTime = $laps->sum('lap_time');
                $bestLap = $laps->min('lap_time');

                $summary[] = [
                    'driver_id' => $driverId,
                    'driver' => $driver->name,
                    'team_color' => $teamColor,
                    'team' => $team,
                    'code' => $driver->code ?? substr($driver->name, 0, 3),
                    'laps' => $laps->count(),
                    'total_time' => $totalTime,
                    'best_lap' => $bestLap,
                    'lap_details' => $laps->mapWithKeys(function ($lap) {
                        return [
                            $lap->lap_number => [
                                's1' => $lap->sector1_time,
                                's2' => $lap->sector2_time,
                                's3' => $lap->sector3_time,
                            ]
                        ];
                    })->toArray(),
                    'dnf' => $laps->contains(fn($l) => $l->dnf),
                ];
            }

            // Urutkan sesuai juara: totalTime terendah, lalu DNF terakhir
            $summary = collect($summary)->sortBy(function ($d) {
                return $d['dnf'] ? INF : $d['total_time'];
            })->values();

            $raceResults = $summary;
        }

        $team  = Team::where('created_by', auth()->user()->id)->first();


        $view = [
            'title' => 'Race',
            'subtitle' => 'Race',
            'drivers'   => $drivers,
            'schedule'  => $schedule,
            'team'  => $team,
            'lapsTotal'  => 15,
            'raceResults' => $raceResults,
        ];

        return view('race.index')->with($view);
    }

    public function raceStore(Request $request)
    {
        $data = $request->all();

        RaceResult::insert($data);

        Schedule::where('id', $data['schedule_id'])->update([
            'status' => 'completed',
        ]);

        return response()->json(['success' => true]);
    }
    //RACE



    ///QUALIFYING
    public function qualifying(Request $request, $id)
    {
        $schedule = Schedule::with(['raceResults', 'qualifyingResults'])->find($id);

        $weatherOptions = ['sunny', 'cloudy', 'rainy', 'overcast', 'stormy'];
        $actualWeather = $weatherOptions[array_rand($weatherOptions)];

        switch ($actualWeather) {
            case 'Sunny':
                $airTemp = rand(25, 35);   // derajat Celcius
                break;
            case 'Cloudy':
                $airTemp = rand(20, 30);
                break;
            case 'Overcast':
                $airTemp = rand(18, 28);
                break;
            case 'Rainy':
                $airTemp = rand(15, 25);
                break;
            case 'Stormy':
                $airTemp = rand(12, 20);
                break;
            default:
                $airTemp = rand(20, 30);
        }
        // track temp biasanya lebih panas
        $trackTemp = $airTemp + rand(3, 15);

        $airTemp = max(1, min(100, round(($airTemp / 50) * 100)));
        $trackTemp = max(1, min(100, round(($trackTemp / 60) * 100)));

        $schedule->update([
            'actual_weather' => $actualWeather,
            'air_temp'       => $airTemp,
            'track_temp'     => $trackTemp,
        ]);

        $drivers = $this->calculatePace($schedule);

        $team  = Team::where('created_by', auth()->user()->id)->first();

        $view = [
            'title' => 'Qualifying',
            'subtitle' => 'Qualifying',
            'drivers'   => $drivers,
            'schedule'  => $schedule,
            'team'  => $team,
            'lapsTotal'  => 10,
        ];

        return view('qualifying.index')->with($view);
    }


    public function qualifyingStore(Request $request)
    {
        $data = $request->all();

        QualifyingResult::insert($data);

        return response()->json(['success' => true]);
    }

    ///QUALIFYING
}
