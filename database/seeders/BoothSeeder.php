<?php

namespace Database\Seeders;

use App\Models\Booth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booths = [
            [
                'code' => 'SP5',
                'coords' => '100,150,180,200', // x1,y1,x2,y2 for rectangle
                'shape' => 'rect',
                'status' => 'available',
                'type' => 'standard',
                'description' => 'Corner booth near main gate',
            ],
            [
                'code' => 'SP10',
                'coords' => '200,180,280,230',
                'shape' => 'rect',
                'status' => 'booked',
                'type' => 'premium',
                'description' => 'Prime location with foot traffic',
            ],
            [
                'code' => 'SP12',
                'coords' => '300,160,370,210',
                'shape' => 'rect',
                'status' => 'reserved',
                'type' => 'standard',
                'description' => 'Middle aisle visibility',
            ],
            [
                'code' => 'SP13',
                'coords' => '400,200,470,250',
                'shape' => 'rect',
                'status' => 'available',
                'type' => 'premium',
                'description' => 'Great lighting spot',
            ],
            [
                'code' => 'SP20',
                'coords' => '500,190,580,240',
                'shape' => 'rect',
                'status' => 'booked',
                'type' => 'vip',
                'description' => 'End cap premium booth',
            ],
        ];

        foreach ($booths as $booth) {
            Booth::create($booth);
        }
    }
}
