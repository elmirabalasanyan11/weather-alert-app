<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'New York', 'country' => 'USA'],
            ['name' => 'Los Angeles', 'country' => 'USA'],
            ['name' => 'Chicago', 'country' => 'USA'],
            ['name' => 'Houston', 'country' => 'USA'],
            ['name' => 'Miami', 'country' => 'USA'],
            ['name' => 'London', 'country' => 'UK'],
            ['name' => 'Manchester', 'country' => 'UK'],
            ['name' => 'Birmingham', 'country' => 'UK'],
            ['name' => 'Paris', 'country' => 'France'],
            ['name' => 'Marseille', 'country' => 'France'],
            ['name' => 'Berlin', 'country' => 'Germany'],
            ['name' => 'Munich', 'country' => 'Germany'],
            ['name' => 'Dubai', 'country' => 'UAE'],
            ['name' => 'Toronto', 'country' => 'Canada'],
            ['name' => 'Vancouver', 'country' => 'Canada'],
            ['name' => 'Mexico City', 'country' => 'Mexico'],
            ['name' => 'Guadalajara', 'country' => 'Mexico'],
            ['name' => 'São Paulo', 'country' => 'Brazil'],
            ['name' => 'Rio de Janeiro', 'country' => 'Brazil'],
            ['name' => 'Buenos Aires', 'country' => 'Argentina'],
            ['name' => 'Santiago', 'country' => 'Chile'],
            ['name' => 'Lagos', 'country' => 'Nigeria'],
            ['name' => 'Nairobi', 'country' => 'Kenya'],
            ['name' => 'Johannesburg', 'country' => 'South Africa'],
            ['name' => 'Moscow', 'country' => 'Russia'],
            ['name' => 'Saint Petersburg', 'country' => 'Russia'],
            ['name' => 'Beijing', 'country' => 'China'],
            ['name' => 'Shanghai', 'country' => 'China'],
            ['name' => 'Delhi', 'country' => 'India'],
            ['name' => 'Mumbai', 'country' => 'India'],
            ['name' => 'Jakarta', 'country' => 'Indonesia'],
            ['name' => 'Seoul', 'country' => 'South Korea'],
            ['name' => 'Bangkok', 'country' => 'Thailand'],
            ['name' => 'Istanbul', 'country' => 'Turkey'],
            ['name' => 'Athens', 'country' => 'Greece'],
            ['name' => 'Cairo', 'country' => 'Egypt'],
            ['name' => 'Kuala Lumpur', 'country' => 'Malaysia'],
            ['name' => 'Singapore', 'country' => 'Singapore'],
            ['name' => 'Hanoi', 'country' => 'Vietnam'],
            ['name' => 'Manila', 'country' => 'Philippines'],
            ['name' => 'Sydney', 'country' => 'Australia'],
            ['name' => 'Melbourne', 'country' => 'Australia'],
            ['name' => 'Auckland', 'country' => 'New Zealand'],
        ];

        // Add 100 records
        DB::table('cities')->insert($cities);
    }
}
