<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\Pembayaran2425 as Pembayaran;
use App\Models\Pembayaran2425Ol;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pembayaran-list|pembayaran-create|pembayaran-edit|pembayaran-delete', ['only' => ['spp', 'lain']]);
        $this->middleware('permission:pembayaran-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pembayaran-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pembayaran-delete', ['only' => ['destroy']]);

        $this->middleware(function ($request, $next) {
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
        if (Auth::user()->hasRole('WaliKelas')) {
            // $wali = Auth::user()->kelas;
            // $nis=Siswa::aktif()->select('student_number')->where('class_id',$wali->class_id)->pluck('student_number');
            // //dd($nis);

            // $pembayaran = Pembayaran::select('nis','nama','jenis','jenjang','paralel','tahap','jumlah','kategori')
            //     ->whereIn('nis',$nis)
            //     ->where('jenis','A')
            //     ->get()
            //     ->sortBy('nis')
            //     ->groupBy(function($data){
            //         return $data->nis;
            //     }
            // );
            // //dd($pembayaran);
            // return view('pembayaran.spp',[
            //     'title' => 'Daftar Pembayaran SPP kelas '.$wali->class_code,
            //     'pembayaran'=>$pembayaran,
            //     'kelas' => $wali
            // ]);
            
            $kelas = Auth::user()->kelas;
            $class_id = $kelas->class_id ?? null;
            $title = 'Daftar Pembayaran SPP kelas ' . $kelas->class_code;

            // Ambil semua siswa di kelas yang dipilih
            $siswa = [];
            if ($class_id) {
                $siswa = \App\Models\Siswa::aktif()
                    ->select('student_number', 'student_name', 'class_id')
                    ->where('class_id', $class_id)
                    ->get();
            }

            // Ambil pembayaran SPP semua siswa sekaligus
            $nisList = $siswa->pluck('student_number');
            $pembayaran = Pembayaran::select('nis', 'nama', 'jenis', 'jenjang', 'paralel', 'tahap', 'jumlah', 'kategori')
                ->whereIn('nis', $nisList)
                ->where('jenis', 'A')
                ->get()
                ->groupBy('nis');

            return view('pembayaran.spp', compact('title', 'kelas', 'siswa', 'pembayaran'));
        }
        if (Auth::user()->hasRole(['Admin', 'Keuangan'])) {
            $kelas = Kelas::aktif()->select('class_id', 'class_code', 'class_name')->get();
            $r_kelas = Kelas::find($request->class_id)->class_name ?? '-';
            $nis = Siswa::aktif()->select('student_number')->where('class_id', $request->class_id)->pluck('student_number');
            $pembayaran = Pembayaran::select('nis', 'nama', 'jenis', 'jenjang', 'paralel', 'tahap', 'jumlah', 'kategori')
                ->whereIn('nis', $nis)
                ->where('jenis', 'A')
                ->get()
                ->sortBy('nis')
                ->groupBy(
                    function ($data) {
                        return $data->nis;
                    }
                );
            //dd($pembayaran);
            //dd($kelas) ;
            return view('pembayaran.spp', [
                'title' => 'Daftar Pembayaran SPP kelas ' . $r_kelas,
                'pembayaran' => $pembayaran,
                'kelas' => $kelas,
            ]);
        }
        if (Auth::user()->hasRole(['Kapro'])) {
            $kelas = Auth::user()->jurusan->kelas()->aktif()->get();
            $r_kelas = Kelas::find($request->class_id)->class_name ?? '-';
            $nis = Siswa::aktif()->select('student_number')->where('class_id', $request->class_id)->pluck('student_number');
            $pembayaran = Pembayaran::select('nis', 'nama', 'jenis', 'jenjang', 'paralel', 'tahap', 'jumlah', 'kategori')
                ->whereIn('nis', $nis)
                ->where('jenis', 'A')
                ->get()
                ->sortBy('nis')
                ->groupBy(
                    function ($data) {
                        return $data->nis;
                    }
                );
            return view('pembayaran.spp', [
                'title' => 'Daftar Pembayaran SPP kelas ' . $r_kelas,
                'pembayaran' => $pembayaran,
                'kelas' => $kelas,
            ]);
        }
    }
    public function lain(Request $request)
    {
        if (Auth::user()->hasRole('WaliKelas')) {
            $wali = auth()->user()->kelas;
            $nis = Siswa::aktif()->select('student_number', 'student_name')->where('class_id', $wali->class_id)->get();
            $kelas = explode('-', $wali->class_code);
            switch ($kelas[1]) {
                case 'X':
                    $kel = 10;
                    break;
                case 'XI':
                    $kel = 11;
                    break;
                case 'XII':
                    $kel = 12;
                    break;
            }
            $tahunajaran = Tahunajaran::aktif()->select('year_id', 'year_code')->first();
            //dd($tahunajaran->year_code);
            $tagihan = Tagihan::where([['kelas', $kel], ['tp', $tahunajaran->year_code]])->whereNot('kode', 'A')->get();
            $data = Pembayaran::select('nis', 'jenis', Pembayaran::raw('SUM(jumlah) as total'))
                ->whereIn('nis', $nis->pluck('student_number'))
                ->whereIn('jenis', $tagihan->pluck('kode'))
                ->groupBy('nis', 'jenis')
                ->get()
                ->groupBy('nis')
                ->map(function ($item) {
                    return $item->pluck('total', 'jenis');
                });

            $data = $nis->pluck('student_number')->mapWithKeys(function ($n) use ($data, $tagihan) {
                $studentData = $data->get($n, []);
                foreach ($tagihan->pluck('kode') as $tag) {
                    $studentData[$tag] = $studentData[$tag] ?? 0;
                }
                return [$n => $studentData];
            });
            $title = "Rekap pembayaran kelas " . $wali->class_name;
            return view('pembayaran.lain', compact('title', 'nis', 'tagihan', 'data'));
        }

        if (Auth::user()->hasRole(['Admin', 'Keuangan', 'Kapro'])) {
            if (Auth::user()->hasRole('Kapro')) {
                $kelas = Auth::user()->jurusan->kelas(fn($q) => $q->aktif())->get();
            } else {
                $kelas = Kelas::aktif()->select('class_id', 'class_code', 'class_name')->get();
            }
            $r_kelas = Kelas::find($request->class_id)->class_code ?? '-';
            $nis = Siswa::with('tagihan')->aktif()->select('student_number', 'student_name')->where('class_id', $request->class_id)->get();
            $s_kelas = explode('-', $r_kelas);
            $kel = 10;
            switch ($s_kelas[1]) {
                case 'X':
                    $kel = 10;
                    break;
                case 'XI':
                    $kel = 11;
                    break;
                case 'XII':
                    $kel = 12;
                    break;
            }
            $tahunajaran = Tahunajaran::aktif()->select('year_id', 'year_code')->first();
            $tagihan = Tagihan::where([
                ['kelas', $kel],
                ['tp', $tahunajaran->year_code]
            ])->whereNot('kode', 'A')->get();
            $data = Pembayaran::select('nis', 'jenis', Pembayaran::raw('SUM(jumlah) as total'))
                ->whereIn('nis', $nis->pluck('student_number'))
                ->whereIn('jenis', $tagihan->pluck('kode'))
                ->groupBy('nis', 'jenis')
                ->get()
                ->groupBy('nis')
                ->map(function ($item) {
                    return $item->pluck('total', 'jenis');
                });

            $data = $nis->pluck('student_number')->mapWithKeys(function ($n) use ($data, $tagihan) {
                $studentData = $data->get($n, []);
                foreach ($tagihan->pluck('kode') as $tag) {
                    $studentData[$tag] = $studentData[$tag] ?? 0;
                }
                return [$n => $studentData];
            });

            // get total_tagihan from model : TagihanSiswa->total_tagihan for each student based on $nis->student_number
            /*            $total_tagihan = [];
            foreach ($nis as $siswa) {
                $tagihanSiswa = \App\Models\TagihanSiswa::where('nis', $siswa->student_number)->first();
                $total_tagihan[$siswa->student_number] = $tagihanSiswa ? $tagihanSiswa->total_tagihan : 0;
            }
            dd($total_tagihan);
*/


            $title = "Rekap pembayaran kelas " . $r_kelas;
            return view('pembayaran.lain', compact('title', 'nis', 'tagihan', 'data', 'kelas'));
        }
    }
    public function sync()
    {
        $pembayaranOl = Pembayaran2425Ol::all();
        foreach ($pembayaranOl as $pem) {
            Pembayaran::updateOrCreate(
                ['no' => $pem->no],
                $pem->toArray()
            );
        }
        alert()->success('Sukses', 'Pembayaran berhasil tersinkronisasi');
        return redirect()->back();
    }

    public function nominasi(Request $request)
    {
        if (Auth::user()->hasRole(['Admin', 'Keuangan', 'Kapro'])) {
            $kelas = Kelas::aktif()->select('class_id', 'class_code', 'class_name')->get();
            $r_kelas = Kelas::find($request->class_id)->class_code ?? '-';
            $nis = Siswa::aktif()->select('student_number', 'student_name')->where('class_id', $request->class_id)->get();
            $s_kelas = explode('-', $r_kelas);
            $kel = 10;
            switch ($s_kelas[1]) {
                case 'X':
                    $kel = 10;
                    break;
                case 'XI':
                    $kel = 11;
                    break;
                case 'XII':
                    $kel = 12;
                    break;
            }
            $tahunajaran = Tahunajaran::aktif()->select('year_id', 'year_code')->first();
            $tagihan = Tagihan::where([['kelas', $kel], ['tp', $tahunajaran->year_code]])->whereNot('kode', 'A')->get();
            $data = Pembayaran::select('nis', 'jenis', Pembayaran::raw('SUM(jumlah) as total'))
                ->whereIn('nis', $nis->pluck('student_number'))
                ->whereIn('jenis', $tagihan->pluck('kode'))
                ->groupBy('nis', 'jenis')
                ->get()
                ->groupBy('nis')
                ->map(function ($item) {
                    return $item->pluck('total', 'jenis');
                });

            $data = $nis->pluck('student_number')->mapWithKeys(function ($n) use ($data, $tagihan) {
                $studentData = $data->get($n, []);
                foreach ($tagihan->pluck('kode') as $tag) {
                    $studentData[$tag] = $studentData[$tag] ?? 0;
                }
                return [$n => $studentData];
            });
            $title = "Rekap pembayaran kelas " . $r_kelas;
            return view('pembayaran.nominasi', compact('title', 'nis', 'tagihan', 'data', 'kelas'));
        }
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
