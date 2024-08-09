<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Woroworo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(Auth::user()->id);
        $set1 = [
            'chart_title' => '.',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Presensi',
            'group_by_field' => 'tanggal',
            'group_by_field_format' => 'Y-m-d',
            'group_by_period' => 'day',
            'where_raw' => 'keterangan = "T"',
            'chart_type' => 'bar',
            'chart_color' => '38,115,182',
            'name'  => 'Terlambat',
        ];
        $set2 = [
            'chart_title' => '.',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Presensi',
            'group_by_field' => 'tanggal',
            'group_by_field_format' => 'Y-m-d',
            'group_by_period' => 'day',
            'where_raw' => 'keterangan = "A"',
            'chart_type' => 'line',
            'chart_color' => '255,29,72',
            'name'  => 'Alpha',
        ];
        $set3 = [
            'chart_title' => 'Grafik Kehadiran Siswa',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Presensi',
            'group_by_field' => 'tanggal',
            'group_by_field_format' => 'Y-m-d',
            'group_by_period' => 'day',
            'where_raw' => 'keterangan = "S" OR keterangan = "I"',
            'chart_type' => 'line',
            'chart_color' => '31,175,5',
            'name'  => 'Sakit/Ijin',
        ];
        $chart1 = new LaravelChart($set1,$set2,$set3);
        $alpha = Presensi::where('keterangan','A')->where('tanggal', Carbon::today()->format('Y-m-d'))->count();
        $terlambat = Presensi::where('keterangan','T')->where('tanggal', Carbon::today()->format('Y-m-d'))->count();
        $sudah = Presensi::where('tanggal', Carbon::today()->format('Y-m-d'))->count();
        $belum = Siswa::where('is_deleted', 0)->count() - $sudah;
        //get 10 data  siwa dengan alpha terbanyak
        if(Auth::user()->hasRole('WaliKelas')){
            $user_id=Auth::user()->id;
            $kelas= Kelas::where('user_id', $user_id)->first();
            //dd($kelas->class_id);
            $nom_alphas = Presensi::with('siswa')->select(['student_id', DB::raw('count(*) as total')])
            ->where('keterangan','A')
            ->where('kelas_id', $kelas->class_id)
            ->groupBy('student_id')
            ->orderBy('total', 'desc')
            ->limit(10)->get();
            $nom_terlambat = Presensi::with('siswa')->select(['student_id', DB::raw('count(*) as total')])
            ->where('keterangan','T')
            ->where('kelas_id', $kelas->class_id)
            ->groupBy('student_id')
            ->orderBy('total', 'desc')
            ->limit(10)->get();
        } else {
            $nom_alphas = Presensi::with('siswa')->select(['student_id', DB::raw('count(*) as total')])
            ->where('keterangan','A')
            ->groupBy('student_id')
            ->orderBy('total', 'desc')
            ->limit(10)->get();
            $nom_terlambat = Presensi::with('siswa')->select(['student_id', DB::raw('count(*) as total')])
            ->where('keterangan','T')
            ->groupBy('student_id')
            ->orderBy('total', 'desc')
            ->limit(10)->get();
        }
        
        $woro2 = Woroworo::where('status','aktif')->latest()->take(5)->get();
        //dd($woro2);
        return view('home',[
            'chart1' => $chart1,
            'alpha' => $alpha,
            'terlambat' => $terlambat,
            'belum' => $belum,
            'nom_alphas' => $nom_alphas,
            'nom_terlambat' => $nom_terlambat,
            'woro2' => $woro2,
            ]);
    }
}
