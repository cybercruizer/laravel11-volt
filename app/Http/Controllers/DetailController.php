<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function alpha($tanggal)  {
        //dd($tanggal);
        $data = Presensi::with(['siswa','kelas'])->where('tanggal',$tanggal)->where('keterangan','A')->get();
        //dd($alpha);
        $tgl=$tanggal;
        $judul = 'Detail alpha tanggal ';
        return view('detail.index',[
            'tgl'=>$tgl,
            'data'=>$data,
            'judul'=>$judul
        ]);
        
    }

    public function terlambat($tanggal)  {
        //dd($tanggal);
        $data = Presensi::with(['siswa','kelas'])->where('tanggal',$tanggal)->where('keterangan','T')->get();
        //dd($alpha);
        $tgl=$tanggal;
        $judul = 'Detail Keterlambatan tanggal ';
        return view('detail.index',[
            'tgl'=>$tgl,
            'data'=>$data,
            'judul'=>$judul
        ]);
        
    }
}
