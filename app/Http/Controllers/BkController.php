<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;
use Illuminate\Http\JsonResponse;

class BkController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pelanggaran-list|pelanggaran-create|pelanggaran-edit|pelanggaran-delete', ['only' => ['index','show','search']]);
         $this->middleware('permission:pelanggaran-create', ['only' => ['create','store']]);
         $this->middleware('permission:pelanggaran-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pelanggaran-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }
    public function create()
    {
           $siswas= Siswa::get();
           $pelanggaran=JenisPelanggaran::get();
           return view('bk.create',compact('siswas','pelanggaran'));
    }

    public function search(Request $request) : JsonResponse
    {
        $data = [];
     
        if($request->filled('siswa_id')){
            $data = Siswa::select('student_name', 'student_id')
                        ->where('student_name', 'LIKE', '%'. $request->get('siswa_id'). '%')
                        ->take(10)
                        ->get();
        }
      
        return response()->json($data);
    }

    public function store(Request $request)
    {
        //
    }
    
}
