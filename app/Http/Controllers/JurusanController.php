<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\JurusanRequest;

class JurusanController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:jurusan-list|jurusan-create|jurusan-edit|jurusan-delete', ['only' => ['jurusanIndex']]);
         $this->middleware('permission:jurusan-create', ['only' => ['Store']]);
         $this->middleware('permission:jurusan-edit', ['only' => ['update']]);
         $this->middleware('permission:jurusan-delete', ['only' => ['destroy']]);

         $this->middleware(function($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            } 
            if (session('error')) {
                Alert::error(session('error'));
            }
            return $next($request);
        });
    }/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = Jurusan::with('user')->latest()->get();
        $kapros = User::role('Kapro')->get();

        return view('jurusan.index', compact('jurusans', 'kapros'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request)
    {
        try {
            DB::beginTransaction();

            Jurusan::create([
                'kode' => strtoupper($request->kode),
                'nama' => $request->nama,
                'user_id' => $request->user_id,
                'is_active' => $request->is_active
            ]);

            DB::commit();

            return redirect()->route('jurusan.index')
                           ->with('success', 'Data jurusan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, Jurusan $jurusan)
    {
        try {
            DB::beginTransaction();

            $jurusan->update([
                'kode' => strtoupper($request->kode),
                'nama' => $request->nama,
                'user_id' => $request->user_id,
                'is_active' => $request->is_active
            ]);

            DB::commit();

            return redirect()->route('jurusan.index')
                           ->with('success', 'Data jurusan berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat memperbarui data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        try {
            DB::beginTransaction();

            $jurusan->delete();

            DB::commit();

            return redirect()->route('jurusan.index')
                           ->with('success', 'Data jurusan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}