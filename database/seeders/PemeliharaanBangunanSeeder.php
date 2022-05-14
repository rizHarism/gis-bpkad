<?php

namespace Database\Seeders;

use App\Models\PemeliharaanInventarisBangunan;
use Illuminate\Database\Seeder;

class PemeliharaanBangunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PemeliharaanInventarisBangunan::truncate();

        $csvFile = fopen(base_path("database/data/pemeliharaan_inventaris_c.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                PemeliharaanInventarisBangunan::create([
                    "inventaris_id" => $data["0"],
                    "nama_pemeliharaan" => $data["1"],
                    "tahun_pemeliharaan" => $data["2"],
                    "nilai_aset" => $data["3"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
