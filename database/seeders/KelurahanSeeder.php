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

        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Blitar']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Karangsari']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Pakunden']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Sukorejo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Tanjungsari']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Tlumpu']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Turi']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Bendo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Kauman']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Kepanjenkidul']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Kepanjenlor']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Ngadirejo']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Sentul']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Tanggung']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Bendogerit']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Gedog']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Karangtengah']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Klampok']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Plosokerep']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Rembang']);
        Kelurahan::firstOrCreate(['nama_kelurahan' => 'Kelurahan Sananwetan']);
    }
}
