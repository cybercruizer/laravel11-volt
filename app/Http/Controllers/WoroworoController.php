<?php

namespace App\Http\Controllers;

use App\Models\Woroworo;
use Illuminate\Http\Request;

class WoroworoController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:woroworo-list|woroworo-create|woroworo-edit|woroworo-delete', ['only' => ['index','show']]);
         $this->middleware('permission:woroworo-create', ['only' => ['create','store']]);
         $this->middleware('permission:woroworo-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:woroworo-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $woro2=Woroworo::latest()->paginate(20);

        return view('pengumuman.index',compact('woro2'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $woro2=Woroworo::find($id);
        return view('pengumuman.show',compact('woro2'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $woro2=Woroworo::find($id);
        return view('pengumuman.edit',compact('woro2'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'status' => 'required',
        ]);
        $woro2=Woroworo::find($id);
        $woro2->judul=$request->input('judul');
        $woro2->konten=$request->input('konten');
        $woro2->status=$request->input('status');
        $woro2->save();
        return redirect()->route('woroworo.index')->with('success','Pengumuman Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //dd($id);
        $woro2=Woroworo::findOrFail($id);
        $woro2->delete();
        return redirect()->route('woroworo.index')->with('success','Pengumuman Berhasil dihapus');
    }
}
