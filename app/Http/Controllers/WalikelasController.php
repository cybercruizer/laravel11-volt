<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
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
        $walikelas = User::with('kelas')->walikelas()->get();
        return view('walikelas.index', compact('walikelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunaktif= Tahunajaran::where('is_active',1)->first();
        $kelas = Kelas::where('class_year',$tahunaktif)->get();
        $guru = User::guru()->get();
        return view('walikelas.create',compact('kelas','guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    }
}
