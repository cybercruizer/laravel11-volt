<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\Pembayaran2425;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pembayaran-list|pembayaran-create|pembayaran-edit|pembayaran-delete', ['only' => ['spp']]);
         $this->middleware('permission:pembayaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:pembayaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pembayaran-delete', ['only' => ['destroy']]);

         $this->middleware(function($request, $next) {
            if (session('success')) {
                Alert::success(session('success'));
            } 
            if (session('error')) {
                Alert::error(session('error'));
            }
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function spp()
    {
        $wali = auth()->user()->kelas;
        $siswa=auth()->user()->kelas->siswas;
        $nis=Siswa::aktif()->select('student_number')->where('class_id',$wali->class_id)->pluck('student_number');
        //dd($nis);
        $sep = explode("-",$wali->class_code);
        $panjangarray= count($sep);
        $ta=Tahunajaran::aktif()->first()->year_code;
        $jenis = "A";

        //konvert ke desimal
        switch ($sep[0]) {
            case 'X' : $jenjang=10; break;
            case 'XI' : $jenjang=11; break;
            case 'XII' : $jenjang=12; break;
        };
        
        if ($panjangarray>2) {
            $paralel = $sep[1]." ".$sep[2];
        } else {
            $paralel = $sep[1];
        }
        
        $kode = $ta.$jenis.$jenjang;
        $pembayaran = Pembayaran2425::select('nis','nama','jenis','jenjang','paralel','tahap','jumlah')
            ->whereIn('nis',$nis)
            ->where([
            //    ['jenjang',$jenjang],
            //    ['paralel',$paralel],
                ['jenis',$jenis]
            ])
            ->get()
            ->groupBy(function($data){
                return $data->nis;
        });
        //dd($pembayaran);
        return view('pembayaran.spp',[
            'title' => 'Daftar Pembayaran SPP kelas '.$wali->class_code,
            'pembayaran'=>$pembayaran
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
        //
    }
}
