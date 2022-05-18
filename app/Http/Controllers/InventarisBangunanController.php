<?php

namespace App\Http\Controllers;

use App\Models\InventarisBangunan;
use App\Models\Document;
use App\Models\Galery;
use App\Models\Geometry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
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
        $inventarisBangunan = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->where('id', $id)->get();

        $response = [
            'message' => "Detail Inventaris",
            'data' => $inventarisBangunan
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function create()
    {
        //
        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        $skpd = Skpd::get();
        $master_barang = MasterBarang::get();
        // $geometry = Geometry::where('inventaris_id', $id)->get();
        // $galery = Galery::get();
        // $document = Document::get();
        return view('inventaris.gedung.form', [
            // 'edit' => $inventaris,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'skpd' => $skpd,
            'barang' => $master_barang
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        // dd($request->status);
        $this->validate($request, [
            'nama_inventaris' => 'required',
            'tahun' => 'required',
            'nilai_aset' => 'required',
            'luas' => 'required',
            'status' => 'required',
            'kode_gedung' => 'required',
            'no_register' => 'required',
            'kondisi_bangunan' => 'required',
            'jenis_bangunan' => 'required',
            'jenis_konstruksi' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            // 'no_sertifikat' => 'required',
            'skpd' => 'exists:master_skpd,id_skpd',
            'barang' => 'exists:master_barang,id_barang',
        ]);
        try {
            DB::beginTransaction();
            $inventarisBangunan = InventarisBangunan::create([

                'id_inventaris' => $request->id_inventaris,
                'nama' => $request->nama_inventaris,
                'jenis_inventaris' => 'A',
                'tahun_perolehan' => $request->tahun,
                'nilai_aset' => $request->nilai_aset,
                'luas' => $request->luas,
                'kode_gedung' => $request->kode_gedung,
                'status' => $request->status,
                'kondisi_bangunan' => $request->kondisi_bangunan,
                'jenis_bangunan' => $request->jenis_bangunan,
                'jenis_konstruksi' => $request->jenis_konstruksi,
                'no_register' => $request->no_register,
                'alamat' => $request->alamat,
                'kelurahan_id' => $request->kelurahan,
                'kecamatan_id' => $request->kecamatan,
                'skpd_id' => $request->skpd,
                'master_barang_id' => $request->barang,
            ]);

            if (!empty($request->polygon)) {

                $geometry = Geometry::create([
                    'inventaris_id' => $request->id_inventaris,
                    'polygon' => $request->polygon,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ]);
            }

            if ($request->hasfile('image')) {
                $name = $request->file('image')->getClientOriginalName();
                $galery = Galery::create([
                    'inventaris_id' => $request->id_inventaris,
                    'image_path' => $name
                ]);
                $request->file('image')->move(public_path('assets/galery'), $name);
            }

            if ($request->hasfile('penanda')) {
                $name = $request->file('penanda')->getClientOriginalName();
                $document = Document::create([
                    'inventaris_id' => $request->id_inventaris,
                    'doc_path' => $name
                ]);
                $request->file('penanda')->move(public_path('assets/document'), $name);
            }

            // dd($inventaris, $geometry, $galery, $document);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Data Inventaris Berhasil Ditambahkan");
    }




    //destroy inventaris bangunan
    public function destroy(Request $request, $id)
    {
        //
        $inventarisBangunan = InventarisBangunan::findOrFail($id);
        $geometry = Geometry::where('inventaris_id', $inventarisBangunan->id_inventaris);
        $galery = Galery::where('inventaris_id', $inventarisBangunan->id_inventaris);
        // $fileGalery = Galery::where('inventaris_id', $id)->firstOrFail();
        $document = Document::where('inventaris_id', $inventarisBangunan->id_inventaris);
        // $geometry = Geometry::find
        // dd($galery->value('image_path'), $document->pluck('doc_path'));
        // dd($galery, $document, $geometry);
        try {
            $inventarisBangunan->delete();
            if ($geometry) {
                $geometry->delete();
            }
            if (File::exists(public_path('assets/galery/' . $galery->value('image_path')))) {
                File::delete(public_path('assets/galery/' . $galery->value('image_path')));
            }
            if (File::exists(public_path('assets/document/' . $document->value('doc_path')))) {
                File::delete(public_path('assets/document/' . $document->value('doc_path')));
            }
            if ($galery) {
                $galery->delete();
            }
            if ($document) {
                $document->delete();
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return response("Inventaris Berhasil Dihapus");
    }
}
