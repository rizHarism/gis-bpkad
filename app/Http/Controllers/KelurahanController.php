<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KelurahanController extends Controller
{
    //
    public function index()
    {
        $kelurahan = Kelurahan::orderBy('nama_kelurahan', 'ASC')->get()->all();
        $response = [
            'message' => 'semua data kelurahan',
            'count' => count($kelurahan),
            'data' => $kelurahan
        ];
        // dd($response);
        return response()->json($response, Response::HTTP_OK);
    }
}
