<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
           $siswas = Siswa::orderby('student_name','asc')->select('student_id','student_name')->where('student_name', 'like', '%' .$search . '%')->limit(10)->get();
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
        // Add logging to track the incoming request
        Log::info('Update request received for student:', [
            'student_id' => $siswa->student_id,
            'request_data' => $request->all()
        ]);

        $kategori = $siswa->student_category;
        $validator = Validator::make($request->all(), [
            'student_name' => 'sometimes|string|max:255',
            'student_number' => 'sometimes|string|max:50|unique:spa_students,student_number,' . $siswa->student_id . ',student_id',
            'class_id' => 'sometimes',
            'student_pob' => 'sometimes|string|max:100',
            'student_dob' => 'sometimes|date',
            'student_gender' => 'sometimes|in:L,P',
            'student_nik' => 'sometimes|string|max:20',
            'student_nkk' => 'sometimes|string|max:20',
            'student_school_name' => 'sometimes|string|max:255',
            'student_province' => 'sometimes|string|max:100',
            'student_city' => 'sometimes|string|max:100',
            'student_district' => 'sometimes|string|max:100',
            'student_village' => 'sometimes|string|max:100',
            'student_address' => 'sometimes|string',
            'student_phone' => 'sometimes|string|max:20',
            'ortu_phone' => 'sometimes|string|max:20',
            'student_year_in' => 'sometimes|integer|min:2020|max:' . (date('Y') + 1),
            'student_year_out' => 'sometimes|integer|min:2023|max:' . (date('Y') + 10),
            'student_status' => 'sometimes|in:A,L,K',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            return redirect()
                ->route('siswas.edit', $siswa->student_id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Log the current state of the student
            Log::info('Current student state:', [
                'before_update' => $siswa->toArray()
            ]);

            $updateData = [
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
            ];

            // Log the update data
            Log::info('Attempting to update with data:', [
                'update_data' => $updateData
            ]);

            // Try to update and get the result
            $updated = $siswa->update($updateData);

            // Log the update result
            Log::info('Update result:', [
                'success' => $updated,
                'after_update' => $siswa->fresh()->toArray()
            ]);

            if (!$updated) {
                throw new \Exception('Failed to update student record');
            }

            DB::commit();
            Alert::success('Siswa berhasil diupdate', 'Success');
            
            return redirect()
                ->route('siswas.index')
                ->with('success', 'Student data has been successfully updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Exception during update:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            Alert::error('Siswa gagal diupdate', 'Failed');
            return redirect()
                ->route('siswas.edit', $siswa->student_id)
                ->with('error', 'Failed to update student data. ' . $e->getMessage())
                ->withInput();
        }
    }
}
