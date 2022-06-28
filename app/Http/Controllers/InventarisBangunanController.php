<?php

namespace App\Http\Controllers;

use App\Models\InventarisBangunan;
use App\Models\Document;
use App\Models\Galery;
use App\Models\Geometry;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
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
use App\Models\PemeliharaanInventarisBangunan;

class InventarisBangunanController extends Controller
{
    public function index()
    {
        return view('inventaris.gedung.index');
    }

    public function getInventarisGedung()
    {
        //Get data untuk yajra datatables pada halaman Inventaris

        $inventaris = DataTables::of(InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'pemeliharaan', 'galery', 'document'))
            ->addIndexColumn()
            ->make(true);

        // return $datatables->make(true);
        return $inventaris;
    }
    public function querySkpd($skpd_id)
    {
        if ($skpd_id === 'Semua OPD') {
            $inventarisBangunan =  InventarisBangunan::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry', 'pemeliharaan')
                ->has('geometry')
                ->get();
        } else {
            $inventarisBangunan =  InventarisBangunan::with('master_barang', 'master_skpd', 'kelurahan', 'kecamatan', 'document', 'galery', 'geometry', 'pemeliharaan')
                ->where('skpd_id',  $skpd_id)->has('geometry')
                // ->where('kelurahan_id',  $kelurahan_id)->has('geometry')
                // ->where('status',  $status)->has('geometry')
                ->get();
        }
        $response = [
            'message' => 'List Query Pencarian Data',
            'count' => count($inventarisBangunan),
            'data' => $inventarisBangunan
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id)
    {
        //Menampilkan satuan data inventaris
        $inventarisBangunan = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->where('id', $id)->get();

        $response = [
            'message' => "Detail Inventaris",
            'data' => $inventarisBangunan
        ];
        return response()->json($response, Response::HTTP_OK);
    }

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
        return view('inventaris.gedung.form', [
            // 'edit' => $inventaris,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'skpd' => $skpd,
            'barang' => $master_barang
        ]);
    }

    public function store(Request $request)
    {
        //
        // dd($request->all());
        // dd($request->polygon);
        // dd(json_decode($request->polygon));
        // dd(jso$poly[0]);
        // $poly = json_decode($request->polygon);
        // $lat = json_decode($request->lat);
        // $lng = json_decode($request->lng);
        // dd(json_encode($poly[0]));
        // foreach ($poly as $item => $value) {
        //     dd(json_encode($value), json_encode($lat[$item]), " ", json_encode($lng[$item]));
        // }
        // echo "$value <br>";

        $this->validate($request, [
            'nama_inventaris' => 'required',
            'tahun' => 'required',
            'nilai_aset' => 'required',
            'luas' => 'required',
            'status' => 'required',
            'kode_gedung' => 'required',
            'no_register' => 'required',
            'kondisi_bangunan' => 'required',
            'jenis_bangunan' => 'required',
            'jenis_konstruksi' => 'required',
            'alamat' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            // 'no_sertifikat' => 'required',
            'skpd' => 'exists:master_skpd,id_skpd',
            'barang' => 'exists:master_barang,id_barang',
        ]);
        try {
            DB::beginTransaction();
            $inventarisBangunan = InventarisBangunan::create([

                'id_inventaris' => $request->id_inventaris,
                'nama' => $request->nama_inventaris,
                'jenis_inventaris' => 'A',
                'tahun_perolehan' => $request->tahun,
                'nilai_aset' => $request->nilai_aset,
                'luas' => $request->luas,
                'kode_gedung' => $request->kode_gedung,
                'status' => $request->status,
                'kondisi_bangunan' => $request->kondisi_bangunan,
                'jenis_bangunan' => $request->jenis_bangunan,
                'jenis_konstruksi' => $request->jenis_konstruksi,
                'no_register' => $request->no_register,
                'alamat' => $request->alamat,
                'kelurahan_id' => $request->kelurahan,
                'kecamatan_id' => $request->kecamatan,
                'skpd_id' => $request->skpd,
                'master_barang_id' => $request->barang,
            ]);

            if (!empty($request->polygon)) {

                $polygon = json_decode($request->polygon);
                $lat = json_decode($request->lat);
                $lng = json_decode($request->lng);

                foreach ($polygon as $item => $p) {
                    Geometry::create([
                        'inventaris_id' => $request->id_inventaris,
                        'polygon' => json_encode($p),
                        'lat' => json_encode($lat[$item]),
                        'lng' => json_encode($lng[$item]),
                    ]);
                }
            }

            if ($request->hasfile('image')) {
                $name = $request->file('image')->getClientOriginalName();
                $galery = Galery::create([
                    'inventaris_id' => $request->id_inventaris,
                    'image_path' => $name
                ]);
                $request->file('image')->move(public_path('assets/galery'), $name);
            }

            if ($request->hasfile('penanda')) {
                $name = $request->file('penanda')->getClientOriginalName();
                $document = Document::create([
                    'inventaris_id' => $request->id_inventaris,
                    'doc_path' => $name
                ]);
                $request->file('penanda')->move(public_path('assets/document'), $name);
            }

            // dd($inventaris, $geometry, $galery, $document);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Data Inventaris Berhasil Ditambahkan");
    }


    public function edit($id)
    {
        //
        $inventarisBangunan = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        $response = [
            'message' => "Edit Inventaris",
            'data' => $inventarisBangunan
        ];
        // dd($inventarisBangunan);
        // dd($inventarisBangunan->geometry);
        $kecamatan = Kecamatan::get();
        $kelurahan = Kelurahan::get();
        $skpd = Skpd::get();
        $master_barang = MasterBarang::get();
        // $geometry = Geometry::where('inventaris_id', $inventarisBangunan->id_inventaris)->get();
        // $galery = Galery::where('inventaris_id', $$inventarisBangunan->id_inventaris)->get();
        // $document = Document::where('inventaris_id', $$inventarisBangunan->id_inventaris)->get();
        // return response()->json($response, Response::HTTP_OK);
        return view('inventaris.gedung.form', [
            'edit' => $inventarisBangunan,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan,
            'skpd' => $skpd,
            'barang' => $master_barang,
            'geometry' => $inventarisBangunan->geometry,
            'galery' => $inventarisBangunan->galery,
            'document' => $inventarisBangunan->document
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

        $inventarisBangunan = InventarisBangunan::with('master_barang', 'master_skpd', 'geometry', 'kelurahan', 'kecamatan', 'galery', 'document')->findOrFail($id);
        $validations = [];
        // $cekGeom = Geometry::where('inventaris_id', $request->id_inventaris)->get();

        // dd($inventarisBangunan);
        // dd($request->hasfile('document'));
        // dd($inventarisBangunan->geometry[0]->id);

        if ($inventarisBangunan->nama != $request->nama_inventaris) {
            $validations['nama_inventaris'] = 'required';
        }
        if ($inventarisBangunan->tahun_perolehan != $request->tahun) {
            $validations['tahun'] = 'required';
        }
        if ($inventarisBangunan->nilai_aset != $request->nilai_aset) {
            $validations['nilai_aset'] = 'required';
        }
        if ($inventarisBangunan->luas != $request->luas) {
            $validations['luas'] = 'required';
        }
        if ($inventarisBangunan->kode_gedung != $request->luas) {
            $validations['kode_gedung'] = 'required';
        }
        if ($inventarisBangunan->no_registrasi != $request->no_registrasi) {
            $validations['no_registrasi'] = 'required';
        }
        if ($inventarisBangunan->kondisi_bangunan != $request->kondisi_bangunan) {
            $validations['no_registrasi'] = 'required';
        }
        if ($inventarisBangunan->jenis_bangunan != $request->jenis_bangunan) {
            $validations['no_registrasi'] = 'required';
        }
        if ($inventarisBangunan->jenis_konstruksi != $request->jenis_konstruksi) {
            $validations['no_registrasi'] = 'required';
        }
        if ($inventarisBangunan->alamat != $request->alamat) {
            $validations['alamat'] = 'required';
        }
        if ($inventarisBangunan->kelurahan_id != $request->kelurahan) {
            $validations['kelurahan'] = 'required';
        }
        if ($inventarisBangunan->kecamatan_id != $request->kecamatan) {
            $validations['kecamatan'] = 'required';
        }
        if ($inventarisBangunan->skpd_id != $request->skpd) {
            $validations['skpd'] = 'exists:master_skpd,id_skpd';
        }
        if ($inventarisBangunan->master_barang_id != $request->barang) {
            $validations['barang'] = 'exists:master_barang,id_barang';
        }


        $this->validate($request, $validations);

        // dd($request->all());
        try {
            DB::beginTransaction();

            $inventarisBangunan->id_inventaris = $request->id_inventaris;
            $inventarisBangunan->nama = $request->nama_inventaris;
            $inventarisBangunan->tahun_perolehan = $request->tahun;
            $inventarisBangunan->nilai_aset = $request->nilai_aset;
            $inventarisBangunan->luas = $request->luas;
            $inventarisBangunan->kode_gedung = $request->kode_gedung;
            $inventarisBangunan->status = $request->status;
            $inventarisBangunan->no_register = $request->no_register;
            $inventarisBangunan->kondisi_bangunan = $request->kondisi_bangunan;
            $inventarisBangunan->jenis_bangunan = $request->jenis_bangunan;
            $inventarisBangunan->jenis_konstruksi = $request->jenis_konstruksi;
            $inventarisBangunan->alamat = $request->alamat;
            $inventarisBangunan->kelurahan_id = $request->kelurahan;
            $inventarisBangunan->kecamatan_id = $request->kecamatan;
            // $inventarisBangunan->no_dokumen_sertifikat = $request->no_sertifikat;
            $inventarisBangunan->skpd_id = $request->skpd;
            $inventarisBangunan->master_barang_id = $request->barang;
            // if (!empty($request->password)) {
            //     $user->password = Hash::make($request->password);
            // }
            $inventarisBangunan->save();
            // dd($inventaris->geometry()->exists());
            if (!empty($request->polygon)) {
                // percobaan insert array database relasi
                $cekGeom = Geometry::where('inventaris_id', $request->id_inventaris);
                $polygon = json_decode($request->polygon);
                $lat = json_decode($request->lat);
                $lng = json_decode($request->lng);

                if ($cekGeom->exists()) {
                    $cekGeom->delete();
                }
                foreach ($polygon as $item => $p) {
                    Geometry::create([
                        'inventaris_id' => $request->id_inventaris,
                        'polygon' => json_encode($p),
                        'lat' => json_encode($lat[$item]),
                        'lng' => json_encode($lng[$item]),
                    ]);
                }
            } else {
                $cekGeom = Geometry::where('inventaris_id', $request->id_inventaris);
                if ($cekGeom->exists()) {
                    $cekGeom->delete();
                }
            };

            // dd($request->hasfile('image'), $request->hasfile('document'));
            if ($request->hasfile('image')) {
                $oldfile = Galery::where('inventaris_id', $inventarisBangunan->id_inventaris)->pluck('image_path');
                $newfile = $request->file('image')->getClientOriginalName();
                foreach ($oldfile as $old) {
                    if (File::exists(public_path('assets/galery/' . $old))) {
                        File::delete(public_path('assets/galery/' . $old));
                    }
                };

                if (count($oldfile) == 0) {
                    Galery::create([
                        'inventaris_id' => $inventarisBangunan->id_inventaris,
                        'image_path' => $newfile
                    ]);
                } else {
                    Galery::where('inventaris_id', $inventarisBangunan->id_inventaris)
                        ->update([
                            'image_path' => $newfile
                        ]);
                }
                $request->file('image')->move(public_path('assets/galery'), $newfile);
            } else {
                $oldfile = Galery::where('inventaris_id', $inventarisBangunan->id_inventaris)->pluck('image_path');
                // dd($oldfile);
                $galery = Galery::where('inventaris_id', $inventarisBangunan->id_inventaris);
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
                $oldfile = Document::where('inventaris_id', $inventarisBangunan->id_inventaris)->pluck('doc_path');
                $newfile = $request->file('document')->getClientOriginalName();
                foreach ($oldfile as $old) {
                    if (File::exists(public_path('assets/document/' . $old))) {
                        File::delete(public_path('assets/document/' . $old));
                    };
                };
                if (count($oldfile) == 0) {
                    Document::create([
                        'inventaris_id' => $inventarisBangunan->id_inventaris,
                        'doc_path' => $newfile
                    ]);
                } else {
                    Document::where('inventaris_id', $inventarisBangunan->id_inventaris)
                        ->update([
                            'doc_path' => $newfile
                        ]);
                }
                $request->file('document')->move(public_path('assets/document'), $newfile);
            } else {
                $oldfile = Document::where('inventaris_id', $inventarisBangunan->id_inventaris)->pluck('doc_path');
                $document = Document::where('inventaris_id', $inventarisBangunan->id_inventaris);
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

    //destroy inventaris bangunan
    public function destroy(Request $request, $id)
    {
        //
        $inventarisBangunan = InventarisBangunan::findOrFail($id);
        $geometry = Geometry::where('inventaris_id', $inventarisBangunan->id_inventaris);
        $galery = Galery::where('inventaris_id', $inventarisBangunan->id_inventaris);
        // $fileGalery = Galery::where('inventaris_id', $id)->firstOrFail();
        $document = Document::where('inventaris_id', $inventarisBangunan->id_inventaris);
        // $geometry = Geometry::find
        // dd($galery->value('image_path'), $document->pluck('doc_path'));
        // dd($galery, $document, $geometry);
        try {
            $inventarisBangunan->delete();
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

    public function storePemeliharaan(Request $request)
    {
        //
        $this->validate($request, [
            'nama' => 'required',
            'tahun' => 'required',
            'nilai' => 'required',
        ]);

        // dd($request->id, $request->id_inventaris, $request->nama, $request->tahun, $request->nilai);

        try {
            DB::beginTransaction();
            $pemeliharaan = PemeliharaanInventarisBangunan::create([

                'inventaris_id' => $request->id_inventaris,
                'nama_pemeliharaan' => $request->nama,
                'tahun_pemeliharaan' => $request->tahun,
                'nilai_aset' => $request->nilai,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }

        return response("Data Pemeliharaan Berhasil Ditambahkan");
    }

    public function updatePemeliharaan(Request $request, $id)
    {
        //
        $pemeliharaan = PemeliharaanInventarisBangunan::findOrFail($id);
        // dd($request->id, $request->id_inventaris, $request->nama, $request->tahun, $request->nilai);
        $validations = [];;

        if ($pemeliharaan->nama_pemeliharaan != $request->nama) {
            $validations['nama'] = 'required';
        }
        if ($pemeliharaan->tahun_pemeliharaan != $request->tahun) {
            $validations['tahun'] = 'required';
        }
        if ($pemeliharaan->nilai_aset != $request->nilai) {
            $validations['nilai'] = 'required';
        }

        $this->validate($request, $validations);

        try {
            DB::beginTransaction();

            $pemeliharaan->nama_pemeliharaan = $request->nama;
            $pemeliharaan->tahun_pemeliharaan = $request->tahun;
            $pemeliharaan->nilai_aset = $request->nilai;

            $pemeliharaan->save();
            // dd($inventaris->geometry()->exists());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }
        return response("Data Pemeliharaan Berhasil Diubah");
    }

    public function destroyPemeliharaan(Request $request, $id)
    {
        //
        $destroyPemeliharaan = PemeliharaanInventarisBangunan::findOrFail($id);

        try {
            $destroyPemeliharaan->delete();
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }

        return response("Inventaris Berhasil Dihapus");
    }
}
