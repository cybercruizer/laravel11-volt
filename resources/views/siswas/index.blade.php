@extends('layouts.app')

@section('content')
        <div class="card-header">
            @role('Admin|Bk')
                <h2 class="mb-4 h5">{{ __('Daftar Siswa') }}</h2>
            @endrole
            @role('WaliKelas')
                <h2 class="mb-4 h5">{{ __('Daftar Siswa kelas :'.Auth::user()->kelas->class_name) }}</h2>
            @endrole

        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            @can('siswa-create')
                <a href="" class="btn btn-primary">Tambah Siswa</a>
            @endcan
            <table class="table table-bordered" id="siswaDataTables">
                <thead>
                   <tr>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Aksi</th>
                   </tr>
                </thead>
             </table>
        </div>
@endsection
@push('scripts')
    <script>
        $(document).ready( function () {
            $('#siswaDataTables').DataTable({
                   processing: true,
                   serverSide: true,
                   ajax: "{{ url('siswas') }}",
                   columns: [
                        { data: 'student_number', name: 'student_number' },
                        { data: 'student_name', name: 'student_name' },
                        { data: 'nama_kelas', name: 'nama_kelas' },
                        //{ data: 'student_email', name: 'student_email' }
                        { data: 'aksi', 
                            render:function(data){
                                return '<a href="/siswas/'+data+'" class="btn btn-primary btn-sm" target="_blank">Detail</a>';
                            }
                        }
                 ]
        });
     });
    </script>
@endpush
