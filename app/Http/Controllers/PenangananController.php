<?php

namespace App\Http\Controllers;

use App\Models\Penanganan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PenangananController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:penanganan-list|penanganan-create|penanganan-edit|penanganan-delete', ['only' => ['index','show']]);
         $this->middleware('permission:penanganan-create', ['only' => ['create','store']]);
         $this->middleware('permission:penanganan-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:penanganan-delete', ['only' => ['destroy','reset']]);
    }
    public function index() {
        $penanganan=Penanganan::get();
        $title = 'Buat Penanganan';
        return view('penanganan.create',[
            'penanganan'=>$penanganan,
            'title' => $title,
        ]);
    }

    public function store(Request $request, $id) {

    }
    public function getPelanggaran($studentId)  {
        $pel=Pelanggaran::with('jenisPelanggaran','siswa')->where('siswa_id',$studentId)->get()->sortBy('tgl_pelanggaran');
        $data = $pel->map(function ($p) {
            return [
                'id' => $p->id,
                'pelanggaran' => $p->jenisPelanggaran->nama,
                'tanggal' => $p->tgl_pelanggaran,
            ];
        });
        return response()->json($data);
    }
}
