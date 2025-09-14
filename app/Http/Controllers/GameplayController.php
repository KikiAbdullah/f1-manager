<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Loan;
use App\Models\Race;
use App\Models\RacePenalty;
use App\Models\RaceResult;
use App\Models\Schedule;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\TeamDriver;
use App\Models\TeamFinance;
use App\Models\TeamLoan;
use App\Models\TeamSponsor;
use App\Models\TeamStaff;
use GuzzleHttp\Pool;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GameplayController extends Controller
{
    public function __construct(Team $model)
    {
        $this->title            = 'Gameplay';
        $this->subtitle         = 'Gameplay';
        $this->model_request    = Request::class;
        $this->folder           = '';
        $this->relation         = [];
        $this->model            = $model;
        $this->withTrashed      = false;
    }

    public function ajaxData()
    {
        if ($this->withTrashed) {
            $mapped             = $this->model->with($this->relation)->withTrashed()->orderBy('id', 'desc');
        } else {
            $mapped             = $this->model->with($this->relation)->orderBy('id', 'desc');
        }
        return DataTables::of($mapped)
            ->toJson();
    }

    public function index(Request $request)
    {
        $team = Team::where('created_by', auth()->user()->id)->first();

        $view = [
            'title'     => 'Home',
            'subtitle'  => 'Home',
            'team' => $team,
        ];

        return view('gameplay.index')->with($view);
    }

    public function drivers(Request $request)
    {
        $team = Team::where('created_by', auth()->user()->id)->first();
        $drivers = TeamDriver::where('team_id', $team->id)->get();

        $view = [
            'title'     => 'Drivers',
            'subtitle'  => 'Drivers',
            'team' => $team,
            'drivers' => $drivers,
        ];

        return view('gameplay.drivers')->with($view);
    }

    public function staffs(Request $request)
    {
        $team = Team::where('created_by', auth()->user()->id)->first();
        $staffs = TeamStaff::with(['team', 'techDirector', 'aeroChief', 'raceEngineer'])->where('team_id', $team->id)->first();

        $view = [
            'title'     => 'Staffs',
            'subtitle'  => 'Staffs',
            'team' => $team,
            'staffs' => $staffs,
        ];

        return view('gameplay.staffs')->with($view);
    }

    public function cars(Request $request)
    {
        $team = Team::where('created_by', auth()->user()->id)->first();
        $cars = Car::with(['team', 'engine', 'techDirector', 'aeroChief', 'raceEngineer', 'drivers'])->where('team_id', $team->id)->get();

        $view = [
            'title'     => 'Cars',
            'subtitle'  => 'Cars',
            'team' => $team,
            'cars' => $cars,
        ];

        return view('gameplay.cars')->with($view);
    }

    public function finances(Request $request)
    {
        $team = Team::where('created_by', auth()->user()->id)->first();
        $finances = TeamFinance::with(['team'])->where('team_id', $team->id)->get();

        $view = [
            'title'     => 'Finances',
            'subtitle'  => 'Finances',
            'team' => $team,
            'finances' => $finances,
        ];

        return view('gameplay.finances')->with($view);
    }

    public function schedules(Request $request)
    {
        $schedules = Schedule::with(['circuit'])->get();

        $view = [
            'title'     => 'Schedule',
            'subtitle'  => 'Schedule',
            'schedules' => $schedules,
        ];

        return view('gameplay.schedules')->with($view);
    }

    public function schedulesDetail(Request $request, $id)
    {
        $schedule = Schedule::with(['circuit'])->find($id);

        $view = [
            'title'     => 'Schedule',
            'subtitle'  => 'Schedule',
            'schedule' => $schedule,
        ];

        return view('gameplay.schedules-detail')->with($view);
    }



    ///RACE
    public function race(Request $request)
    {
        $raceId = $request->input('race_id', 1);


        $myTeam = Team::where('created_by', auth()->user()->id)->first();

        $teamDrivers = $myTeam->drivers->pluck('driver_id')->toArray();

        $race = Race::find($raceId);

        $results = RaceResult::with(['driver.teams', 'race'])
            ->where('race_id', $race->id)
            ->get()
            ->groupBy(['lap', 'sector']);

        $penalties = RacePenalty::with(['driver', 'race'])->where('race_id', $race->id)->get();

        // proses untuk posisi naik/turun
        $positionHistory = [];

        foreach ($results as $lap => $lapData) {
            foreach ($lapData as $sector => $sectorData) {
                $sorted = $sectorData->sortByDesc('accumulated')->values();

                foreach ($sorted as $pos => $res) {
                    $driverId = $res->driver_id;

                    $currentPos = $pos + 1; // karena array mulai dari 0
                    $lastPos = $positionHistory[$driverId] ?? $currentPos;

                    if ($currentPos < $lastPos) {
                        $res->pos_change = 'up';
                    } elseif ($currentPos > $lastPos) {
                        $res->pos_change = 'down';
                    } else {
                        $res->pos_change = 'same';
                    }

                    $positionHistory[$driverId] = $currentPos;
                }
            }
        }

        $view = [
            'title'     => 'Race',
            'subtitle'  => 'Race',
            'team'      => $myTeam,
            'teamDrivers' => $teamDrivers,
            'race'      => $race,
            'results'   => $results,
            'penalties' => $penalties,
        ];

        return view('gameplay.race')->with($view);
    }

    public function raceStart(Request $request)
    {
        Race::create([
            'name' => 'Race 2',
            'race_date' => date('Y-m-d'),
            'laps' => 5,
        ]);
    }

    public function raceCalculate(Request $request)
    {
        $raceId = $request->input('race_id', 1);
        $race = Race::find($raceId);

        $penalties = [];

        // cari lap & sektor terakhir
        $lastResult = RaceResult::where('race_id', $raceId)
            ->orderBy('lap', 'desc')
            ->orderBy('sector', 'desc')
            ->first();

        $currentLap = $lastResult ? $lastResult->lap : 1;
        $currentSector = $lastResult ? $lastResult->sector : 1;

        if ($lastResult) {
            if ($currentSector < 3) $currentSector++;
            else {
                $currentSector = 1;
                $currentLap++;
            }
        }

        if ($currentLap > $race->laps) {
            return response()->json([
                'status' => 'finished',
                'message' => "Race {$race->id} sudah selesai."
            ]);
        }

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
        $calculateLap = function ($driver, $car, $race, &$penalties, $raceId, $currentLap, $currentSector) {
            $driverScore = $driver->skill + $driver->consistency + ($driver->aggression / 2) + ($driver->experience / 2) + ($driver->stamina / 2);

            $carScore = ($car->top_speed * $race->straight_length)
                + ($car->cornering * $race->corner_density)
                + ($car->fuel_efficiency * $race->tyre_wear_level)
                + $car->reliability
                + $car->tyre_management;

            $strategyScore = $car->raceEngineer ? ($car->raceEngineer->strategy + ($car->raceEngineer->communication / 2)) : 0;

            // base score
            $base = $driverScore + ($carScore * 0.5) + ($strategyScore * 0.5);

            // randomness
            $lapTotal = $base + rand(1, 6);

            // risk checks
            $riskPenalty = 0;

            // Aggression risk
            if (rand(1, 20) <= ($driver->aggression - $driver->consistency)) {
                $points = rand(2, 4);
                $riskPenalty += $points;
                $penalties[] = [
                    'race_id' => $race->id,
                    'driver_id' => $driver->id,
                    'lap' => $currentLap,
                    'sector' => $currentSector,
                    'points' => $points,
                    'description' => 'Spin minor karena agresivitas tinggi',
                ];
            }

            // Reliability risk (DNF)
            if (rand(1, 20) <= (6 - $car->reliability)) {
                $points = $lapTotal;
                $lapTotal = 0;
                $penalties[] = [
                    'race_id' => $race->id,
                    'driver_id' => $driver->id,
                    'lap' => $currentLap,
                    'sector' => $currentSector,
                    'points' => $points,
                    'description' => 'Mobil rusak / DNF karena reliability rendah',
                ];
            }

            // Tyre risk
            if (rand(1, 20) <= ($race->tyre_wear_level + 6 - $car->tyre_management)) {
                $points = rand(2, 6);
                $riskPenalty += $points;
                $penalties[] = [
                    'race_id' => $race->id,
                    'driver_id' => $driver->id,
                    'lap' => $currentLap,
                    'sector' => $currentSector,
                    'points' => $points,
                    'description' => 'Waktu hilang karena keausan ban',
                ];
            }

            // Overheating risk
            if (rand(1, 20) <= (6 - $car->cooling)) {
                $points = 3;
                $riskPenalty += $points;
                $penalties[] = [
                    'race_id' => $race->id,
                    'driver_id' => $driver->id,
                    'lap' => $currentLap,
                    'sector' => $currentSector,
                    'points' => $points,
                    'description' => 'Kehilangan waktu karena overheating mesin',
                ];
            }

            $finalLap = max(0, $lapTotal - $riskPenalty);

            $lastAccum = RaceResult::where(['race_id' => $raceId, 'driver_id' => $driver->id])
                ->orderBy('lap', 'desc')->orderBy('sector', 'desc')->first();
            $accumulated = $lastAccum ? $lastAccum->accumulated + $finalLap : $finalLap;

            return [
                'race_id' => $race->id,
                'driver_id' => $driver->id,
                'lap' => $currentLap,
                'sector' => $currentSector,
                'rps' => $base,
                'lap_total' => $currentSector == 3 ? $finalLap : 0,
                'accumulated' => $accumulated,
            ];
        };

        // ==== Player Drivers ====
        foreach ($myTeam->cars as $car) {
            $driver = $car->drivers->first();
            if ($driver) {
                $results[] = $calculateLap($driver, $car, $race, $penalties, $raceId, $currentLap, $currentSector);
            }
        }

        // ==== Rival Drivers ====
        foreach ($rivals as $rival) {
            $car = $rival->cars->first();
            if ($car) {
                $results[] = $calculateLap($rival, $car, $race, $penalties, $raceId, $currentLap, $currentSector);
            }
        }

        RaceResult::insert($results);

        if (!empty($penalties)) {
            RacePenalty::insert($penalties);
        }

        // tentukan next step
        if ($currentSector < 3) {
            $nextSector = $currentSector + 1;
            $nextLap = $currentLap;
        } else {
            $nextSector = 1;
            $nextLap = $currentLap + 1;
        }

        $status = $nextLap > $race->laps ? 'finished' : 'ongoing';

        return response()->json([
            'status' => $status,
            'penalties' => $penalties,
            'current_lap' => $currentLap,
            'current_sector' => $currentSector,
            'next_lap' => $nextLap,
            'next_sector' => $nextSector,
            'inserted' => $results
        ]);
    }



    ///RACE
}
