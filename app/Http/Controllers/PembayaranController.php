<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\Pembayaran2425;
use App\Models\Pembayaran2425Ol;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pembayaran-list|pembayaran-create|pembayaran-edit|pembayaran-delete', ['only' => ['spp','lain']]);
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
    public function spp(Request $request)
    {
        if(Auth::user()->hasRole('WaliKelas'))
        {
            $wali = Auth::user()->kelas;
            $nis=Siswa::aktif()->select('student_number')->where('class_id',$wali->class_id)->pluck('student_number');
            //dd($nis);

            $pembayaran = Pembayaran2425::select('nis','nama','jenis','jenjang','paralel','tahap','jumlah','kategori')
                ->whereIn('nis',$nis)
                ->where('jenis','A')
                ->get()
                ->sortBy('nis')
                ->groupBy(function($data){
                    return $data->nis;
                }
            );
            //dd($pembayaran);
            return view('pembayaran.spp',[
                'title' => 'Daftar Pembayaran SPP kelas '.$wali->class_code,
                'pembayaran'=>$pembayaran,
                'kelas' => $wali
            ]);
        }
        if(Auth::user()->hasRole(['Admin','Keuangan']))
        {
            $kelas = Kelas::aktif()->select('class_id','class_code','class_name')->get();
            $r_kelas = Kelas::find($request->class_id)->class_name ??'-';
            $nis = Siswa::aktif()->select('student_number')->where('class_id',$request->class_id)->pluck('student_number');
            $pembayaran=Pembayaran2425::select('nis','nama','jenis','jenjang','paralel','tahap','jumlah','kategori')
                ->whereIn('nis',$nis)
                ->where('jenis','A')
                ->get()
                ->sortBy('nis')
                ->groupBy(function($data){
                    return $data->nis;
                }
            );
            return view('pembayaran.spp',[
                'title' => 'Daftar Pembayaran SPP kelas '.$r_kelas,
                'pembayaran'=>$pembayaran,
                'kelas' => $kelas,
            ]);
        }
    }
    public function lain ()
    {
        $wali = auth()->user()->kelas;
        $nis=Siswa::aktif()->select('student_number','student_name')->where('class_id',$wali->class_id)->get();
        //dd($nis);
        //dd($wali);
        $kelas=explode('-',$wali->class_code);
        switch($kelas[1]) {
            case 'X' : 
                $kel = 10; 
                break;
            case 'XI' : 
                $kel = 11; 
                break;
            case 'XII' : 
                $kel = 12; 
                break;
        }
        //dd($kel);
        $data=[];
        $tagihan=Tagihan::where([['kelas',$kel],['tp','2024/2025']])->whereNot('kode','A')->get();
        //dd($tagihan);
        $data = [];
        foreach($nis->pluck('student_number') as $n) {
            foreach($tagihan->pluck('kode') as $tag) {
               $data[$n][$tag] = Pembayaran2425::select('nis','nama','jenis','jenjang','paralel','tahap','jumlah')
                ->where([
                    ['jenis', $tag],
                    ['nis', $n]
                ])
                ->sum('jumlah'); 
                
            }
        }
        //dd($data);
        $title= "Rekap pembayaran kelas ".$wali->class_name;
        return view('pembayaran.lain', compact('title','nis', 'tagihan', 'data'));
    }
    public function sync() {
        $pembayaranOl=Pembayaran2425Ol::all();
        foreach ($pembayaranOl as $pem) {
            Pembayaran2425::updateOrCreate(
                ['no'=>$pem->no],
                $pem->toArray()
            );
        }
        alert()->success('Sukses', 'Pembayaran berhasil tersinkronisasi');
        return redirect()->back();
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
