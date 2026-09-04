<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\User;

class FixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");

        $archivos = [
            // 'dureza.sql',
            // 'material.sql',
            // 'tratamiento.sql',
            'cuenta_otros_egresos.sql',
            'codigo_complejidad.sql',
        ];

        foreach ($archivos as $archivo) {

            $this->command->info("Ejecutando {$archivo}...");

            $ruta = database_path("sql/{$archivo}");

            if (!file_exists($ruta)) {
                throw new \Exception("No existe el archivo {$ruta}");
            }

            /*
             * durmetal.sql necesita un tratamiento especial
             * porque sus INSERT ocupan varias líneas.
             */
            if ($archivo === 'durmetal.sql') {

                $sql = file_get_contents($ruta);

                // Quitar comentarios de phpMyAdmin
                $sql = preg_replace('/^\s*--.*$/m', '', $sql);

                /*
                 * Separar las sentencias por ;
                 */
                $sentencias = preg_split('/;\s*/', $sql);

                foreach ($sentencias as $sentencia) {

                    $sentencia = trim($sentencia);

                    if ($sentencia === '') {
                        continue;
                    }

                    /*
                     * Algunos dumps pueden tener INSERT vacíos:
                     *
                     * INSERT INTO `tabla` (...) VALUES
                     *
                     * Los ignoramos.
                     */
                    if (preg_match('/INSERT\s+INTO.*VALUES\s*$/is', $sentencia)) {
                        $this->command->warn(
                            "⚠️ INSERT vacío omitido en {$archivo}"
                        );

                        continue;
                    }

                    DB::unprepared($sentencia);
                }

                $this->command->info("✓ {$archivo} terminado");

                continue;
            }

            /*
             * Los demás archivos siguen funcionando
             * exactamente como antes.
             */
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

        /*
         * Roles
         */
        Role::firstOrCreate([
            'name' => 'admin'
        ]);

        Role::firstOrCreate([
            'name' => 'produccion'
        ]);

        /*
         * Asignar roles
         */
        $users = User::all();

        foreach ($users as $user) {

            if (
                $user->id == 33 ||
                $user->id == 39 ||
                $user->id == 0
            ) {
                $rol = 'admin';
            } else {
                $rol = 'produccion';
            }

            $user->assignRole($rol);
        }
    }
}
