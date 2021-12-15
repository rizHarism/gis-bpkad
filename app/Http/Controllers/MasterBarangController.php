<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Http\Requests\StoreMasterBarangRequest;
use App\Http\Requests\UpdateMasterBarangRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

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
        $datatables = DataTables::of(MasterBarang::get())->addIndexColumn();
        return $datatables->make(true);

        dd($datatables);

        // $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd', 'geometry'))
        //     ->addIndexColumn()
        //     ->make(true);
        // // return $datatables->make(true);
        // return $inventaris;
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
     * @param  \App\Http\Requests\StoreMasterBarangRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMasterBarangRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $master_barang = MasterBarang::where('id', $id)->get();
        $response = [
            'messagge' => 'Data Master Barang',
            'data' => $master_barang
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterBarang $masterBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMasterBarangRequest  $request
     * @param  \App\Models\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMasterBarangRequest $request, MasterBarang $masterBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterBarang  $masterBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterBarang $masterBarang)
    {
        //
    }
}
