<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Http\Requests\StoreSkpdRequest;
use App\Http\Requests\UpdateSkpdRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //call all data Skpd from Skpd table
        // $datatables = DataTables::of(Skpd::get())->addIndexColumn();
        $datatables = DataTables::of(Skpd::get())->addIndexColumn();
        return $datatables->make(true);

        // dd($datatables);
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
     * @param  \App\Http\Requests\StoreSkpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSkpdRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function show(Skpd $skpd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function edit(Skpd $skpd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSkpdRequest  $request
     * @param  \App\Models\Skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSkpdRequest $request, Skpd $skpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skpd $skpd)
    {
        //
    }
}
