<?php

namespace App\Http\Controllers;

use App\Models\Geometry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\Inventaris;
use App\Models\MasterBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // Menampilkan semua data Inventaris
        $inventaris = Inventaris::with('master_barang:id,nama', 'master_skpd:id,nama', 'geometry:id,inventaris_id,polygon')
            ->get();
        $response = [
            'message' => 'Data Inventaris',
            'count' => count($inventaris),
            'data' => $inventaris
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function dashboard()
    {
        //count Total Aset Tanah bersertifikat pada Halaman Dashboard
        $inventaris = count(Inventaris::get()->all());
        $non_sertifikat = count(Inventaris::where('status', 0)->GET());
        $sertifikat = count(Inventaris::where('status', 1)->GET());

        //count aset bersertifikat terpetakan
        $mapped_sertifikat = count(Inventaris::with('geometry')
            ->has('geometry')
            ->get());
        $not_mapped_inventaris = $sertifikat - $mapped_sertifikat;

        $response = [
            'message' => 'List Data Transaksi order by time',
            // 'data' => $sertifikat
            'total_aset' => $inventaris,
            'bersertifikat' => $sertifikat,
            'tidak_bersertifikat' => $non_sertifikat,
            'terpetakan' => $mapped_sertifikat,
            'belum_terpetakan' => $not_mapped_inventaris

        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function getInventaris()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        // DB::statement(DB::raw('set @rownum=0'));

        // $inventaris = Inventaris::select([
        // DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        //     'id',
        //     'jenis_inventaris',
        //     'nama',
        //     'tahun_perolehan',
        //     'nilai_aset',
        //     'luas',
        //     'status',
        //     'alamat',
        //     'no_dokumen_sertifikat',
        //     'master_barang_id',
        //     'skpd_id',
        // ])->with('master_barang:id as id_barang, ', 'master_skpd');

        // $datatables = Datatables::of($inventaris);

        $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd'))
            ->make(true);
        // return $datatables->make(true);
        return $inventaris;
    }

    public function searchInventaris($keyword)
    {
        // fitur pencarian pada halaman Peta Sebaran aset (index)
        $inventaris = Inventaris::with('master_barang:id,nama')
            ->with('master_skpd:id,nama')
            ->with('geometry:id,inventaris_id,polygon,lat,lng')
            ->where('nama', 'like', "%" . $keyword . "%")->has('geometry')
            ->orWhereHas('master_barang', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%" . $keyword . "%");
            })->has('geometry')
            ->orWhereHas('master_skpd', function ($q) use ($keyword) {
                $q->where('nama', 'like', "%" . $keyword . "%");
            })->has('geometry')
            ->get();

        $response = [
            'message' => 'List Pencarian Data',
            'jumlah' => count($inventaris),
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }



    public function queryInventaris($status, $skpd_id /*, $kelurahan_id*/)
    {

        // query inventaris untuk pencarian data geometry/polygon (filterisasi)
        if ($skpd_id === 'Semua SKPD' /* && $kelurahan_id === 'Semua Kelurahan' */) {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry')
                ->has('geometry')
                ->get();
        } else {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry')
                ->where('skpd_id',  $skpd_id)->has('geometry')
                // ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                ->where('status',  $status)->has('geometry')
                ->get();
        }

        $response = [
            'message' => 'List Query Pencarian Data',
            'count' => count($inventaris),
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Menampilkan satuan data inventaris
        $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry', 'galery', 'document')->where('id', $id)->get();

        $response = [
            'message' => "Detail Inventaris",
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventaris $Inventaris)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $inventaris = Inventaris::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'polygon' => ['required'],
            'jenis_inventaris' => ['required']

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $inventaris->update($request->all());
            $response = [
                'message' => 'Inventaris Geometry Update',
                'data' => $inventaris
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventaris $Inventaris)
    {
        //
    }
}
