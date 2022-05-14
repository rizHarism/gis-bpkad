<?php

namespace Database\Seeders;

use App\Models\Galery;
use App\Models\InventarisBangunan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            SkpdSeeder::class,
            PermissionsSeeder::class,
            MasterBarangSeeder::class,
            InventarisSeeder::class,
            GeometrySeeder::class,
            KelurahanSeeder::class,
            KecamatanSeeder::class,
            GalerySeeder::class,
            DocumentSeeder::class,
            InventarisBangunanSeeder::class,
            PemeliharaanBangunanSeeder::class
        ]);
    }
}
