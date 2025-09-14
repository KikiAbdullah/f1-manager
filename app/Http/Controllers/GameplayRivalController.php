<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Loan;
use App\Models\Race;
use App\Models\RacePenalty;
use App\Models\RaceResult;
use App\Models\Sponsor;
use App\Models\Team;
use App\Models\TeamDriver;
use App\Models\TeamFinance;
use App\Models\TeamLoan;
use App\Models\TeamSponsor;
use App\Models\TeamStaff;
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
        $drivers = TeamDriver::where('team_id', $team->id)->get();

        $view = [
            'title'     => 'Home',
            'subtitle'  => 'Home',
            'team' => $team,
            'drivers' => $drivers,
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
        $staff = TeamStaff::with(['team', 'techDirector', 'aeroChief', 'raceEngineer'])->where('team_id', $team->id)->first();

        $view = [
            'title'     => 'Staffs',
            'subtitle'  => 'Staffs',
            'team' => $team,
            'staff' => $staff,
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


    ///RACE
    public function race(Request $request)
    {
        $myTeam = Team::where('created_by', auth()->user()->id)->first();

        $teamDrivers = $myTeam->drivers->pluck('driver_id')->toArray();

        $race = Race::find(1);

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

        $myTeam = Team::with(['drivers', 'cars.drivers', 'cars.raceEngineer'])
            ->where('created_by', auth()->user()->id)
            ->first();

        $teamDriverIds = $myTeam->drivers->pluck('driver_id')->toArray();
        $rivals = Driver::whereNotIn('id', $teamDriverIds)->get();

        $results = [];

        // ==== Player Drivers ====
        foreach ($myTeam->cars as $car) {
            $driver = $car->drivers->first();

            $driverScore = $driver->skill + $driver->consistency + ($driver->aggression / 2) + ($driver->experience / 2) + ($driver->stamina / 2);

            $carScore = ($car->top_speed * $race->straight_length)
                + ($car->cornering * $race->corner_density)
                + ($car->fuel_efficiency * $race->tyre_wear_level)
                + $car->reliability
                + $car->tyre_management;

            $strategyScore = $car->raceEngineer->strategy + ($car->raceEngineer->communication / 2);

            // scale car & strategy agar rival tetap bisa bersaing
            $playerBase = $driverScore + ($carScore * 0.5) + ($strategyScore * 0.5);

            // randomness
            $lapTotal = $playerBase + rand(1, 6);

            // risk checks
            $riskPenalty = 0;

            // Risiko Aggression (spin / kesalahan mengemudi)
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

            // Risiko Reliability (DNF)
            if (rand(1, 20) <= (6 - $car->reliability)) {
                $points = $lapTotal; // seluruh lap hilang
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

            // Risiko Tyre (keausan ban)
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

            // Risiko Overheating / Cooling
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

            // Hitung final lap setelah penalti
            $finalLap = max(0, $lapTotal - $riskPenalty);

            $lastAccum = RaceResult::where(['race_id' => $raceId, 'driver_id' => $driver->id])
                ->orderBy('lap', 'desc')->orderBy('sector', 'desc')->first();
            $accumulated = $lastAccum ? $lastAccum->accumulated + $finalLap : $finalLap;

            $results[] = [
                'race_id' => $race->id,
                'driver_id' => $driver->id,
                'lap' => $currentLap,
                'sector' => $currentSector,
                'rps' => $playerBase,
                'lap_total' => $currentSector == 3 ? $finalLap : 0,
                'accumulated' => $accumulated,
            ];
        }

        // ==== Rival Drivers ====
        // Hitung skala mini modifier agar rival bisa bersaing
        $playerCarAvg = $myTeam->cars->avg(fn($c) => $c->top_speed + $c->cornering + $c->fuel_efficiency);

        foreach ($rivals as $rival) {
            $rivalScore = $rival->skill + $rival->consistency + ($rival->aggression / 2) + ($rival->experience / 2) + ($rival->stamina / 2);

            // mini car factor agar tetap kompetitif
            $rivalCarFactor = $playerCarAvg;

            // circuit bonus
            $circuitBonus = ($race->straight_length > $race->corner_density) ? $rival->skill : $rival->consistency;

            // tier modifier
            $tierModifier = ($rival->skill >= 9) ? 2 : (($rival->skill >= 7) ? 1 : 0);

            $base = $rivalScore + $rivalCarFactor + $circuitBonus + $tierModifier;

            // randomness
            $lapTotal = $base + rand(40, 70);

            // inisialisasi penalti untuk rival
            $riskPenalty = 0;

            // risiko Aggression
            if (rand(1, 20) <= ($rival->aggression - $rival->consistency)) {
                $points = rand(1, 3);
                $riskPenalty += $points;

                $penalties[] = [
                    'race_id' => $race->id,
                    'driver_id' => $rival->id,
                    'lap' => $currentLap,
                    'sector' => $currentSector,
                    'points' => $points,
                    'description' => 'Spin minor karena agresivitas tinggi',
                ];
            }

            $finalLap = max(0, $lapTotal - $riskPenalty);

            $lastAccum = RaceResult::where(['race_id' => $raceId, 'driver_id' => $rival->id])
                ->orderBy('lap', 'desc')->orderBy('sector', 'desc')->first();
            $accumulated = $lastAccum ? $lastAccum->accumulated + $finalLap : $finalLap;

            $results[] = [
                'race_id' => $race->id,
                'driver_id' => $rival->id,
                'lap' => $currentLap,
                'sector' => $currentSector,
                'rps' => $base,
                'lap_total' => $currentSector == 3 ? $finalLap : 0,
                'accumulated' => $accumulated,
            ];
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
