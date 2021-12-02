<?php

namespace App\Http\Controllers;

use App\Models\MasterBarang;
use App\Http\Requests\StoreMasterBarangRequest;
use App\Http\Requests\UpdateMasterBarangRequest;

class MasterBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show(MasterBarang $masterBarang)
    {
        //
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
