<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class PelanggaranController extends Controller
{
    private $satitle = 'Konfirmasi Penghapusan';
    private $satext = 'Yakin menghapus data pelanggaran ';
    function __construct()
    {
         $this->middleware('permission:pelanggaran-list|pelanggaran-create|pelanggaran-edit|pelanggaran-delete', ['only' => ['pelanggaranIndex']]);
         $this->middleware('permission:pelanggaran-create', ['only' => ['pelanggaranStore','pelanggaranCreate']]);
         $this->middleware('permission:pelanggaran-edit', ['only' => ['pelanggaranUpdate','pelanggaranEdit']]);
         $this->middleware('permission:pelanggaran-delete', ['only' => ['pelanggaranDestroy']]);

         $this->middleware('permission:jenispelanggaran-list|jenispelanggaran-create|jenispelanggaran-edit|jenispelanggaran-delete', ['only' => ['jenispelanggaranIndex']]);
         $this->middleware('permission:jenispelanggaran-create', ['only' => ['jenispelanggaranStore','jenispelanggaranCreate']]);
         $this->middleware('permission:jenispelanggaran-edit', ['only' => ['jenispelanggaranUpdate','jenispelanggaranEdit']]);
         $this->middleware('permission:jenispelanggaran-delete', ['only' => ['jenispelanggaranDestroy']]);

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
    public function jenispelanggaranIndex() {
        $jenis= JenisPelanggaran::get();
        confirmDelete($this->satitle, $this->satext);
        return view('jenispelanggaran.index',[
            'jenis'=>$jenis,
            'title' => 'Daftar Jenis Pelanggaran',
        ]);
    }
    public function jenispelanggaranStore(Request $request) {
        $request->validate([
            'nama' => 'required',
            'poin' => 'required|numeric|max:500',
        ]);
        $nama = $request->nama;
        $poin = $request->poin;
        $desk = $request->deskripsi;
        
        JenisPelanggaran::create([
            'nama' => $nama,
            'poin' => $poin,
            'deskripsi' => $desk,
        ]);
        Alert::toast('Jenis Pelanggaran Berhasil ditambahkan','success');
        return back();
    }
    public function jenispelanggaranEdit($id) {
        $jenis = JenisPelanggaran::find($id);
        //dd($jenis);
        return view('jenispelanggaran.edit',['jenis'=>$jenis]);
    }
    public function jenispelanggaranUpdate(Request $request, $id) {
        $request->validate([
            'nama' => 'required',
            'poin' => 'required|numeric|max:500',
        ]);
        $data = JenisPelanggaran::find($id);
        $data->update(
            [
                'nama' => $request->nama,
                'poin' => $request->poin,
                'deskripsi' => $request->deskripsi,
            ]
        );
        return redirect()->route('jenispelanggaran.index')->with('success','Jenis Pelanggaran berhasil diupdate');
    }
    public function jenispelanggaranDestroy($id) {
        $data = JenisPelanggaran::find($id);
        $data->delete();
        $jenis= JenisPelanggaran::get();
        Alert::toast('Jenis Pelanggaran Berhasil dihapus', 'success');
        return back();
    }
    public function pelanggaranIndex()
    {
        $month = Carbon::now()->format('m');
        if(Auth::user()->hasRole('WaliKelas')) {
            $siswa= Siswa::with('pelanggarans')->where([
                ['class_id',Auth::user()->kelas->class_id],
                ['student_status','A']]
            )->get();
            //dd($siswa);
            $title='Laporan Pelanggaran Siswa Kelas '.Auth::user()->kelas->class_name;
            return view('pelanggaran.index-perkelas',compact('siswa','month','title'));
        } else {
            $pelanggaran=Pelanggaran::with('jenisPelanggaran','siswa')->orderBy('tgl_pelanggaran')->get()->groupBy(function($data) {
                return Carbon::parse($data->tgl_pelanggaran)->format('Y-m-d');
            });
            $title='Laporan Pelanggaran Siswa' ;
            confirmDelete($this->satitle, $this->satext);
            return view('pelanggaran.index',compact('pelanggaran','month','title'));
        }
    }
    public function pelanggaranCreate()
    {
        $jenispelanggaran=JenisPelanggaran::get();
        $siswas = Siswa::select('student_id','student_number','student_name')->get();
        return view('pelanggaran.create',[
            'jenis'=>$jenispelanggaran,
            'siswas'=>$siswas
        ]);
    }

    public function pelanggaranStore(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'siswa' => 'required',
            'pelanggaran' => 'required',
            'tanggal' => 'required|date',
        ]);
        $ta = Tahunajaran::where('is_active', 1)->first();
        $poin = JenisPelanggaran::find($request->pelanggaran)->poin;
        //dd($poin);
        $siswa_id = $request->siswa;
        $tanggal = $request->tanggal;
        $pelanggaran = $request->pelanggaran;
        $deskripsi = $request->deskripsi;
        $tindaklanjut = $request->tindaklanjut;
        $siswa=Siswa::find($siswa_id);
        Pelanggaran::create([
            'tahun_ajaran_id' => $ta->year_id,
            'user_id' => auth()->user()->id,
            'siswa_id' => $siswa_id,
            'tgl_pelanggaran' => $tanggal,
            'jenis_pelanggaran_id' => $pelanggaran,
            'deskripsi' => $deskripsi,
            'poin' => $poin,
            'tindaklanjut' => $tindaklanjut
        ]);
        Alert::toast('Data pelanggaran untuk '.$siswa->student_name.' berhasil ditambahkan','success');
        return back();
    }

    public function pelanggaranEdit($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $jenispelanggaran=JenisPelanggaran::get();
        return view('pelanggaran.edit',[
            'pelanggaran'=>$pelanggaran,
            'jenis'=>$jenispelanggaran
        ]);
    }
    public function pelanggaranUpdate(Request $request, $id)
    {
        $request->validate([
            'siswa' => 'required',
            'pelanggaran' => 'required',
            'pelanggaran' => 'required',
            'tanggal' => 'required',
        ]);
        $poin = JenisPelanggaran::find($request->pelanggaran)->poin;
        $data = Pelanggaran::find($id);
        $data->update(
            [
                'tahun_ajaran_id' => $request->ta_id,
                'user_id' => Auth::user()->id,
                'siswa_id' => $request->siswa,
                'tgl_pelanggaran' => $request->tanggal,
                'jenis_pelanggaran_id' => $request->pelanggaran,
                'poin' => $poin,
                'deskripsi' => $request->deskripsi,
                'tindaklanjut' => $request->tindaklanjut,
                
            ]
        );
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran berhasil diupdate');
    }
    public function pelanggaranDestroy($id)
    {
        $data = Pelanggaran::find($id);
        $data->delete();
        Alert::toast('Pelanggaran berhasil dihapus','success');
        return back();
    }
    public function pelanggaranCari(Request $request)
    {
        if($request->has('cari'))
        {
            $siswa = Pelanggaran::with('jenisPelanggaran')->where('siswa_id',$request->cari)->orderBy('tgl_pelanggaran')->get()->groupBy(function($data) {
                return Carbon::parse($data->tgl_pelanggaran)->format('Y-m-d');
            });
            $detailsiswa=Siswa::with('pelanggarans')->find($request->cari);
            //dd($siswa);
        } else {
            $siswa=Siswa::select('student_id','student_name','student_number')->limit(5)->get();
            $status='awal';
        }
        //dd($siswa);
        return view('pelanggaran.cari',['siswas'=>$siswa,'status'=>$status ?? 'hasil','detailSiswa'=>$detailsiswa ?? null]);
    }


}
