<?php

namespace Database\Seeders;

use App\Models\Skpd;
use Illuminate\Database\Seeder;

class SkpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //
        Skpd::truncate();

        $csvFile = fopen(base_path("database/data/master_skpd.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Skpd::create([
                    "id_skpd" => $data["0"],
                    "nama_skpd" => $data["1"],
                    "kode_skpd" => $data["2"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
