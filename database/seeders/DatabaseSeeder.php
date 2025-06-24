<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Material;
use App\Models\Tratamiento;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClientSeeder::class,
            ProductionSeeder::class,
        ]);

        Tratamiento::factory(20)->create();
        Material::factory(20)->create();
        Client::factory(200)->create();

    }
}
