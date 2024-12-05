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
        $this->middleware('permission:walikelas-list|walikelas-create|walikelas-edit|walikelas-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:walikelas-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:walikelas-edit', ['only' => ['edit', 'update', 'guruAjax', 'kelasAjax']]);
        $this->middleware('permission:walikelas-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunaktif = Tahunajaran::select('year_id')->where('is_active', 1);
        $kelas = Kelas::select('class_id', 'class_name', 'year_id', 'is_deleted', 'is_active', 'user_id')->where('year_id', $tahunaktif)->where('is_deleted', 0)->get();
        $guru = User::all();
        //dd($kelas);
        return view('walikelas.index', compact('kelas', 'guru'));
    }
    public function guruAjax()
    {
        $guru = User::select('id', 'name')->get();
        return response()->json($guru);
    }
    public function kelasAjax()
    {
        $tahunaktif = Tahunajaran::select('year_id')->where('is_active', 1);
        $kelas = Kelas::Where('year_id', $tahunaktif)->where('is_deleted', 0)->select('class_id', 'class_name', 'year_id', 'is_deleted', 'is_active', 'user_id')->get();
        return response()->json($kelas);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => 'Wali kelas harus dipilih',
            'user_id.exists' => 'Guru tidak valid',
        ]);

        try {
            // Find the kelas record
            $kelas = Kelas::where('class_id', $id)->firstOrFail();
            //User::find($kelas->user_id)->assignRole('Guru');
            User::find($request->user_id)->assignRole('WaliKelas');
            // Check if teacher is already a wali kelas for another class
            $existingTeacher = Kelas::where('user_id', $request->user_id)
                ->where('class_id', '!=', $id)
                ->where('is_active', 1)
                ->where('is_deleted', 0)
                ->first();

            if ($existingTeacher) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Guru ini sudah menjadi wali kelas untuk kelas lain'
                ], 422);
            }
            $oldTeacherName = User::find($kelas->user_id)?->name ?? 'Tidak ada';
            $newTeacherName = User::find($request->user_id)->name;

            // Update the kelas
            $kelas->update([
                'user_id' => $request->user_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Wali kelas berhasil diperbarui',
                'details' => [
                    'className' => $kelas->class_name,
                    'oldTeacher' => $oldTeacherName,
                    'newTeacher' => $newTeacherName
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating wali kelas: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui wali kelas'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunaktif = Tahunajaran::select('year_id')->where('is_active', 1);
        $kelas = Kelas::select('class_id', 'class_name', 'year_id', 'is_deleted', 'is_active', 'user_id')->where('year_id', $tahunaktif)->where('is_deleted', 0)->get();
        $guru = User::select('id', 'name')->get();
        //dd($guru);
        return view('walikelas.create', [
            'kelas' => $kelas,
            'guru' => $guru,
        ]);
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
        $kelas_ids = $request->input('kelas_id');
        $user_ids = $request->input('user_id');
        //dd($user_ids, $kelas_ids);
        foreach ($kelas_ids as $key => $kelas_id) {
            $user_id = $user_ids[$key];
            Kelas::where('class_id', $kelas_id)->update(['user_id' => $user_id]);
            User::find($user_id)->syncRoles('WaliKelas');
        }
        return redirect()->route('walikelas.index')->with('success', 'Wali Kelas Berhasil ditambahkan');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
