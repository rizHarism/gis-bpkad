<?php

namespace Database\Seeders;

use App\Models\Geometry;
use Illuminate\Database\Seeder;

class GeometrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Geometry::truncate();

        $csvFile = fopen(base_path("database/data/geometry-seed-new-v2.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Geometry::create([
                    "inventaris_id" => $data["1"],
                    "polygon" => $data["2"],
                    "lat" => $data["3"],
                    "lng" => $data["4"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
