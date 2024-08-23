<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Tahunajaran;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pelanggaran-list|pelanggaran-create|pelanggaran-edit|pelanggaran-delete', ['only' => ['jenispelanggaranIndex','pelanggaranIndex']]);
         $this->middleware('permission:pelanggaran-create', ['only' => ['jenispelanggaranStore','pelanggaranStore','pelanggaranCreate']]);
         $this->middleware('permission:pelanggaran-edit', ['only' => ['jenispelanggaranUpdate','pelanggaranUpdate','jenispelanggaranEdit','pelanggaranEdit']]);
         $this->middleware('permission:pelanggaran-delete', ['only' => ['jenispelanggaranDestroy','pelanggaranDestroy']]);
    }
    public function jenispelanggaranIndex() {
        $jenis= JenisPelanggaran::get();
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
        return redirect()->route('jenispelanggaran.index')->with('success','Jenis Pelanggaran berhasil diinput');
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
        return view('jenispelanggaran.index',['jenis'=>$jenis])->with('success','Jenis Pelanggaran berhasil dihapus');
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
            $title='Laporan Pelanggaran Siswa Kelas ';
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
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran berhasil diinput');
    }

    public function pelanggaranEdit($id)
    {
        $pelanggaran = Pelanggaran::find($id);
        $jenispelanggaran=JenisPelanggaran::get();
        return view('pelanggaran.edit',['pelanggaran'=>$pelanggaran,'jenispelanggaran'=>$jenispelanggaran]);
    }
    public function pelanggaranUpdate(Request $request, $id)
    {
        $request->validate([
            'pelanggaran' => 'required',
            'jenis' => 'required',
            'poin' => 'required|numeric|max:500',
            'tanggal' => 'required',
        ]);
        $data = Pelanggaran::find($id);
        $data->update(
            [
                'pelanggaran' => $request->pelanggaran,
                'jenis' => $request->jenis,
                'poin' => $request->poin,
                'tindaklanjut' => $request->tindaklanjut,
                'tanggal' => $request->tanggal,
            ]
        );
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran berhasil diupdate');
    }
    public function pelanggaranDestroy($id)
    {
        $data = Pelanggaran::find($id);
        $data->delete();
        return redirect()->route('pelanggaran.index')->with('success','Pelanggaran berhasil dihapus');
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
