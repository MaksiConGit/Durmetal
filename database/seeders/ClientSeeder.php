<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientQualification;
use App\Models\DocumentType;
use App\Models\Email;
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

        ClientQualification::create([
            'name' => 'Sin calificar',
        ]);

        Client::create([
            'name' => 'DESARROLLOS INDUSTRIALES',
            'address' => 'CHACO 74 SAN NICOLÁS',
            'city_id' => '1',
            'phone' => '0341-155-481810',
            'iva_condition_id' => '1',
            'document_type_id' => '1',
            'document_number' => '30708681896',
            'balance' => '5235664',
            'is_active' => '1',
            'client_qualification_id' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ]);

        Email::create([
            'text' => 'cliente@cliente',
            'client_id' => '1',
        ]);

        Email::create([
            'text' => 'cliente@cliente1',
            'client_id' => '1',
        ]);
    }
}
