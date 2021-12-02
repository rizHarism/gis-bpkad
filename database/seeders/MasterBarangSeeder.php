<?php

namespace Database\Seeders;

use App\Models\MasterBarang;
use Illuminate\Database\Seeder;

class MasterBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MasterBarang::truncate();

        $csvFile = fopen(base_path("database/data/master_barang.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                MasterBarang::create([
                    "id" => $data["0"],
                    "nama" => $data["1"],
                    "kode_barang" => $data["2"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
