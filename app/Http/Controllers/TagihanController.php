<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:tagihan-list|tagihan-create|tagihan-edit|tagihan-delete', ['only' => ['show','index']]);
         $this->middleware('permission:tagihan-create', ['only' => ['store','create']]);
         $this->middleware('permission:tagihan-edit', ['only' => ['update','edit']]);
         $this->middleware('permission:tagihan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ta = Tahunajaran::aktif()->select('year_id','year_code')->first();
        //dd($ta);
        $jenis= Tagihan::select('no','tp','nama','kode','bulanan','kelas')->orderBy('kelas')->get();
        
        return view('tagihan.index',[
            'jenis'=>$jenis,
            'ta' => $ta,
            'title' => 'Daftar Jenis Tagihan',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'ta' => 'required',
            'nominal' => 'required|numeric',
        ]);
        Tagihan::create(
            [
                'nama' => $request->nama,
                'jenis' => $request->jenis,
                'ta_id' => $request->ta,
                'nominal' => $request->nominal,
                'keterangan' => $request->keterangan,
                'user_id' => Auth::id(),
            ]);
        return redirect()->route('tagihan.index')->with('success', 'Data Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
