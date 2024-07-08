<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:siswa-list|siswa-create|siswa-edit|siswa-delete', ['only' => ['index','show']]);
         $this->middleware('permission:siswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:siswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:siswa-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        if ($request->ajax()) {
            if (Auth::user()->hasRole(['Admin','Bk','Guru'])) {
                $siswas = Siswa::get();
            } elseif (Auth::user()->hasRole(['WaliKelas'])){
                $kelas=Auth::user()->kelas->class_id;
                $siswas = Siswa::where('class_id',$kelas)->get();
            }
            return datatables()->of($siswas)
                ->addColumn('nama_kelas',
                function($siswa) {
                    return $siswa->kelas->class_name;
                })
                ->make(true);
        }
        return view('siswas.index');
    }

}
