<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Kelurahan::truncate();

        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Blitar']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Karangsari']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Pakunden']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Sukorejo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Tanjungsari']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Tlumpu']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Turi']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Bendo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kauman']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kepanjenkidul']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kepanjenlor']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Ngadirejo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Sentul']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Tanggung']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Bendogerit']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Gedog']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Karangtengah']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Klampok']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Plosokerep']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Rembang']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Sananwetan']);
    }
}
