<?php

namespace App\Http\Controllers;

use App\Models\Geometry;
use App\Http\Requests\StoreGeometryRequest;
use App\Http\Requests\UpdateGeometryRequest;

class GeometryController extends Controller
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
     * @param  \App\Http\Requests\StoreGeometryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGeometryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Geometry  $Geometry
     * @return \Illuminate\Http\Response
     */
    public function show(Geometry $geometry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function edit(Geometry $geometry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGeometryRequest  $request
     * @param  \App\Models\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGeometryRequest $request, Geometry $geometry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Geometry $geometry)
    {
        //
    }
}
