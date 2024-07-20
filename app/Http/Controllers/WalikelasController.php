<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;

class WalikelasController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:walikelas-list|walikelas-create|walikelas-edit|walikelas-delete', ['only' => ['index','show']]);
         $this->middleware('permission:walikelas-create', ['only' => ['create','store']]);
         $this->middleware('permission:walikelas-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:walikelas-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunaktif= Tahunajaran::select('year_id')->where('is_active',1);
        $kelas = Kelas::with('user')->where('year_id',$tahunaktif)->get();
        $guru = User::all();
        //dd($kelas);
        return view('walikelas.index', compact('kelas','guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunaktif= Tahunajaran::select('year_id')->where('is_active',1);
        $kelas = Kelas::where('year_id',$tahunaktif)->get();
        $guru = User::guru()->select('id','name')->get();
        //dd($kelas);
        return view('walikelas.create',compact('kelas','guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        //update record walikelas_id on table classrrooms with user_id
        $request->validate([
            'kelas_id' => 'required',
        ]);
        $kelas_ids= $request->input('kelas_id');
        $user_ids= $request->input('user_id'); 
        //dd($user_ids, $kelas_ids);
        foreach ($kelas_ids as $key => $kelas_id) {
            $user_id= $user_ids[$key];
            Kelas::where('class_id', $kelas_id)->update(['user_id' => $user_id]);
            User::find($user_id)->assignRole('WaliKelas');
        }
        return redirect()->route('walikelas.index')->with('success','Wali Kelas Berhasil ditambahkan');
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
    public function update(Request $request, string $kelas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
