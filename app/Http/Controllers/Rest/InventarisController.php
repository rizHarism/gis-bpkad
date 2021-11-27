<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $inventaris = Inventaris::get()->all();
        $nonSertifikat = Inventaris::where('status', 0)->GET();
        $sertifikat = Inventaris::where('status', 1)->GET();
        $count_all = count($inventaris);
        $count_not_sertifikat = count($nonSertifikat);
        $count_sertifikat = count($sertifikat);

        $response = [
            'message' => 'List Data Transaksi order by time',
            // 'data' => $sertifikat
            'data' => $inventaris,
            'total_aset' => $count_all,
            'bersertifikat' => $count_sertifikat,
            'tidak_bersertifikat' => $count_not_sertifikat,
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function dashboard()
    {
        //
        $inventaris = Inventaris::get()->all();
        $nonSertifikat = Inventaris::where('status', 0)->GET();
        $sertifikat = Inventaris::where('status', 1)->GET();
        $count_all = count($inventaris);
        $count_not_sertifikat = count($nonSertifikat);
        $count_sertifikat = count($sertifikat);

        $response = [
            'message' => 'List Data Transaksi order by time',
            // 'data' => $sertifikat
            'total_aset' => $count_all,
            'bersertifikat' => $count_sertifikat,
            'tidak_bersertifikat' => $count_not_sertifikat,
            // 'data' => $inventaris
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
        //
        // $inventaris = Inventaris::findOrFail($id);
        $inventaris = Inventaris::where('id', $id)->get();

        $response = [
            'message' => "Detail Transaksi",
            'data' => $inventaris
        ];
        // dd($response);
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

        // dd($validator);

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
