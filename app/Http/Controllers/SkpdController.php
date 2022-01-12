<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use App\Http\Requests\StoreSkpdRequest;
use App\Http\Requests\UpdateSkpdRequest;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class SkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('opd.index');
    }

    public function datatables()
    {
        $datatables = DataTables::of(Skpd::get())->addIndexColumn();
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
        return view('opd.form');
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
            'kode_opd' => 'required|unique:master_skpd,kode_skpd',
            'nama_opd' => 'required',
        ]);

        $skpd = Skpd::create([
            'nama_skpd' => $request->nama_opd,
            'kode_skpd' => $request->kode_opd
        ]);

        if ($skpd) {
            return response("OPD sudah berhasil ditambahkan!");
        } else {
            return response("OPD gagal ditambahkan!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @param String    $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $skpd = Skpd::findOrFail($id);
        return view('opd.form', ['edit' => $skpd]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String    $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $skpd = Skpd::findOrFail($id);

        $validations['nama_opd'] = ['required'];

        if ($skpd->kode_skpd != $request->kode_opd) {
            $validations['kode_opd'] = 'required|unique:master_skpd,kode_skpd';
        }
        $this->validate($request, $validations);

        $skpd->kode_skpd = $request->kode_opd;
        $skpd->nama_skpd = $request->nama_opd;

        if ($skpd->save()) {
            return response("OPD sudah berhasil diubah!");
        } else {
            return response("OPD gagal diubah!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String    $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $skpd = Skpd::findOrFail($id);
        if ($skpd->delete()) {
            return response("OPD sudah berhasil dihapus");
        } else {
            return response("OPD gagal dihapus", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
