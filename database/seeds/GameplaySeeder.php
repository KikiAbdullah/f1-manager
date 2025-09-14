<?php

use Illuminate\Database\Seeder;
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
    CarDriver,
    Circuit,
    Sponsor,
    TeamSponsor,
    TeamSponsorTarget,
    Loan,
    Race,
    Schedule,
    TeamLoan,
    TeamLoanPayment,
    TeamFinance
};

class GameplaySeeder extends Seeder
{
    public function run()
    {
        /**
         * TEAM
         */
        $team = Team::create([
            'name' => 'Garuda',
            'manager_name' => 'Kiki Abdullah',
            'country' => 'ID',
            'color_primary' => 'red',
            'color_secondary' => 'blue',
            'created_by' => 1,
        ]);

        /**
         * TEAM DRIVER (pivot)
         */
        $driverIds = Driver::pluck('id')->toArray();
        $picked = array_rand($driverIds, 2);

        $teamDriver = [
            ['team_id' => $team->id, 'driver_id' => $driverIds[$picked[0]]],
            ['team_id' => $team->id, 'driver_id' => $driverIds[$picked[1]]],
        ];

        TeamDriver::insert($teamDriver);


        /**
         * TEAM STAFF
         */
        $engine = Engine::find(rand(1, 5));
        $techDir = TechDirector::find(rand(1, 9));
        $aero = AeroChief::find(rand(1, 7));
        $raceEn = RaceEngineer::find(rand(1, 7));


        TeamStaff::create([
            'team_id' => $team->id,
            'tech_director_id' => $techDir->id,
            'aero_chief_id' => $aero->id,
            'race_engineer_id' => $raceEn->id,
        ]);

        /**
         * CARS
         */
        $cars = [];
        foreach (TeamDriver::all() as $teamDrive) {
            $topSpeed = $engine->power + ($aero->efficiency / 2) - ($aero->downforce_knowledge / 3);

            $cornering = $aero->downforce_knowledge + ($techDir->engineering / 2) - ($engine->power / 3);

            $reliability = $engine->reliability + ($techDir->engineering / 2);

            $fuel_efficiency = $engine->fuel_efficiency + ($aero->efficiency / 2);

            $tyre_management = $raceEn->strategy + ($teamDrive->driver->experience / 2);

            $cooling = $engine->heat_management + ($techDir->engineering / 2);

            $acceleration = $engine->power + ($teamDrive->driver->reactions / 2);

            $braking = $techDir->chassis + ($teamDrive->driver->braking / 2);

            $aero_efficiency = $aero->efficiency + ($techDir->innovation / 2);

            $adaptability = $raceEn->adaptability + ($teamDrive->driver->adaptability / 2);

            $pit_stop_speed = $raceEn->strategy + ($teamDrive->driver->mentality / 2);

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

            $cars[] = [
                'name'              => 'GRD-' . $teamDrive->id,
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
            ];
        }
        Car::insert($cars);

        /**
         * CAR ↔ DRIVER
         */
        $allCars = Car::all();
        $teamDrivers = TeamDriver::all();

        foreach ($allCars as $index => $car) {
            if (isset($teamDrivers[$index])) {
                CarDriver::create([
                    'car_id' => $car->id,
                    'driver_id' => $teamDrivers[$index]->driver_id,
                    'season_year' => now()->year,
                ]);
            }
        }

        /**
         * SPONSORS
         */
        $sponsors = [
            [
                'name' => 'Oracle',
                'funding_amount' => 800000,
                'target_difficulty' => 6,
                'target_description' => 'Win the race (P1)',
                'penalty_amount' => 500000,
                'created_by' => 1,
            ],
            [
                'name' => 'Petronas',
                'funding_amount' => 750000,
                'target_difficulty' => 5,
                'target_description' => 'Finish on the podium (Top 3)',
                'penalty_amount' => 450000,
                'created_by' => 1,
            ],
            [
                'name' => 'Shell',
                'funding_amount' => 700000,
                'target_difficulty' => 5,
                'target_description' => 'Finish on the podium (Top 3)',
                'penalty_amount' => 400000,
                'created_by' => 1,
            ],
            [
                'name' => 'OKX',
                'funding_amount' => 650000,
                'target_difficulty' => 4,
                'target_description' => 'Score points (Top 10)',
                'penalty_amount' => 350000,
                'created_by' => 1,
            ],
            [
                'name' => 'Aramco',
                'funding_amount' => 600000,
                'target_difficulty' => 4,
                'target_description' => 'Score points (Top 10)',
                'penalty_amount' => 300000,
                'created_by' => 1,
            ],
            [
                'name' => 'Garuda Indonesia',
                'funding_amount' => 580000,
                'target_difficulty' => 4,
                'target_description' => 'Finish in top 12 (P12) in home race',
                'penalty_amount' => 280000,
                'created_by' => 1,
            ],
            [
                'name' => 'Pirelli',
                'funding_amount' => 550000,
                'target_difficulty' => 3,
                'target_description' => 'Finish within the top 12 (P12)',
                'penalty_amount' => 250000,
                'created_by' => 1,
            ],
            [
                'name' => 'Pertamina',
                'funding_amount' => 520000,
                'target_difficulty' => 3,
                'target_description' => 'Complete the race',
                'penalty_amount' => 220000,
                'created_by' => 1,
            ],
            [
                'name' => 'Visa',
                'funding_amount' => 450000,
                'target_difficulty' => 3,
                'target_description' => 'Finish within the top 15 (P15)',
                'penalty_amount' => 200000,
                'created_by' => 1,
            ],
            [
                'name' => 'BWT',
                'funding_amount' => 400000,
                'target_difficulty' => 2,
                'target_description' => 'Complete the race',
                'penalty_amount' => 150000,
                'created_by' => 1,
            ],
            [
                'name' => 'Indofood',
                'funding_amount' => 380000,
                'target_difficulty' => 2,
                'target_description' => 'No DNF for 3 consecutive races',
                'penalty_amount' => 130000,
                'created_by' => 1,
            ],
            [
                'name' => 'MoneyGram',
                'funding_amount' => 350000,
                'target_difficulty' => 2,
                'target_description' => 'Complete the race',
                'penalty_amount' => 100000,
                'created_by' => 1,
            ],
        ];

        Sponsor::insert($sponsors);

        $sponsorAccepted = Sponsor::find(rand(1, 12));

        $teamSponsor = TeamSponsor::create([
            'team_id' => $team->id,
            'sponsor_id' => $sponsorAccepted->id,
            'active' => true,
        ]);

        // 💰 Keuangan tim: sponsor masuk
        TeamFinance::create([
            'team_id' => $team->id,
            'description' => "Sponsor: {$sponsorAccepted->name}",
            'amount' => $sponsorAccepted->funding_amount,
            'type' => 'in',
            'category' => 'sponsor',
            'transaction_date' => now(),
        ]);

        // 🎯 Target sponsor
        TeamSponsorTarget::create([
            'team_sponsor_id' => $teamSponsor->id,
            'description' => $sponsorAccepted->target_description,
            'difficulty' => $sponsorAccepted->target_difficulty,
            'due_date' => now()->addWeeks(2),
            'status' => 'pending',
        ]);

        /**
         * LOANS
         */
        $loans = [
            [
                'lender_name' => 'J.P. Morgan',
                'loan_amount' => 5000000,
                'interest_rate' => 7,
                'season_duration' => 3,
                'repayment_per_season' => 1800000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'Citi Private Bank',
                'loan_amount' => 4500000,
                'interest_rate' => 6,
                'season_duration' => 2,
                'repayment_per_season' => 2400000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'Morgan Stanley',
                'loan_amount' => 3000000,
                'interest_rate' => 8,
                'season_duration' => 1,
                'repayment_per_season' => 3240000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'Bank Mandiri',
                'loan_amount' => 2500000,
                'interest_rate' => 10,
                'season_duration' => 2,
                'repayment_per_season' => 1375000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'Bank Central Asia (BCA)',
                'loan_amount' => 2000000,
                'interest_rate' => 11,
                'season_duration' => 1,
                'repayment_per_season' => 2220000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'PT SMI (Sarana Multi Infrastruktur)',
                'loan_amount' => 1800000,
                'interest_rate' => 9,
                'season_duration' => 3,
                'repayment_per_season' => 654000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'HSBC',
                'loan_amount' => 3500000,
                'interest_rate' => 6,
                'season_duration' => 1,
                'repayment_per_season' => 3710000,
                'created_by' => 1,
            ],
            [
                'lender_name' => 'Rabobank',
                'loan_amount' => 1500000,
                'interest_rate' => 7,
                'season_duration' => 2,
                'repayment_per_season' => 802500,
                'created_by' => 1,
            ],
        ];

        $loan = Loan::insert($loans);

        $loanAccepted = Loan::find(rand(1, 8));

        $teamLoan = TeamLoan::create([
            'team_id' => $team->id,
            'loan_id' => $loanAccepted->id,
            'active' => true,
        ]);

        // 💰 Keuangan tim: loan masuk
        TeamFinance::create([
            'team_id' => $team->id,
            'description' => "Loan: {$loanAccepted->lender_name}",
            'amount' => $loanAccepted->loan_amount,
            'type' => 'in',
            'category' => 'loan',
            'transaction_date' => now(),
        ]);

        // 📆 Buat cicilan loan
        TeamLoanPayment::create([
            'team_loan_id' => $teamLoan->id,
            'amount' => $loanAccepted->repayment_per_season,
            'due_date' => now()->addMonths(3),
            'status' => 'unpaid',
        ]);

        /**
         * GAJI DRIVER (contoh pengeluaran rutin)
         */
        foreach ($teamDrivers as $teamDriver) {
            $salary = $teamDriver->driver->salary_per_race ?? 0;
            TeamFinance::create([
                'team_id' => $team->id,
                'description' => "Gaji Driver {$teamDriver->driver->name}",
                'amount' => -$salary,
                'type' => 'out',
                'category' => 'salary_driver',
                'transaction_date' => now(),
            ]);
        }

        $circuits = [
            [
                'name' => 'Bahrain International Circuit',
                'length_km' => 5.412,
                'laps' => 57,
                'straight_length' => 75,  // 1–100
                'corner_density' => 60,   // 1–100
                'tyre_wear_level' => 70,  // 1–100
                'brake_wear_level' => 80, // 1–100
                'overtake_difficulty' => 40, // 1–100 (semakin tinggi = makin susah)
                'drs_zones' => 3,
                'avg_speed' => 75,       // 1–100
                'downforce_level' => 55, // 1–100
                'grip_level' => 65,      // 1–100
            ],
            [
                'name' => 'Circuit de Monaco',
                'length_km' => 3.337,
                'laps' => 78,
                'straight_length' => 20,
                'corner_density' => 95,
                'tyre_wear_level' => 45,
                'brake_wear_level' => 90,
                'overtake_difficulty' => 95,
                'drs_zones' => 1,
                'avg_speed' => 40,
                'downforce_level' => 90,
                'grip_level' => 50,
            ],
            [
                'name' => 'Monza (Autodromo Nazionale di Monza)',
                'length_km' => 5.793,
                'laps' => 53,
                'straight_length' => 95,
                'corner_density' => 30,
                'tyre_wear_level' => 60,
                'brake_wear_level' => 75,
                'overtake_difficulty' => 35,
                'drs_zones' => 2,
                'avg_speed' => 95,
                'downforce_level' => 25,
                'grip_level' => 70,
            ],
        ];

        Circuit::insert($circuits);


        $circuitData = Circuit::all();

        $weather = ['sunny', 'cloudy', 'rainy', 'overcast', 'stormy'];

        foreach ($circuitData as $key => $circuit) {
            Schedule::create([
                'race_date' => date('Y-m-d', strtotime('+' . $key . 'day')),
                'circuit_id' => $circuit->id,
                'season' => date('Y'),
                'weather_forecast' => $weather[rand(0, 4)],
                'actual_weather' => null,
                'air_temp' => null,
                'track_temp' => null,
                'laps'  => rand(5, 15),
                'status' => 'upcoming',
                'safety_car_probability' => 35, // 1–100
                'average_pit_time' => 35, // 1–100
            ]);
        }
    }
}
