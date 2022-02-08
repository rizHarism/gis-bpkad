<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Document::truncate();

        $csvFile = fopen(base_path("database/data/sertifikat-seeder.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Document::create([
                    "inventaris_id" => $data["1"],
                    "doc_path" => $data["2"],
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }
}
