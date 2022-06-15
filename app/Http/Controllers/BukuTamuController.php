<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuTamuRequest;
use App\Http\Requests\UpdateBukuTamuRequest;
use App\Models\BukuTamu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BukuTamuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_buku_tamu|edit_buku_tamu|delete_buku_tamu', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit_buku_tamu', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_buku_tamu', ['only' => ['destroy']]);
        $this->middleware('permission:buku_tamu_ekspor', ['only' => ['ekspor']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datatamu = BukuTamu::search(request(['search']))->paginate(20);

        return view('buku_tamu.index', [
            'datatamu' => $datatamu,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('buku_tamu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBukuTamuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBukuTamuRequest $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'alamat' => 'required',
            'image' => 'required',
            'signed' => 'required',
        ]);

        $validatedData['image'] = BukuTamu::create_image($request->image);
        $validatedData['signed'] = BukuTamu::create_sinature($request->signed);

        BukuTamu::create($validatedData);

        if (request('home') == 'pengunjung') {
            return redirect("/")->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect("/buku-tamu")->with('success', 'Data Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BukuTamu  $bukuTamu
     * @return \Illuminate\Http\Response
     */
    public function show(BukuTamu $bukuTamu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BukuTamu  $bukuTamu
     * @return \Illuminate\Http\Response
     */
    public function edit(BukuTamu $bukuTamu)
    {
        return view('buku_tamu.update', [
            'data' => $bukuTamu,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBukuTamuRequest  $request
     * @param  \App\Models\BukuTamu  $bukuTamu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBukuTamuRequest $request, BukuTamu $bukuTamu)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'alamat' => 'required',
        ]);

        if ($request->image) {
            if ($bukuTamu->image) {
                File::delete('image/' . $bukuTamu->image);
            }
            $validatedData['image'] = DataTamu::create_image($request->image);
        }

        if ($request->signed) {
            if ($bukuTamu->signed) {
                File::delete('tandatangan/' . $bukuTamu->signed);
            }
            $validatedData['signed'] = DataTamu::create_sinature($request->signed);
        }

        $bukuTamu->update($validatedData);

        return redirect('/buku-tamu')->with('success', 'Data Berhasil Di Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BukuTamu  $bukuTamu
     * @return \Illuminate\Http\Response
     */
    public function destroy(BukuTamu $bukuTamu)
    {
        if ($bukuTamu->image) {
            File::delete('image/' . $bukuTamu->image);
        }

        if ($bukuTamu->signed) {
            File::delete('tandatangan/' . $bukuTamu->signed);
        }

        BukuTamu::destroy($bukuTamu->id);

        return redirect('/buku-tamu')->with('success', 'Data Berhasil DiHapus!');
    }

    public function create_tamu()
    {
        return view('tambah');
    }

    public function ekspor()
    {
        return BukuTamu::excel();
    }
}
