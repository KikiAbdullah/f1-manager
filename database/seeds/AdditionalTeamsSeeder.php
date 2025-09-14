<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\{
    Team,
    Driver,
    TeamDriver,
    TechDirector,
    AeroChief,
    RaceEngineer,
    Engine,
    TeamStaff,
    Car,
    CarDriver
};

class AdditionalTeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // --- 1) Build pools and ensure we don't reuse people already tied to a team ---
            $usedDriverIds = TeamDriver::query()->pluck('driver_id')->all();
            $driverPool = Driver::query()
                ->whereNotIn('id', $usedDriverIds)
                ->inRandomOrder()
                ->take(10) // 5 teams x 2 drivers
                ->get()
                ->values();

            if ($driverPool->count() < 10) {
                throw new \RuntimeException('Not enough available drivers to create 5 teams with 2 drivers each.');
            }

            // Staff pools (unique per team)
            $techPool = TechDirector::query()->inRandomOrder()->take(5)->get()->values();
            $aeroPool = AeroChief::query()->inRandomOrder()->take(5)->get()->values();
            $racePool = RaceEngineer::query()->inRandomOrder()->take(5)->get()->values();
            $enginePool = Engine::query()->inRandomOrder()->take(5)->get()->values();

            foreach (['TechDirector' => $techPool, 'AeroChief' => $aeroPool, 'RaceEngineer' => $racePool, 'Engine' => $enginePool] as $label => $pool) {
                if ($pool->count() < 5) {
                    throw new \RuntimeException("Not enough {$label} records to assign uniquely to 5 teams.");
                }
            }

            // --- 2) Define 5 new team shells ---
            $teamDefs = [
                ['name' => 'Nusantara Phoenix', 'manager_name' => 'D. Santoso', 'country' => 'ID', 'color_primary' => 'orange', 'color_secondary' => 'black'],
                ['name' => 'Java Lightning',   'manager_name' => 'R. Pratama', 'country' => 'ID', 'color_primary' => 'yellow', 'color_secondary' => 'navy'],
                ['name' => 'Sumatra Scorpions', 'manager_name' => 'A. Putra',   'country' => 'ID', 'color_primary' => 'green', 'color_secondary' => 'white'],
                ['name' => 'Borneo Thunder',   'manager_name' => 'M. Hakim',   'country' => 'ID', 'color_primary' => 'teal', 'color_secondary' => 'gray'],
                ['name' => 'Sulawesi Drift',   'manager_name' => 'F. Siregar', 'country' => 'ID', 'color_primary' => 'purple', 'color_secondary' => 'silver'],
            ];

            // --- 3) Create each team with 2 unique drivers, 2 cars, and unique staff ---
            foreach ($teamDefs as $i => $def) {
                /** @var \App\Models\Team $team */
                $team = Team::create([
                    'name' => $def['name'],
                    'manager_name' => $def['manager_name'],
                    'country' => $def['country'],
                    'color_primary' => $def['color_primary'],
                    'color_secondary' => $def['color_secondary'],
                    'created_by' => 1,
                ]);

                // Unique staff per team
                $engine = $enginePool[$i];
                $techDir = $techPool[$i];
                $aero    = $aeroPool[$i];
                $raceEn  = $racePool[$i];

                TeamStaff::create([
                    'team_id' => $team->id,
                    'tech_director_id' => $techDir->id,
                    'aero_chief_id'    => $aero->id,
                    'race_engineer_id' => $raceEn->id,
                ]);

                // Two unique drivers (no overlap across the 5 teams)
                $d1 = $driverPool[$i * 2];
                $d2 = $driverPool[$i * 2 + 1];

                $td1 = TeamDriver::create([
                    'team_id' => $team->id,
                    'driver_id' => $d1->id,
                ]);
                $td2 = TeamDriver::create([
                    'team_id' => $team->id,
                    'driver_id' => $d2->id,
                ]);

                // --- 4) Create 2 cars for the team, with stats derived from staff & engine ---
                $driversForCalc = [$d1, $d2];
                foreach ($driversForCalc as $idx => $drv) {
                    $topSpeed = $engine->power + ($aero->efficiency / 2) - ($aero->downforce_knowledge / 3);

                    $cornering = $aero->downforce_knowledge + ($techDir->engineering / 2) - ($engine->power / 3);

                    $reliability = $engine->reliability + ($techDir->engineering / 2);

                    $fuel_efficiency = $engine->fuel_efficiency + ($aero->efficiency / 2);

                    $tyre_management = $raceEn->strategy + ($drv->experience / 2);

                    $cooling = $engine->heat_management + ($techDir->engineering / 2);

                    $acceleration = $engine->power + ($drv->reactions / 2);

                    $braking = $techDir->chassis + ($drv->braking / 2);

                    $aero_efficiency = $aero->efficiency + ($techDir->innovation / 2);

                    $adaptability = $raceEn->adaptability + ($drv->adaptability / 2);

                    $pit_stop_speed = $raceEn->strategy + ($drv->mentality / 2);

                    $weights = [
                        'top_speed' => 0.20,
                        'cornering' => 0.20,
                        'reliability' => 0.15,
                        'fuel_efficiency' => 0.08,
                        'tyre_management' => 0.10,
                        'cooling' => 0.05,
                        'acceleration' => 0.08,
                        'braking' => 0.06,
                        'aero_efficiency' => 0.05,
                        'adaptability' => 0.02,
                        'pit_stop_speed' => 0.01,
                    ];

                    $overall_score =
                        $topSpeed * $weights['top_speed'] +
                        $cornering * $weights['cornering'] +
                        $reliability * $weights['reliability'] +
                        $fuel_efficiency * $weights['fuel_efficiency'] +
                        $tyre_management * $weights['tyre_management'] +
                        $cooling * $weights['cooling'] +
                        $acceleration * $weights['acceleration'] +
                        $braking * $weights['braking'] +
                        $aero_efficiency * $weights['aero_efficiency'] +
                        $adaptability * $weights['adaptability'] +
                        $pit_stop_speed * $weights['pit_stop_speed'];


                    $car = Car::create([
                        'name'              => Str::upper(Str::slug($team->name, '')) . '-' . ($idx + 1),
                        'team_id'           => $team->id,
                        'engine_id'         => $engine->id,
                        'tech_director_id'  => $techDir->id,
                        'aero_chief_id'     => $aero->id,
                        'race_engineer_id'  => $raceEn->id,
                        'top_speed'         => round($topSpeed),
                        'cornering'         => round($cornering),
                        'reliability'       => round($reliability),
                        'fuel_efficiency'   => round($fuel_efficiency),
                        'tyre_management'   => round($tyre_management),
                        'cooling'           => round($cooling),
                        'acceleration'      => round($acceleration),
                        'braking'           => round($braking),
                        'aero_efficiency'   => round($aero_efficiency),
                        'adaptability'      => round($adaptability),
                        'pit_stop_speed'    => round($pit_stop_speed),
                        'overall_score'     => round($overall_score, 2), // pakai 2 desimal biar lebih presisi
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    CarDriver::create([
                        'car_id' => $car->id,
                        'driver_id' => $drv->id,
                        'season_year' => now()->year,
                    ]);
                }
            }
        });
    }
}
