<?php

namespace Database\Seeders;

use App\Models\Inventaris;
use Illuminate\Database\Seeder;

class InventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //run
        Inventaris::truncate();

        $csvFile = fopen(base_path("database/data/inventaris-new.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Inventaris::create([
                    "id" => $data["0"],
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
                    "no_dokumen_sertifikat" => $data["11"],
                    "skpd_id" => $data["12"],
                    "master_barang_id" => $data["13"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
