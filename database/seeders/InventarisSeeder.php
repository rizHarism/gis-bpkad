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
                    "tahun_perolehan" => $data["3"],
                    "nilai_aset" => $data["4"],
                    "luas" => $data["5"],
                    "status" => $data["6"],
                    "alamat" => $data["7"],
                    "kelurahan_id" => $data["8"],
                    "kecamatan_id" => $data["9"],
                    "no_dokumen_sertifikat" => $data["10"],
                    "skpd_id" => $data["11"],
                    "master_barang_id" => $data["12"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
