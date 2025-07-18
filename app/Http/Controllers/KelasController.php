<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KelasController extends Controller
{
   public function getKelas(Request $request)
   {
      $search = $request->cari;

      if ($search == '') {
         $kelas = Kelas::orderby('class_name', 'asc')->select('class_id', 'class_name')->limit(10)->get();
      } else {
         $kelas = Kelas::orderby('class_name', 'asc')->select('class_id', 'class_name')->where('class_name', 'like', '%' . $search . '%')->limit(5)->get();
      }

      $response = array();
      foreach ($kelas as $kel) {
         $response[] = array(
            "id" => $kel->class_id,
            "text" => $kel->class_name
         );
      }
      return response()->json($response);
   }
   public function index()
   {
      $kelas = Kelas::all()->groupBy('class_year');
      //dd($kelas);
      return view('kelas.index', compact('kelas'));
   }
   public function naikKelasIndex()
   {
      $kelas = Kelas::all()->groupBy('class_year');
      //dd($kelas);
      return view('kelas.naik', compact('kelas'));
   }
   public function naikKelas(Request $request)
   {
      if ($request->has('kelasLama') && $request->has('kelasBaru')) {
         $kelasLama = Kelas::find($request->kelasLama);
         $kelasBaru = Kelas::find($request->kelasBaru);
         if ($kelasLama && $kelasBaru) {
            $siswa = Siswa::where('class_id', $kelasLama->class_id)->get();
            foreach ($siswa as $s) {
               $s->class_id = $kelasBaru->class_id;
               $s->save();
            }
            return redirect()->back()->with('success', 'Siswa berhasil naik kelas.');
         }
      } else {
         return redirect()->back()->with('error', 'Kelas tidak ditemukan.');
      }
   }
   public function step1()
    {
        $classes = Kelas::with('tahunajaran')->get();
        return view('kelas.step1', compact('classes'));
    }

    public function step1Submit(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:spa_classrooms,class_id'
        ]);

        Session::put('naik_kelas.class_lama_id', $request->class_id);
        //dd('Step 1 completed. Class selected: ' . $request->class_id);
        return redirect()->route('kelas.step2');
    }

    public function step2()
    {
        $classId = Session::get('naik_kelas.class_lama_id');
        $students = Siswa::where('class_id', $classId)->get();
        //dd($classId);

        return view('kelas.step2', compact('students'));
    }

    public function step2Submit(Request $request)
    {
        $request->validate([
            'students' => 'required|array'
        ]);

        Session::put('naik_kelas.student_ids', $request->students);
        return redirect()->route('kelas.step3');
    }

    public function step3()
    {
        $classes = Kelas::with('tahunajaran')->get();
        return view('kelas.step3', compact('classes'));
    }

    public function step3Submit(Request $request)
    {
        $request->validate([
            'class_baru_id' => 'required|exists:spa_classrooms,class_id'
        ]);

        Session::put('naik_kelas.class_baru_id', $request->class_baru_id);
        return redirect()->route('kelas.step4');
    }

    public function step4()
    {
        $classLama = Kelas::find(Session::get('naik_kelas.class_lama_id'));
        $classBaru = Kelas::find(Session::get('naik_kelas.class_baru_id'));
        $students = Siswa::whereIn('student_id', Session::get('naik_kelas.student_ids'))->get();
        //dd(Session::get('naik_kelas.student_ids'));

        return view('kelas.step4', compact('classLama', 'classBaru', 'students'));
    }

    public function step4Submit()
    {
        $studentIds = Session::get('naik_kelas.student_ids');
        $classBaruId = Session::get('naik_kelas.class_baru_id');
        $students = Siswa::whereIn('student_id', $studentIds)->get();

        foreach ($students as $student) {
            $student->class_id = $classBaruId;
            $student->year_id = Kelas::find($classBaruId)->year_id; // Update year_id to match the new class
            //$student->is_active = 1; // Ensure the student is active in the new class
            $student->save();
        }

        Session::put('naik_kelas.done_students', $students);
        return redirect()->route('kelas.step5');
    }

    public function step5()
    {
        $classLama = Kelas::find(Session::get('naik_kelas.class_lama_id'));
        $classBaru = Kelas::find(Session::get('naik_kelas.class_baru_id'));
        $students = Session::get('naik_kelas.done_students');

        return view('kelas.step5', compact('classLama', 'classBaru', 'students'));
    }
   
}
