<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Http\Requests\StoreMasterBarangRequest;
use App\Http\Requests\UpdateMasterBarangRequest;
use App\Models\Inventaris;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //call master barang
        // DB::statement(DB::raw('set @rownum=0'));
        // $master_barang = MasterBarang::select([
        //     DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        //     'id',
        //     'nama',
        //     'kode_barang'
        // ]);
        // $datatables = DataTables::of(MasterBarang::get())->addIndexColumn();
        // return $datatables->make(true);
        return view('bmd.index');
        // dd($datatables);

        // $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd', 'geometry'))
        //     ->addIndexColumn()
        //     ->make(true);
        // // return $datatables->make(true);
        // return $inventaris;
    }

    public function datatables()
    {
        $datatables = DataTables::of(MasterBarang::get())->addIndexColumn();
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bmd.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_barang' => 'required|unique:master_barang,kode_barang',
            'nama_barang' => 'required',
        ]);

        $masterBarang = MasterBarang::create([
            'nama_barang' => $request->nama_barang,
            'kode_barang' => $request->kode_barang
        ]);

        if ($masterBarang) {
            return response("Master Barang sudah berhasil ditambahkan!");
        } else {
            return response("Master Barang gagal ditambahkan!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        // $master_barang = MasterBarang::where('id', $id)->get();
        $master_barang = MasterBarang::findOrFail($id);
        $response = [
            'messagge' => 'Data Master Barang',
            'data' => $master_barang
        ];
        return response()->json($master_barang->nama_barang, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $masterBarang = MasterBarang::findOrFail($id);
        return view('bmd.form', ['edit' => $masterBarang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String   $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $masterBarang = MasterBarang::findOrFail($id);

        $validations['nama_barang'] = ['required'];

        if ($masterBarang->kode_barang != $request->kode_barang) {
            $validations['kode_barang'] = 'required|unique:master_barang,kode_barang';
        }
        $this->validate($request, $validations);

        $masterBarang->kode_barang = $request->kode_barang;
        $masterBarang->nama_barang = $request->nama_barang;

        if ($masterBarang->save()) {
            return response("Master Barang sudah berhasil diubah!");
        } else {
            return response("Master Barang gagal diubah!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $masterBarang = MasterBarang::findOrFail($id);
        $cekExist = Inventaris::where('master_barang_id', $id);
        if ($cekExist->doesntExist()) {
            if ($masterBarang->delete()) {
                return response([
                    'value' => 1,
                    'message' => "Master Barang \"" . $masterBarang->nama_barang . "\" berhasil dihapus"
                ]);
            } else {
                return response("Master Barang gagal dihapus", Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        } else {
            return response([
                'value' => 0,
                'message' => "Data Barang \"" . $masterBarang->nama_barang . "\" tidak dapat dihapus karena data sedang digunakan"
            ]);
        }
    }
}
