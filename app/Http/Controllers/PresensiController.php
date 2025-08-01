<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:presensi-list|presensi-create|presensi-edit|presensi-delete', ['only' => ['index','show','laporan']]);
         $this->middleware('permission:presensi-create', ['only' => ['create','store']]);
         $this->middleware('permission:presensi-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:presensi-delete', ['only' => ['destroy','reset']]);
         $this->middleware('permission:presensi-admin', ['only' => ['admin']]);
    }

    public function index(Request $request)
    {

        if (Auth::user()->hasRole('WaliKelas')) {
            $kelas = Auth::user()->kelas;
            $siswas=Siswa::aktif()->select('student_id','student_name','student_number')
                ->where([['class_id',$kelas->class_id],
                ])->get();
            //dd($siswas);u
        } else {
            $kelas=Kelas::get();
            $siswas=Siswa::select('student_id','student_name','student_number')->get();

        }
        return view('presensi.index',[
            'students'=>$siswas,
            'title'=>'Input Presensi Siswa',
            'kelas' =>$kelas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->has('kelas')) {
            $kelas = $request->kelas;
            $siswas =Siswa::where('kelas_id',$kelas);
        } else {
            $ta = Tahunajaran::where('is_active',1);
            $kelas = Kelas::where('year_id',$ta)->get();
            $siswas =null;
        }
        return view('presensi.create',[
            'students'=>$siswas,
            'title'=>'Input Presensi Siswa',
            'kelas' =>$kelas,
            'tanggal' =>$tanggal,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) //gak dipake
    {
        $request->validate([
            'student_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);
        $student_ids = $request->student_id;
        $keterangans = $request->keterangan;
        $tanggal = Carbon::parse($request->tanggal);
        $alasans = $request->alasan;
        //dd($tanggal);

        if (is_array($student_ids)) {
            foreach ($student_ids as $index => $student_id) {
                //cek duplikasi data presensi
                $cek = Presensi::where('student_id', $student_id)->where('tanggal', $tanggal)->first();
                if ($cek) {
                    alert()->error('Kesalahan', 'Data kehadiran tanggal '.$tanggal->format('Y-m-d').' sudah ada.');
                    return redirect()->route('presensi.index')->withInput();
                }
                $keterangan = $keterangans[$index];
                $alasan = $alasans[$index];
                Presensi::create([
                    'student_id' => $student_id,
                    'keterangan' => $keterangan,
                    'kelas_id' => Auth::user()->kelas->class_id,
                    'user_id' => Auth::user()->id,
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'alasan' => $alasan,
                ]);
            }
        }
        alert()->success('Sukses', 'Data kehadiran tanggal '.$tanggal->format('Y-m-d').' berhasil disimpan.');
        return redirect()->route('presensi.index');
    }
    public function store1(Request $request) {
        $request->validate([
            'student_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required|date_format:Y-m-d',
        ]);
        $student_id = $request->student_id;
        $keterangan = $request->keterangan;
        $tanggal = Carbon::parse($request->tanggal);
        $alasan = $request->alasan;
        Presensi::create([
            'student_id' => $student_id,
            'keterangan' => $keterangan,
            'kelas_id' => Auth::user()->kelas->class_id,
            'user_id' => Auth::user()->id,
            'tanggal' => $tanggal->format('Y-m-d'),
            'alasan' => $alasan,
        ]);
        alert()->success('Sukses', 'Data kehadiran tanggal '.$tanggal->format('Y-m-d').' berhasil disimpan.');
        return redirect()->route('presensi.index');
        //dd($tanggal);
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
    public function edit(Request $request)
    {
        //$tanggal= $request->get('tanggal');
        if (Auth::user()->hasRole('WaliKelas')) {
            //dd('wali kelas');
            //dd(Carbon::parse($request->tanggal)->format('Y-m-d'));
            $kelas = Auth::user()->kelas;
            //dd(Auth::user()->siswas()->get());
            //dd($kelas);
            if($request->has('tanggal')){
                $tanggal= Carbon::parse($request->tanggal)->format('Y-m-d');
            } else {
                $tanggal = date("Y-m-d");
            }
            $presensis = $kelas->presensis()->where([
                ['tanggal','=',$tanggal ]
            ])->get();
            //dd($presensis);

            return view('presensi.edit',[
                'tanggal'=>$tanggal,
                'kelas' => $kelas,
                'presensis'=>$presensis,
                'title'=>'Edit Presensi Siswa',
            ]);
        }
        //dd('bukan wali');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tanggal = $request->input('tanggal');
        $kelas = $request->input('kelas');
        $user_id = Auth::user()->id;
        $attendance=Presensi::where('kelas_id',$kelas)->where('tanggal',$tanggal);
        $validatedData= $request->validate([
            'siswa.*.id' => 'required',
            'siswa.*.keterangan' => 'required|in:H,S,I,A,T,N',
            'siswa.*.alasan' => 'nullable',
        ]);
        //simpan ke database
        foreach ($validatedData['siswa'] as $siswaData) {
            $attendance->updateOrCreate(
                ['student_id' => $siswaData['id']],
                [
                    'keterangan' => $siswaData['keterangan'],
                    'alasan' => $siswaData['alasan'],
                    'kelas_id' => $kelas,
                    'tanggal' => $tanggal,
                    'user_id' => $user_id,
                ]
            );
        }
        alert()->success('Sukses', 'Data kehadiran tanggal '.$tanggal.' berhasil disimpan.');
        // Redirect kembali ke halaman presensi
        return redirect()->route('presensi.edit',$tanggal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function laporan(Request $request)
    {
        if (Auth::user()->hasRole('WaliKelas')) {
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun') ?? now()->format('Y');
            $kelas = Auth::user()->kelas;
            $students = Siswa::where([
                ['class_id',$kelas->class_id],
                ['student_status','A']
                ])->select('student_id','student_name','student_number')->get();
            $jumlahHari = Carbon::create($tahun,$bulan)->daysInMonth;
            //dd($students);
            $presensiData = [];

            $presensiRecords = Presensi::whereIn('student_id', $students->pluck('student_id'))
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get()
                ->groupBy('student_id');

            foreach ($students as $student) {
                $presensiData[$student->student_id] = [];
                foreach (range(1, $jumlahHari) as $day) {
                    $date = Carbon::create($tahun, $bulan, $day)->format('Y-m-d');
                    $presensiStatus = $presensiRecords->get($student->student_id)
                        ? optional($presensiRecords->get($student->student_id)->firstWhere('tanggal', $date))->keterangan ?? '-' 
                        : '-';
                    $presensiData[$student->student_id][$day] = $presensiStatus;
                }
            }
            //dd($presensiData);
            return view('presensi.laporan', [
                'students' => $students,
                'jumlahHari' => $jumlahHari,
                'kelas' => $kelas,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'presensiData' => $presensiData,
                'title' => 'Laporan Presensi Siswa bulan '.$bulan .' Tahun '.$tahun ,
            ]);
        } elseif (Auth::user()->hasRole('Guru')) {
            return view('presensi.laporan', [
                'title' => 'Laporan Presensi Siswa',
                'kelas' => Kelas::aktif()->orderBy('class_name')->get(),
            ]);
        }
    }
    public function admin(Request $request) {
        $bulan = $request->input('bulan') ?? now()->format('m');
        $tahun = $request->input('tahun') ?? now()->format('Y');
        $ta = Tahunajaran::where('is_deleted', 0)->where('is_active', 1)->first();
        $kelas = Kelas::aktif()->where('year_id', $ta->year_id)->orderBy('class_name')->get();
        $jumlahHari = Carbon::create($tahun, $bulan)->daysInMonth;

        $presensiRecords = Presensi::whereIn('kelas_id', $kelas->pluck('class_id'))
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get()
            ->groupBy('kelas_id');

        $kelasdata = [];

        foreach ($kelas as $kel) {
            $kelasdata[$kel->class_id] = [];
            foreach (range(1, $jumlahHari) as $day) {
            $date = Carbon::create($tahun, $bulan, $day)->format('Y-m-d');
            $kelasdata[$kel->class_id][$day] = isset($presensiRecords[$kel->class_id]) && $presensiRecords[$kel->class_id]->contains('tanggal', $date) ? 'v' : '-';
            }
        }
        //dd($kelasdata);
        return view('presensi.admin', [
            'kelas' => $kelas,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'jumlahHari' => $jumlahHari,
            'kelasdata' => $kelasdata,
            'title' => 'Laporan Presensi Siswa bulan '.$bulan .' Tahun '.$tahun ,
        ]);
    }
    public function reset(Request $request) {
        if($request->has('kelas') && $request->has('tanggal')) {
            $kelas = $request->input('kelas');
            $tanggal = $request->input('tanggal');
            Presensi::where([
                ['kelas_id', $kelas],
                ['tanggal', $tanggal]
            ])->delete();
            return redirect()->route('presensi.reset')->with('success', 'Data kehadiran tanggal '.$tanggal.' pada kelas '.$kelas.' berhasil direset.');
        } else {
            $kelas = Kelas::aktif()->get();
            return view ('presensi.reset', [
                'kelas' => $kelas,
            ]);
        };
    }
    public function rekapIndex() {
        if (Auth::user()->hasRole('Kapro')) {
            $kelas = Auth::user()->jurusan->kelas;
            //dd($kelas);
        } else {
            $kelas=Kelas::aktif()->select('class_id','class_name')->get();
        }
        return view ('presensi.rekap_index', [
            'title' => 'Rekap Presensi Siswa',
            'kelas' => $kelas,
        ]);
    }
    public function rekapShow(Request $request) {
        $dari=Carbon::parse($request->input('dari'));
        $sampai=Carbon::parse($request->input('sampai'));

        if(Auth::user()->hasRole('WaliKelas')) {
            $kelas = Auth::user()->kelas;
            $siswas = Siswa::aktif()->where('class_id', $kelas->class_id);
        } elseif(Auth::user()->hasRole('Kapro')) {
            $kelas = Auth::user()->jurusan->kelas;
            $siswas = Siswa::aktif()->where('class_id', $request->input('kelas'));
            //dd($siswas);
        } else {
            $kelas = Kelas::aktif()->select('class_id','class_name')->get();
            if($request->input('kelas')==0) {
                $siswas = Siswa::aktif();
            } else {
                $siswas = Siswa::aktif()->where('class_id', $request->input('kelas'));
            }
        }
        //$siswas = Siswa::aktif();
        $siswa=$siswas->withCount([
            'presensis as totalS'=>function($query) use ($dari, $sampai) {
            $query->whereBetween('tanggal',[$dari,$sampai])->where('keterangan','S');
            },
            'presensis as totalI'=>function($query) use ($dari, $sampai) {
                $query->whereBetween('tanggal',[$dari,$sampai])->where('keterangan','I');
            },
            'presensis as totalA'=>function($query) use ($dari, $sampai) {
                $query->whereBetween('tanggal',[$dari,$sampai])->where('keterangan','A');
            },
        ])->orderBy('class_id')
        ->orderBy('student_number')
        ->get();
        //$s=$siswa->find(900)->totalA;
        //dd($s); 
        return view ('presensi.rekap_show', [
            'title' => 'Rekap Presensi Siswa',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'dari' => $dari->format('d-m-Y'),
            'sampai' => $sampai->format('d-m-Y'),
        ]);
    }
    public function apiPresensi($dev, $nis, $jam) {
        $siswa = Siswa::where('student_number', $nis)->first();
        if(!$siswa) {
            return response()->json([
                'status' => 'error',
                'nama' => '-',
                'keterangan' => 'NIS tidak ditemukan',
                'nis' => '-',
            ]);
        };
        $kelas = $siswa->kelas;
        $tanggal = Carbon::now()->format('Y-m-d');
        $presensi = Presensi::where([
            ['student_id', $siswa->student_id],
            ['kelas_id', $kelas->class_id],
            ['tanggal', $tanggal],
        ])->first();
        
        $keterangan='';
        if ($jam <= '07:00:00') {
            $keterangan = 'H';
            $keteranganJ= 'Tepat Waktu';
        } else {
            $keterangan = 'T';
            $keteranganJ = 'Terlambat';
        }
        if ($presensi) {
            $presensi->jam_masuk = $jam;
            $presensi->save();
        } else {
            Presensi::create([
                'student_id' => $siswa->student_id,
                'kelas_id' => $kelas->class_id,
                'keterangan' => $keterangan,
                'tanggal' => $tanggal,
                'jam_masuk' => $jam,
                'user_id' => Auth::user()->id,
            ]);
        }
        return response()->json([
            'status' => 'sukses',
            'nama' => $siswa->student_name,
            'keterangan' => $keterangan,
            'nis' => $siswa->student_number,
        ]);
    }
}

