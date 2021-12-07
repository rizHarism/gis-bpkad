<?php

namespace App\Http\Controllers;

use App\Models\skpd;
use App\Http\Requests\StoreskpdRequest;
use App\Http\Requests\UpdateskpdRequest;
use Symfony\Component\HttpFoundation\Response;

class SkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //call all data skpd from skpd table
        $skpd = Skpd::get()->all();
        $response = [
            'message' => 'semua data skpd',
            'count' => count($skpd),
            'data' => $skpd
        ];
        // dd($response);
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
     * @param  \App\Http\Requests\StoreskpdRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreskpdRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function show(skpd $skpd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function edit(skpd $skpd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateskpdRequest  $request
     * @param  \App\Models\skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateskpdRequest $request, skpd $skpd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\skpd  $skpd
     * @return \Illuminate\Http\Response
     */
    public function destroy(skpd $skpd)
    {
        //
    }
}
