<?php

namespace Database\Seeders;

use App\Models\InventarisBangunan;
use Illuminate\Database\Seeder;

class InventarisBangunanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //run
        InventarisBangunan::truncate();

        $csvFile = fopen(base_path("database/data/inventaris_c.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                InventarisBangunan::create([
                    "id_inventaris" => $data["0"],
                    "jenis_inventaris" => $data["1"],
                    "nama" => $data["2"],
                    "no_register" => $data["3"],
                    "tahun_perolehan" => $data["4"],
                    "nilai_aset" => $data["5"],
                    "luas" => $data["6"],
                    "status" => $data["7"],
                    "alamat" => $data["8"],
                    "kelurahan_id" => $data["9"],
                    "kecamatan_id" => $data["10"],
                    "kondisi_bangunan" => $data["11"],
                    "jenis_bangunan" => $data["12"],
                    "jenis_konstruksi" => $data["13"],
                    // "no_dokumen_sertifikat" => $data["14"],
                    "skpd_id" => $data["14"],
                    "master_barang_id" => $data["15"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
