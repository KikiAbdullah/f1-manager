<?php

use App\Models\Engine;
use Illuminate\Database\Seeder;

class EngineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $engines = [
            [
                'name' => 'Honda RBPT',
                'power' => 95,
                'reliability' => 93,
                'heat_management' => 91,
                'fuel_efficiency' => 88,
                'drivability' => 90,
                'hybrid_system' => 92,
                'innovation' => 94,
            ],
            [
                'name' => 'Mercedes',
                'power' => 90,
                'reliability' => 88,
                'heat_management' => 87,
                'fuel_efficiency' => 91,
                'drivability' => 89,
                'hybrid_system' => 88,
                'innovation' => 90,
            ],
            [
                'name' => 'Ferrari',
                'power' => 88,
                'reliability' => 80,
                'heat_management' => 78,
                'fuel_efficiency' => 85,
                'drivability' => 83,
                'hybrid_system' => 84,
                'innovation' => 86,
            ],
            [
                'name' => 'Renault',
                'power' => 75,
                'reliability' => 70,
                'heat_management' => 72,
                'fuel_efficiency' => 74,
                'drivability' => 76,
                'hybrid_system' => 73,
                'innovation' => 72,
            ],
            [
                'name' => 'Audi',
                'power' => 68,
                'reliability' => 65,
                'heat_management' => 66,
                'fuel_efficiency' => 67,
                'drivability' => 70,
                'hybrid_system' => 68,
                'innovation' => 75,
            ],
        ];

        Engine::insert($engines);
    }
}
