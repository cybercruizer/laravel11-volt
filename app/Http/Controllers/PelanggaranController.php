<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;

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
        return view('jenispelanggaran.index',['jenis'=>$jenis]);
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
        $pelanggarans=Pelanggaran::orderBy('tanggal')->paginate(30);
        return view ('pelanggaran.index',$pelanggarans);
    }

    public function pelanggaranCreate()
    {
        $jenispelanggaran=Pelanggaran::get();
        $siswas = Siswa::select('student_number','student_name')->get();
        return view('pelanggaran.create',[
            'jenispelanggaran'=>$jenispelanggaran,
            'siswas'=>$siswas
        ]);
    }

    public function pelanggaranStore(Request $request)
    {
        $request->validate([
            'pelanggaran' => 'required',
            'jenis' => 'required',
            'poin' => 'required|numeric|max:500',
            'tanggal' => 'required',
        ]);
        $pelanggaran = $request->pelanggaran;
        $jenis = $request->jenis;
        $poin = $request->poin;
        $tanggal = $request->tanggal;
        $tindaklanjut = $request->tindaklanjut;
        Pelanggaran::create([
            'pelanggaran' => $pelanggaran,
            'jenis' => $jenis,
            'poin' => $poin,
            'tindaklanjut' => $tindaklanjut,
            'tanggal' => $tanggal,
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


}
