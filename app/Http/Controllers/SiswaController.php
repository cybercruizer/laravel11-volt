<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:siswa-list|siswa-create|siswa-edit|siswa-delete', ['only' => ['index','show','getSiswas']]);
         $this->middleware('permission:siswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:siswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:siswa-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request) {
        if ($request->ajax()) {
            if (Auth::user()->hasRole(['Admin','Bk','Guru'])) {
                $siswas = Siswa::where([
                    ['is_deleted', 0],
                    ['student_status','A']
                    ])->get();
            } elseif (Auth::user()->hasRole('WaliKelas')){
                $kelas=Auth::user()->kelas->class_id;
                $siswas = Siswa::where([
                    ['class_id', $kelas],
                    ['is_deleted', 0],
                    ['student_status','A']
                    ])->get();
            }
            return datatables()->of($siswas)
                ->addColumn('nama_kelas',
                function($siswa) {
                    return $siswa->kelas->class_name;
                })
                ->addColumn('aksi', function ($siswa) {
                    return $siswa->student_id;
                })
                ->make(true);
        }
        return view('siswas.index');
    }
    public function show($id)
    {
        $siswa = Siswa::find($id);
        $title = 'Detail Siswa';
        return view('siswas.show',compact('siswa','title'));
    }

    protected function getActionColumn($siswa)
    {
        $showUrl = route('siswas.show', $siswa->student_id);

        return "
            <a class='waves-effect btn btn-success' data-value='$siswa->student_id' href='$showUrl'>
                <i class='material-icons'>visibility</i> Details
            </a>
        ";
    }
    public function getSiswas(Request $request){
        $search = $request->cari;

        if($search == ''){
           $siswas = Siswa::orderby('student_name','asc')->select('student_id','student_name')->limit(5)->get();
        }else{
           $siswas = Siswa::orderby('student_name','asc')->select('student_id','student_name')->where('student_name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($siswas as $siswa){
           $response[] = array(
                "id"=>$siswa->student_id,
                "text"=>$siswa->student_name
           );
        }
        return response()->json($response);
     }


}
