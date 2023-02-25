<?php

namespace App\Http\Controllers;

use App\Models\m_guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_guru', ['only' => ['index', 'store']]);
        $this->middleware('permission:add_guru', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_guru', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_guru', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gurus = m_guru::paginate(30);
        return view('guru.index', compact('gurus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required', 
            'no_telp' => 'required'
        ]);

        m_guru::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\m_guru  $m_guru
     * @return \Illuminate\Http\Response
     */
    public function show(m_guru $m_guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\m_guru  $m_guru
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = m_guru::findOrFail($id);
        return view('guru.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\m_guru  $m_guru
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required', 
            'no_telp' => 'required'
        ]);

        $data = m_guru::findOrFail($id);
        $data->update($request->all());
        return redirect()->route('guru.index')->with('success', 'Guru berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\m_guru  $m_guru
     * @return \Illuminate\Http\Response
     */
    public function destroy(m_guru $m_guru)
    {
        //
    }
}
