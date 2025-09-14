<?php

use App\Models\AeroChief;
use App\Models\RaceEngineer;
use App\Models\TechDirector;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $techDirector = [
            [
                'name' => 'Pierre Waché', // Red Bull
                'chassis' => 92,
                'powertrain' => 88,
                'durability' => 86,
                'suspension' => 90,
                'cooling' => 85,
                'innovation' => 95,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Enrico Cardile', // Ferrari
                'chassis' => 88,
                'powertrain' => 75,
                'durability' => 80,
                'suspension' => 85,
                'cooling' => 78,
                'innovation' => 82,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'James Allison', // Mercedes
                'chassis' => 91,
                'powertrain' => 89,
                'durability' => 90,
                'suspension' => 92,
                'cooling' => 87,
                'innovation' => 93,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'James Key', // Sauber
                'chassis' => 82,
                'powertrain' => 70,
                'durability' => 76,
                'suspension' => 80,
                'cooling' => 74,
                'innovation' => 79,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Ayao Komatsu', // Haas
                'chassis' => 78,
                'powertrain' => 68,
                'durability' => 80,
                'suspension' => 76,
                'cooling' => 72,
                'innovation' => 75,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'David Sanchez', // Alpine
                'chassis' => 85,
                'powertrain' => 74,
                'durability' => 79,
                'suspension' => 84,
                'cooling' => 77,
                'innovation' => 83,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Pat Fry', // Williams
                'chassis' => 84,
                'powertrain' => 76,
                'durability' => 81,
                'suspension' => 82,
                'cooling' => 78,
                'innovation' => 80,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Rob Marshall', // McLaren
                'chassis' => 87,
                'powertrain' => 82,
                'durability' => 83,
                'suspension' => 88,
                'cooling' => 81,
                'innovation' => 86,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Dan Fallows', // Aston Martin (ex-Aero tapi bisa dijadikan Tech)
                'chassis' => 86,
                'powertrain' => 79,
                'durability' => 82,
                'suspension' => 85,
                'cooling' => 80,
                'innovation' => 88,
                'salary' => rand(30000, 100000),
            ],
        ];

        TechDirector::insert($techDirector);

        $aeroChiefs = [
            [
                'name' => 'Enrico Balbo', // Ferrari
                'front_aero' => 87,
                'rear_aero' => 85,
                'drag_efficiency' => 82,
                'wind_tunnel' => 86,
                'ground_effect' => 88,
                'aero_innovation' => 90,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Dan Fallows', // Aston Martin
                'front_aero' => 90,
                'rear_aero' => 88,
                'drag_efficiency' => 83,
                'wind_tunnel' => 85,
                'ground_effect' => 87,
                'aero_innovation' => 92,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Peter Prodromou', // McLaren
                'front_aero' => 88,
                'rear_aero' => 86,
                'drag_efficiency' => 85,
                'wind_tunnel' => 84,
                'ground_effect' => 86,
                'aero_innovation' => 89,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Simone Resta', // Haas
                'front_aero' => 80,
                'rear_aero' => 78,
                'drag_efficiency' => 76,
                'wind_tunnel' => 79,
                'ground_effect' => 77,
                'aero_innovation' => 81,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Dirk de Beer', // Williams
                'front_aero' => 83,
                'rear_aero' => 81,
                'drag_efficiency' => 80,
                'wind_tunnel' => 82,
                'ground_effect' => 81,
                'aero_innovation' => 85,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Eric Meignan', // Alpine
                'front_aero' => 82,
                'rear_aero' => 80,
                'drag_efficiency' => 78,
                'wind_tunnel' => 81,
                'ground_effect' => 80,
                'aero_innovation' => 84,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Loïc Serra', // Mercedes
                'front_aero' => 89,
                'rear_aero' => 88,
                'drag_efficiency' => 86,
                'wind_tunnel' => 87,
                'ground_effect' => 89,
                'aero_innovation' => 91,
                'salary' => rand(30000, 100000),
            ],
        ];

        AeroChief::insert($aeroChiefs);

        $raceEngineer = [
            [
                'name' => 'Gianpiero Lambiase', // Verstappen
                'strategy' => 92,
                'tyre_management' => 88,
                'communication' => 95,
                'adaptability' => 90,
                'fuel_management' => 85,
                'data_analysis' => 92,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Riccardo Adami', // Ferrari (Sainz)
                'strategy' => 86,
                'tyre_management' => 82,
                'communication' => 87,
                'adaptability' => 85,
                'fuel_management' => 83,
                'data_analysis' => 84,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Tom Stallard', // McLaren (Piastri)
                'strategy' => 84,
                'tyre_management' => 83,
                'communication' => 88,
                'adaptability' => 86,
                'fuel_management' => 82,
                'data_analysis' => 85,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Peter Bonnington', // Mercedes (Hamilton)
                'strategy' => 88,
                'tyre_management' => 85,
                'communication' => 92,
                'adaptability' => 87,
                'fuel_management' => 84,
                'data_analysis' => 89,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Hugh Bird', // Perez
                'strategy' => 85,
                'tyre_management' => 80,
                'communication' => 86,
                'adaptability' => 84,
                'fuel_management' => 81,
                'data_analysis' => 83,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Mark Slade', // Ocon (Alpine)
                'strategy' => 82,
                'tyre_management' => 79,
                'communication' => 84,
                'adaptability' => 82,
                'fuel_management' => 80,
                'data_analysis' => 81,
                'salary' => rand(30000, 100000),
            ],
            [
                'name' => 'Alex Chan', // Williams (Albon)
                'strategy' => 81,
                'tyre_management' => 78,
                'communication' => 83,
                'adaptability' => 81,
                'fuel_management' => 79,
                'data_analysis' => 80,
                'salary' => rand(30000, 100000),
            ],
        ];

        RaceEngineer::insert($raceEngineer);
    }
}
