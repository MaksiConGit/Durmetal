<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientClassification;
use App\Models\DocumentType;
use App\Models\IvaCondition;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => '$2y$12$bEnrSffLEb62SmrIXH1uLeIw0/Sk5xpMYHIPpIkZluSw5sfP8BH6m',
        ]);

        Province::create([
            'name' => 'Buenos Aires',
        ]);

        City::create([
            'name' => 'San Nicolás de los Arroyos',
            'cp' => 'B2900',
            'province_id' => '1',
        ]);

        IvaCondition::create([
            'name' => 'Responsable inscripto',
        ]);

        DocumentType::create([
            'name' => 'CUIT',
        ]);

        ClientClassification::create([
            'name' => 'San Nicolás de los Arroyos',
        ]);

        Client::create([
            'name' => 'DESARROLLOS INDUSTRIALES',
            'address' => 'CHACO 74 SAN NICOLÁS',
            'city_id' => '1',
            'phone' => '0341-155-481810',
            'iva_condition_id' => '1',
            'document_type_id' => '1',
            'document_number' => '30708681896',
            'is_active' => 'true',
            'client_classfication_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ]);
    }
}
