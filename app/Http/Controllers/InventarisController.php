<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Galery;
use App\Models\Geometry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Models\Inventaris;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\MasterBarang;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;
use App;
use App\Models\InventarisBangunan;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('inventaris.index');
    }

    public function indexJaringan()
    {
        return view('inventaris.jaringan.index');
    }

    function fetch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Inventaris::with('master_barang:id_barang,nama_barang')
                ->with('master_skpd:id_skpd,nama_skpd')
                ->with('geometry:id,inventaris_id,polygon,lat,lng')
                ->where('nama', 'like', "%" . $query . "%")->has('geometry')
                ->orWhereHas('master_barang', function ($q) use ($query) {
                    $q->where('nama_barang', 'like', "%" . $query . "%");
                })->has('geometry')
                ->orWhereHas('master_skpd', function ($q) use ($query) {
                    $q->where('nama_skpd', 'like', "%" . $query . "%");
                })->has('geometry')
                ->get();
            // dd($data);
            if ($data === '') {
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                $output .= '<li class="dropdown-item"><div>Data tidak ada</div></li>';
                $output .= '</ul>';
            } else {

                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $output .= '<li class="dropdown-item" value="' . $row->id . '"><div>' . $row->nama . " - " . $row->master_skpd->nama_skpd . '</div> </li>';
                    // $output .= '<input id="idInventaris" type="text" value="' . $row->id . '"></input>';
                }
                $output .= '</ul>';
            }

            echo $output;
        }
    }

    public function get_geometry($kecamatan_id)
    {
        // Menampilkan semua data Inventaris
        $inventaris = Inventaris::with('master_barang:id_barang,nama_barang,kode_barang', 'kecamatan:id_kecamatan,nama_kecamatan', 'master_skpd:id_skpd,nama_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry:id,inventaris_id,polygon,lat,lng')->has('geometry')
            ->where('kecamatan_id', $kecamatan_id)
            ->get();
        $response = [
            'message' => 'Data Inventaris',
            'count' => count($inventaris),
            'data' => $inventaris
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function dashboard()
    {
        //count Total Aset Tanah bersertifikat pada Halaman Dashboard
        $inventaris = count(Inventaris::get()->all());
        $non_sertifikat = count(Inventaris::where('status', 0)->GET());
        $sertifikat = count(Inventaris::where('status', 1)->GET());
        $inventarisGedung = count(InventarisBangunan::get()->all());
        $inventarisGedungTerpetakan = count(InventarisBangunan::with('geometry')->has('geometry')->GET());
        // $inventarisBangunan =  InventarisBangunan::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry', 'pemeliharaan')
        //         ->has('geometry')
        //         ->get();
        // $sertifikat = count(Inventaris::where('status', 1)->GET());

        //count aset bersertifikat terpetakan
        $mapped_sertifikat = count(Inventaris::with('geometry')
            ->where('status', 1)
            ->has('geometry')
            ->get());
        $not_mapped_inventaris = $sertifikat - $mapped_sertifikat;

        $inventaris_sertifikat_belum_ketemu = Inventaris::with('document', 'master_skpd:nama_skpd,id_skpd', 'master_barang:nama_barang,id_barang')->where('status', 1)->doesnthave('document')->get();

        $response = [
            'message' => 'List Data Transaksi order by time',
            // 'data' => $sertifikat
            'total_aset' => $inventaris,
            'bersertifikat' => $sertifikat,
            'tidak_bersertifikat' => $non_sertifikat,
            'terpetakan' => $mapped_sertifikat,
            'belum_terpetakan' => $not_mapped_inventaris,
            'aset_gedung' => '998',
            'aset_gedung_terinvetaris' => $inventarisGedung,
            'aset_gedung_terpetakan' => $inventarisGedungTerpetakan,
            'jumlah_inventaris_sertifikat_ketemu' => count($inventaris_sertifikat_belum_ketemu),
            'inventaris_sertifikat_belum_ketemu' => $inventaris_sertifikat_belum_ketemu

        ];

        return response()->json($response, Response::HTTP_OK);
        // return response($response, Response::HTTP_OK);
    }

    public function getInventaris()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd', 'geometry'))
            ->addIndexColumn()
            ->make(true);

        // return $datatables->make(true);
        return $inventaris;
    }

    public function getInventarisSertifikat()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd', 'geometry')->where('status', 1))
            ->addIndexColumn()
            ->make(true);
        // return $datatables->make(true);
        // dd($inventaris);
        return $inventaris;
    }

    public function getInventarisNonSertifikat()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        $inventaris = DataTables::of(Inventaris::with('master_barang', 'master_skpd', 'geometry')->where('status', 0))
            ->addIndexColumn()
            ->make(true);
        // return $datatables->make(true);
        // dd($inventaris);
        return $inventaris;
    }

    public function searchInventaris($keyword)
    {
        // fitur pencarian pada halaman Peta Sebaran aset (index)
        $inventaris = Inventaris::with('master_barang:id_barang,nama_barang')
            ->with('master_skpd:id_skpd,nama_skpd')
            ->with('geometry:id,inventaris_id,polygon,lat,lng')
            ->where('nama', 'like', "%" . $keyword . "%")->has('geometry')
            ->orWhereHas('master_barang', function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', "%" . $keyword . "%");
            })->has('geometry')
            ->orWhereHas('master_skpd', function ($q) use ($keyword) {
                $q->where('nama_skpd', 'like', "%" . $keyword . "%");
            })->has('geometry')
            ->get();

        $response = [
            'message' => 'List Pencarian Data',
            'jumlah' => count($inventaris),
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }



    public function queryKelSkpd($kelurahan_id, $skpd_id)
    {

        // dd($skpd_id, $kelurahan_id);
        // query inventaris untuk pencarian data geometry/polygon (filterisasi)git
        if ($skpd_id === 'Semua OPD'  && $kelurahan_id === 'Semua Kelurahan') {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                ->has('geometry')
                ->get();
        } elseif ($skpd_id === 'Semua OPD') {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                // ->where('skpd_id',  $skpd_id)->has('geometry')
                ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                // ->where('status',  $status)->has('geometry')
                ->get();
        } elseif ($kelurahan_id === 'Semua Kelurahan') {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                ->where('skpd_id',  $skpd_id)->has('geometry')
                // ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                // ->where('status',  $status)->has('geometry')
                ->get();
        } else {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                ->where('skpd_id',  $skpd_id)->has('geometry')
                ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                // ->where('status',  $status)->has('geometry')
                ->get();
        }

        $response = [
            'message' => 'List Query Pencarian Data',
            'count' => count($inventaris),
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function queryKelSertifikat($kelurahan_id, $noSertifikat)
    {

        // $kelurahan = Kelurahan::findOrFail($kelurahan_id);
        if ($kelurahan_id === 'Semua Kelurahan') {
            $validasi = Inventaris::with('kelurahan', 'geometry')
                ->where('no_dokumen_sertifikat', $noSertifikat)->has('geometry')
                ->first();
        } else {
            $validasi = Inventaris::with('kelurahan', 'geometry')
                ->where('no_dokumen_sertifikat', $noSertifikat)->has('geometry')
                ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                ->first();
        }
        if (!$validasi) {
            $inventaris = 0;
        } else {
            if ($kelurahan_id === 'Semua Kelurahan') {
                $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                    ->where('no_dokumen_sertifikat',  $noSertifikat)->has('geometry')
                    // ->where('status',  $status)->has('geometry')
                    ->get();
            } else {
                $inventaris = Inventaris::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry')
                    ->where('no_dokumen_sertifikat',  $noSertifikat)->has('geometry')
                    ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                    // ->where('status',  $status)->has('geometry')
                    ->get();
            }
        }
        $response = [
            'message' => 'List Query Pencarian Data',
            'data' => $inventaris
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
        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        $skpd = Skpd::get();
        $master_barang = MasterBarang::get();
        // $geometry = Geometry::where('inventaris_id', $id)->get();
        // $galery = Galery::get();
        // $document = Document::get();
        return view('inventaris.form', [
            // 'edit' => $inventaris,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'skpd' => $skpd,
            'barang' => $master_barang
        ]);
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
        // dd($request->all());
        // dd($request->status);
        $this->validate($request, [
            'nama_inventaris' => 'required',
            'tahun' => 'required',
            'nilai_aset' => 'required',
            'luas' => 'required',
            'status' => 'required',
            'no_register' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            // 'no_sertifikat' => 'required',
            'skpd' => 'exists:master_skpd,id_skpd',
            'barang' => 'exists:master_barang,id_barang',
        ]);
        try {
            DB::beginTransaction();
            $inventaris = Inventaris::create([
                'nama' => $request->nama_inventaris,
                // 'nama' => $request->nama,
                'jenis_inventaris' => 'A',
                'tahun_perolehan' => $request->tahun,
                'nilai_aset' => $request->nilai_aset,
                'luas' => $request->luas,
                'status' => $request->status,
                'no_register' => $request->no_register,
                'alamat' => $request->alamat,
                'kelurahan_id' => $request->kelurahan,
                'kecamatan_id' => $request->kecamatan,
                'no_dokumen_sertifikat' => $request->no_sertifikat,
                'skpd_id' => $request->skpd,
                'master_barang_id' => $request->barang,
            ]);

            if (!empty($request->polygon)) {

                $geometry = Geometry::create([
                    'inventaris_id' => $inventaris->id,
                    'polygon' => $request->polygon,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ]);
            }

            if ($request->hasfile('image')) {
                $name = $request->file('image')->getClientOriginalName();
                $galery = Galery::create([
                    'inventaris_id' => $inventaris->id,
                    'image_path' => $name
                ]);
                $request->file('image')->move(public_path('assets/galery'), $name);
            }

            if ($request->hasfile('document')) {
                $name = $request->file('document')->getClientOriginalName();
                $document = Document::create([
                    'inventaris_id' => $inventaris->id,
                    'doc_path' => $name
                ]);
                $request->file('document')->move(public_path('assets/document'), $name);
            }

            // dd($inventaris, $geometry, $galery, $document);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Data Inventaris Berhasil Ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Menampilkan satuan data inventaris
        $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->where('id', $id)->get();

        $response = [
            'message' => "Detail Inventaris",
            'data' => $inventaris
        ];
        return response()->json($response, Response::HTTP_OK);
    }


    public function print($kib, $id)
    {
        //
        // dd($kib, $id);
        if ($kib == 'tanah') {
            $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        } else if ($kib == 'bangunan') {
            $inventaris = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        }
        // dd($inventaris);
        return view('inventaris.print', [
            'kib' => $kib,
            'inventaris' => $inventaris,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        $response = [
            'message' => "Edit Inventaris",
            'data' => $inventaris
        ];
        // dd($inventaris);
        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        $skpd = Skpd::get();
        $master_barang = MasterBarang::get();
        $geometry = Geometry::where('inventaris_id', $id)->get();
        $galery = Galery::where('inventaris_id', $id)->get();
        $document = Document::where('inventaris_id', $id)->get();
        // dd($geometry);
        // return response()->json($response, Response::HTTP_OK);
        return view('inventaris.form', [
            'edit' => $inventaris,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'skpd' => $skpd,
            'barang' => $master_barang,
            'geometry' => $geometry,
            'galery' => $galery,
            'document' => $document
        ]);
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

        $inventaris = Inventaris::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        $validations = [];

        // dd($inventaris);

        if ($inventaris->nama != $request->nama_inventaris) {
            $validations['nama_inventaris'] = 'required';
        }
        if ($inventaris->tahun_perolehan != $request->tahun) {
            $validations['tahun'] = 'required';
        }
        if ($inventaris->nilai_aset != $request->nilai_aset) {
            $validations['nilai'] = 'required';
        }
        if ($inventaris->luas != $request->luas) {
            $validations['luas'] = 'required';
        }
        if ($inventaris->no_registrasi != $request->no_registrasi) {
            $validations['no_registrasi'] = 'required';
        }
        if ($inventaris->alamat != $request->alamat) {
            $validations['alamat'] = 'required';
        }
        if ($inventaris->kelurahan_id != $request->kelurahan) {
            $validations['kelurahan'] = 'required';
        }
        if ($inventaris->kecamatan_id != $request->kecamatan) {
            $validations['kecamatan'] = 'required';
        }
        if ($inventaris->skpd_id != $request->skpd) {
            $validations['skpd'] = 'exists:master_skpd,id_skpd';
        }
        if ($inventaris->master_barang_id != $request->barang) {
            $validations['barang'] = 'exists:master_barang,id_barang';
        }


        $this->validate($request, $validations);

        // dd($request->all());
        try {
            DB::beginTransaction();

            $inventaris->nama = $request->nama_inventaris;
            $inventaris->tahun_perolehan = $request->tahun;
            $inventaris->nilai_aset = $request->nilai_aset;
            $inventaris->luas = $request->luas;
            $inventaris->status = $request->status;
            $inventaris->no_register = $request->no_register;
            $inventaris->alamat = $request->alamat;
            $inventaris->kelurahan_id = $request->kelurahan;
            $inventaris->kecamatan_id = $request->kecamatan;
            $inventaris->no_dokumen_sertifikat = $request->no_sertifikat;
            $inventaris->skpd_id = $request->skpd;
            $inventaris->master_barang_id = $request->barang;
            // if (!empty($request->password)) {
            //     $user->password = Hash::make($request->password);
            // }
            $inventaris->save();
            // dd($inventaris->geometry()->exists());
            if (!empty($request->polygon)) {
                if ($inventaris->geometry()->exists() == true) {
                    $geometry = Geometry::where('inventaris_id', $id)
                        ->update([
                            'polygon' => $request->polygon,
                            'lat' => $request->lat,
                            'lng' => $request->lng,
                        ]);
                } else {
                    $geometry = Geometry::create([
                        'inventaris_id' => $inventaris->id,
                        'polygon' => $request->polygon,
                        'lat' => $request->lat,
                        'lng' => $request->lng,
                    ]);
                }
            };
            // dd($request->hasfile('image'), $request->hasfile('document'));
            if ($request->hasfile('image')) {
                $oldfile = Galery::where('inventaris_id', $id)->pluck('image_path');
                $newfile = $request->file('image')->getClientOriginalName();
                foreach ($oldfile as $old) {
                    if (File::exists(public_path('assets/galery/' . $old))) {
                        File::delete(public_path('assets/galery/' . $old));
                    }
                };

                if (count($oldfile) == 0) {
                    Galery::create([
                        'inventaris_id' => $inventaris->id,
                        'image_path' => $newfile
                    ]);
                } else {
                    Galery::where('inventaris_id', $id)
                        ->update([
                            'image_path' => $newfile
                        ]);
                }
                $request->file('image')->move(public_path('assets/galery'), $newfile);
            } else if (!$request->hasfile('image')) {
                $oldfile = Galery::where('inventaris_id', $id)->pluck('image_path');
                // $newfile = $request->file('image')->getClientOriginalName();
                $galery = Galery::where('inventaris_id', $id);
                if ($galery) {
                    foreach ($oldfile as $old) {
                        if (File::exists(public_path('assets/galery/' . $old))) {
                            File::delete(public_path('assets/galery/' . $old));
                        }
                    };
                    $galery->delete();
                }
            };

            if ($request->hasfile('document')) {
                $oldfile = Document::where('inventaris_id', $id)->pluck('doc_path');
                $newfile = $request->file('document')->getClientOriginalName();
                foreach ($oldfile as $old) {
                    if (File::exists(public_path('assets/document/' . $old))) {
                        File::delete(public_path('assets/document/' . $old));
                    };
                };
                if (count($oldfile) == 0) {
                    Document::create([
                        'inventaris_id' => $inventaris->id,
                        'doc_path' => $newfile
                    ]);
                } else {
                    Document::where('inventaris_id', $id)
                        ->update([
                            'doc_path' => $newfile
                        ]);
                }
                $request->file('document')->move(public_path('assets/document'), $newfile);
            } else {
                $oldfile = Document::where('inventaris_id', $id)->pluck('doc_path');
                $document = Document::where('inventaris_id', $id);
                if ($document) {
                    foreach ($oldfile as $old) {
                        if (File::exists(public_path('assets/document/' . $old))) {
                            File::delete(public_path('assets/document/' . $old));
                        };
                    };
                    $document->delete();
                }
            };


            //     $file_name = $document->pluck('doc_path');
            //     if (File::exists(public_path('assets/files/' . $file_name))) {
            //         File::delete(public_path('assets/files/' . $file_name));
            //     }
            // }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
        return response("Data Inventaris Berhasil Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventaris  $Inventaris
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $inventaris = Inventaris::findOrFail($id);
        $geometry = Geometry::where('inventaris_id', $id);
        $galery = Galery::where('inventaris_id', $id);
        // $fileGalery = Galery::where('inventaris_id', $id)->firstOrFail();
        $document = Document::where('inventaris_id', $id);
        // $geometry = Geometry::find
        // dd($galery->value('image_path'), $document->pluck('doc_path'));
        try {
            $inventaris->delete();
            if ($geometry) {
                $geometry->delete();
            }
            if (File::exists(public_path('assets/galery/' . $galery->value('image_path')))) {
                File::delete(public_path('assets/galery/' . $galery->value('image_path')));
            }
            if (File::exists(public_path('assets/document/' . $document->value('doc_path')))) {
                File::delete(public_path('assets/document/' . $document->value('doc_path')));
            }
            if ($galery) {
                $galery->delete();
            }
            if ($document) {
                $document->delete();
            }
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return response("Inventaris Berhasil Dihapus");
    }
}
