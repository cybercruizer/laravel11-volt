<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function getKelas(Request $request){
        $search = $request->cari;

        if($search == ''){
           $siswas = Kelas::orderby('class_name','asc')->select('class_id','class_name')->limit(10)->get();
        }else{
           $siswas = Kelas::orderby('class_name','asc')->select('class_id','class_name')->where('class_name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($kelas as $kel){
           $response[] = array(
                "id"=>$kel->class_id,
                "text"=>$kel->class_name
           );
        }
        return response()->json($response);
     }
     public function index() {
         $kelas = Kelas::all()->groupBy('class_year');
         //dd($kelas);
         return view('kelas.index', compact('kelas'));
      
     }
}
