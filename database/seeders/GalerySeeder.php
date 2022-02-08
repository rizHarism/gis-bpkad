<?php

namespace Database\Seeders;

use App\Models\Galery;
use Illuminate\Database\Seeder;

class GalerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Galery::truncate();

        $csvFile = fopen(base_path("database/data/image-seeder.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Galery::create([
                    "inventaris_id" => $data["1"],
                    "image_path" => $data["2"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
