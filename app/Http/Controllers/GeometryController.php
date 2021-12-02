<?php

namespace App\Http\Controllers;

use App\Models\geometry;
use App\Http\Requests\StoregeometryRequest;
use App\Http\Requests\UpdategeometryRequest;

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
     * @param  \App\Http\Requests\StoregeometryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregeometryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function show(geometry $geometry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function edit(geometry $geometry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategeometryRequest  $request
     * @param  \App\Models\geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdategeometryRequest $request, geometry $geometry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\geometry  $geometry
     * @return \Illuminate\Http\Response
     */
    public function destroy(geometry $geometry)
    {
        //
    }
}
