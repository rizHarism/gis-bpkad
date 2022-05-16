<?php

namespace App\Http\Controllers;

use App\Models\InventarisBangunan;
use App\Models\Document;
use App\Models\Galery;
use App\Models\Geometry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\Inventaris;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MasterBarang;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App;

class InventarisBangunanController extends Controller
{
    public function index()
    {
        return view('inventaris.gedung.index');
    }

    public function getInventarisGedung()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        $inventaris = DataTables::of(InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'pemeliharaan', 'galery', 'document'))
            ->addIndexColumn()
            ->make(true);

        // return $datatables->make(true);
        return $inventaris;
    }
    public function querySkpd($skpd_id)
    {
        if ($skpd_id === 'Semua OPD') {
            $inventarisBangunan =  InventarisBangunan::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry', 'pemeliharaan')
                ->has('geometry')
                ->get();
        } else {
            $inventarisBangunan =  InventarisBangunan::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry', 'pemeliharaan')
                ->where('skpd_id',  $skpd_id)->has('geometry')
                // ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                // ->where('status',  $status)->has('geometry')
                ->get();
        }
        $response = [
            'message' => 'List Query Pencarian Data',
            'count' => count($inventarisBangunan),
            'data' => $inventarisBangunan
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        //Menampilkan satuan data inventaris
        $inventaris = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->where('id', $id)->get();

        $response = [
            'message' => "Detail Inventaris",
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }
}
