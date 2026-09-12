<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class NotaEnvioSrlSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement("SET SESSION sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");

        $mapaIdsNotas = [];
        $mapaIdsItems = [];

        $totalNotasImportadas = 0;
        $totalItemsImportados = 0;

        DB::transaction(function () use (
            &$mapaIdsNotas,
            &$mapaIdsItems,
            &$totalNotasImportadas,
            &$totalItemsImportados
        ) {

            /*
             * ============================================================
             * 1. IMPORTAR nota_envio
             * ============================================================
             */

            $rutaNotas = database_path('sql/nota_envio.sql');

            if (!file_exists($rutaNotas)) {
                throw new RuntimeException(
                    "No existe el archivo: {$rutaNotas}"
                );
            }

            $handle = fopen($rutaNotas, 'r');

            if (!$handle) {
                throw new RuntimeException(
                    "No se pudo abrir: {$rutaNotas}"
                );
            }

            while (($linea = fgets($handle)) !== false) {

                $linea = trim($linea);

                if ($linea === '') {
                    continue;
                }

                /*
                 * Capturamos:
                 *
                 * $matches[1] = columnas después de Id
                 * $matches[2] = Id viejo
                 * $matches[3] = valores después del Id viejo
                 */

                $patron = '/^INSERT INTO `nota_envio` \(`Id`, (.*)\) VALUES \((\d+), (.*)\);$/';

                if (!preg_match($patron, $linea, $matches)) {
                    throw new RuntimeException(
                        "No se pudo interpretar esta línea de nota_envio:\n{$linea}"
                    );
                }

                $columnas = $matches[1];
                $idViejo = (int) $matches[2];
                $valores = $matches[3];

                /*
                 * Conservamos $valores EXACTAMENTE como vienen.
                 * Así no perdemos las comillas de los valores de texto.
                 */

                $sql = "INSERT INTO `nota_envio` ({$columnas}) VALUES ({$valores});";

                DB::unprepared($sql);

                /*
                 * Recuperamos el Id generado por AUTO_INCREMENT.
                 */

                $idNuevo = (int) DB::getPdo()->lastInsertId();

                if ($idNuevo <= 0) {
                    throw new RuntimeException(
                        "No se pudo obtener el nuevo Id para la nota {$idViejo}"
                    );
                }

                /*
                 * Guardamos:
                 *
                 * 2723 => 4
                 * 2724 => 5
                 * 2725 => 6
                 * ...
                 */

                $mapaIdsNotas[$idViejo] = $idNuevo;

                $totalNotasImportadas++;

                $this->command->info(
                    "Nota {$idViejo} -> {$idNuevo}"
                );
            }

            fclose($handle);


            /*
             * ============================================================
             * 2. IMPORTAR item_nota_envio
             * ============================================================
             */

            $rutaItems = database_path('sql/item_nota_envio.sql');

            if (!file_exists($rutaItems)) {
                throw new RuntimeException(
                    "No existe el archivo: {$rutaItems}"
                );
            }

            $handle = fopen($rutaItems, 'r');

            if (!$handle) {
                throw new RuntimeException(
                    "No se pudo abrir: {$rutaItems}"
                );
            }

            while (($linea = fgets($handle)) !== false) {

                $linea = trim($linea);

                if ($linea === '') {
                    continue;
                }

                /*
                 * Original:
                 *
                 * INSERT INTO `item_nota_envio`
                 * (`ID`, `IdNotaEnvio`, `IdItemOrdenTrabajo`, ...)
                 * VALUES (17698, 2734, 97941, ...);
                 *
                 * Queremos:
                 *
                 * INSERT INTO `item_nota_envio`
                 * (`IdNotaEnvio`, `IdItemOrdenTrabajo`, ...)
                 * VALUES (5, NULL, ...);
                 *
                 * Es decir:
                 *
                 * 1. Quitamos el ID viejo.
                 * 2. Cambiamos IdNotaEnvio por el nuevo.
                 * 3. Ponemos IdItemOrdenTrabajo en NULL.
                 * 4. Dejamos que MySQL genere el nuevo ID.
                 */

                $patron = '/^INSERT INTO `item_nota_envio` \(`ID`, `IdNotaEnvio`, `IdItemOrdenTrabajo`, (.*)\) VALUES \((\d+), (\d+), (\d+), (.*)\);$/';

                if (!preg_match($patron, $linea, $matches)) {
                    throw new RuntimeException(
                        "No se pudo interpretar esta línea de item_nota_envio:\n{$linea}"
                    );
                }

                /*
                 * ID viejo del item.
                 */

                $idItemViejo = (int) $matches[2];

                /*
                 * IdNotaEnvio viejo.
                 */

                $idNotaViejo = (int) $matches[3];

                /*
                 * IdItemOrdenTrabajo viejo.
                 * Lo obtenemos solamente para mostrarlo/loguearlo.
                 */

                $idItemOrdenTrabajoViejo = (int) $matches[4];

                /*
                 * Verificamos que exista el mapeo de la nota.
                 */

                if (!isset($mapaIdsNotas[$idNotaViejo])) {
                    throw new RuntimeException(
                        "No existe mapeo para IdNotaEnvio {$idNotaViejo}"
                    );
                }

                /*
                 * Nuevo IdNotaEnvio.
                 */

                $idNotaNuevo = $mapaIdsNotas[$idNotaViejo];

                /*
                 * Columnas después de IdItemOrdenTrabajo.
                 */

                $columnasRestantes = $matches[1];

                /*
                 * Valores después de IdItemOrdenTrabajo.
                 */

                $valoresRestantes = $matches[5];

                /*
                 * Insertamos SIN el ID viejo.
                 *
                 * MySQL generará automáticamente el nuevo ID.
                 */

                $sql = "
                    INSERT INTO `item_nota_envio`
                    (`IdNotaEnvio`, `IdItemOrdenTrabajo`, {$columnasRestantes})
                    VALUES
                    ({$idNotaNuevo}, NULL, {$valoresRestantes});
                ";

                DB::unprepared($sql);

                /*
                 * Recuperamos el nuevo ID generado.
                 */

                $idItemNuevo = (int) DB::getPdo()->lastInsertId();

                if ($idItemNuevo <= 0) {
                    throw new RuntimeException(
                        "No se pudo obtener el nuevo ID del item {$idItemViejo}"
                    );
                }

                /*
                 * Guardamos:
                 *
                 * 17698 => 1
                 * 17697 => 2
                 * ...
                 */

                $mapaIdsItems[$idItemViejo] = $idItemNuevo;

                $totalItemsImportados++;

                $this->command->info(
                    "Item {$idItemViejo} -> {$idItemNuevo} | " .
                    "Nota {$idNotaViejo} -> {$idNotaNuevo} | " .
                    "IdItemOrdenTrabajo {$idItemOrdenTrabajoViejo} -> NULL"
                );
            }

            fclose($handle);
        });

        /*
         * ============================================================
         * RESUMEN
         * ============================================================
         */

        $this->command->info('');
        $this->command->info('==========================================');
        $this->command->info('Importación completada correctamente.');
        $this->command->info("Total de notas importadas: {$totalNotasImportadas}");
        $this->command->info("Total de items importados: {$totalItemsImportados}");
        $this->command->info('==========================================');
    }
}