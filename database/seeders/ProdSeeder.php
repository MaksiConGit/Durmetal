<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;

class ProdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");

        $archivos = [
            'provincia.sql',
            'localidad.sql',
            'condicion_iva.sql',
            'user.sql',
            'tipo_cliente.sql',
            'calificacion_cliente.sql',
            'cliente.sql',
            'email_cliente.sql',
            'cuenta_gastos.sql',
            'retencion_iibb.sql',
            'proveedor.sql',
            'email_proveedor.sql',
        ];

        foreach ($archivos as $archivo) {

            $this->command->info("Ejecutando {$archivo}...");

            $ruta = database_path("sql/{$archivo}");

            $handle = fopen($ruta, 'r');

            if (!$handle) {
                throw new \Exception("No se pudo abrir {$archivo}");
            }

            while (($linea = fgets($handle)) !== false) {

                $linea = trim($linea);

                if ($linea === '') {
                    continue;
                }

                DB::unprepared($linea);
            }

            fclose($handle);

            $this->command->info("✓ {$archivo} terminado");
        }

        Role::firstOrCreate(['name' => 'admin']);

        Role::firstOrCreate(['name' => 'produccion']);

        $users = User::all();

        foreach ($users as $user) {

            if ($user->id == 33 || $user->id == 39 || $user->id == 0) {
                $rol = 'admin';
            }
            else{
                $rol = 'produccion';
            }

            $user->assignRole($rol);
        }
        
    }
}
