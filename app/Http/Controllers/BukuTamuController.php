<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuTamuRequest;
use App\Http\Requests\UpdateBukuTamuRequest;
use App\Models\{
    BukuTamu,
    m_guru
};
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Notification;
use Auth;
use GuzzleHttp\Client;

class BukuTamuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_buku_tamu', ['only' => ['index', 'show']]);
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
        $gurus = m_guru::all();
        return view('buku_tamu.create', compact('gurus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBukuTamuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBukuTamuRequest $request, $home = 'dashboard')
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'alamat' => 'required',
            'kategori' => 'required',
            'image' => 'required',
            'signed' => 'required',
            'guru_id' => 'required',
            'keperluan' => 'required',
            'no_telp' => 'required'
        ]);

        $validatedData['image'] = BukuTamu::create_image($request->image);
        $validatedData['signed'] = BukuTamu::create_sinature($request->signed);

        $data = BukuTamu::create($validatedData);
        $this->sendMessageTele($data->guru->id_telegram, $data->nama . ' Sedang menunggu');

        if ($home == 'dashboard') {
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
        $gurus = m_guru::all();
        return view('buku_tamu.update', [
            'data' => $bukuTamu,
            'gurus' => $gurus
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
            'kategori' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'guru_id' => 'required',
            'keperluan' => 'required',
        ]);

        if ($request->image) {
            if ($bukuTamu->image) {
                File::delete('image/' . $bukuTamu->image);
            }
            $validatedData['image'] = BukuTamu::create_image($request->image);
        }

        if ($request->signed) {
            if ($bukuTamu->signed) {
                File::delete('tandatangan/' . $bukuTamu->signed);
            }
            $validatedData['signed'] = BukuTamu::create_sinature($request->signed);
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

    public function ekspor()
    {
        return BukuTamu::excel();
    }
}
