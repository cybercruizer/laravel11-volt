<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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
            } elseif(Auth::user()->hasRole('Kapro')) {
                $kelas = Auth::user()->jurusan->kelas;
                $siswas = Siswa::aktif()->whereIn('class_id',$kelas->select('class_id'))->get();
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
           $siswas = Siswa::orderby('student_name','asc')->select('student_id','student_name')->limit(10)->get();
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
     public function edit(Siswa $siswa)
    {
        $classes = Kelas::where('is_deleted', 0)->get();
        $provinces = Wilayah::provinces()->get();
        return view('siswas.edit', compact('siswa', 'classes','provinces'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $kategori = $siswa->student_category;
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'student_number' => 'required|string|max:50|unique:spa_students,student_number,' . $siswa->student_id . ',student_id',
            'class_id' => 'required',
        //    'student_category' => 'nullable|string|max:50',
            'student_pob' => 'nullable|string|max:100',
            'student_dob' => 'nullable|date',
            'student_gender' => 'required|in:L,P',
            'student_nik' => 'nullable|string|max:20',
            'student_nkk' => 'nullable|string|max:20',
            'student_school_name' => 'nullable|string|max:255',
            'student_province' => 'nullable|string|max:100',
            'student_city' => 'nullable|string|max:100',
            'student_district' => 'nullable|string|max:100',
            'student_village' => 'nullable|string|max:100',
            'student_address' => 'nullable|string',
            'student_phone' => 'nullable|string|max:20',
            'ortu_phone' => 'nullable|string|max:20',
            'student_year_in' => 'nullable|integer|min:2020|max:' . (date('Y') + 1),
            'student_year_out' => 'nullable|integer|min:2023|max:' . (date('Y') + 10),
            'student_status' => 'nullable|in:A,L,P',
        ]);
        //dd($request);
        
        if ($validator->fails()) {
            return redirect()
                ->route('siswas.edit', $siswa->student_id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $siswa->update([
                'student_name' => $request->student_name,
                'student_number' => $request->student_number,
                'class_id' => $request->class_id,
                'student_category' => $kategori,
                'student_pob' => $request->student_pob,
                'student_dob' => $request->student_dob,
                'student_gender' => $request->student_gender,
                'student_nik' => $request->student_nik,
                'student_nkk' => $request->student_nkk,
                'student_school_name' => $request->student_school_name,
                'student_province' => $request->student_province,
                'student_city' => $request->student_city,
                'student_district' => $request->student_district,
                'student_village' => $request->student_village,
                'student_address' => $request->student_address,
                'student_phone' => $request->student_phone,
                'ortu_phone' => $request->ortu_phone,
                'student_year_in' => $request->student_year_in,
                'student_year_out' => $request->student_year_out,
                'student_status' => $request->student_status,
            ]);

            DB::commit();
            Alert::success('Siswa berhasil diupdate', 'Success');
            return redirect()
                ->route('siswas.index')
                ->with('success', 'Student data has been successfully updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Siswa gagal diupdate', 'Failed');
            return redirect()
                ->route('siswas.edit', $siswa->student_id)
                ->with('error', 'Failed to update student data. ' . $e->getMessage())
                ->withInput();
        }
    }
}
