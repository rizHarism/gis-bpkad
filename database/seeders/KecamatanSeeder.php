<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Kecamatan::firstOrCreate(['nama_kecamatan' => 'Kecamatan Sananwetan']);
        Kecamatan::firstOrCreate(['nama_kecamatan' => 'Kecamatan Kepanjenkidul']);
        Kecamatan::firstOrCreate(['nama_kecamatan' => 'Kecamatan Sukorejo']);
    }
}
