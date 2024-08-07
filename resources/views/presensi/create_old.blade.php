@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">{{ __('Isi Presensi Siswa tanggal ' . $tanggal) }}</h2>
            </div>
        </div>
        <form action="{{ route('presensi.create') }}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    @role('Admin|Bk|WaliKelas')
                        {{ html()->date($name = 'tanggal', $value = old('tanggal'), $format = 'd-m-Y')->class('form-control')->type('date') }}
                        @endrole
                </div>
                <div class="col">
                        @role('Admin|Bk')
                            {{ html()->select($name = 'kelas', $options = [$kelas->pluck('class_name', 'class_id')], $value = old('kelas'))->class('form-control') }}
                        @endrole
                </div>
                <div class="col">
                        @role('Admin|Bk')
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        @endrole
                </div>
            </div>
        </form>
    </div>


    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <form action="{{ route('presensi.index') }}" method="POST">
            @csrf
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr class="text-center">
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Keterangan</th>
                        <th>alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_class }}</td>
                            <input type="hidden" name="student_id[]" value="{{ $student->student_id }}">
                            <td>
                                <select name="keterangan[]" id="student_id" class="form-control">
                                    <option value="H">Hadir</option>
                                    <option value="A">Alpha</option>
                                    <option value="S">Sakit</option>
                                    <option value="T">Terlambat</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="alasan[]"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>

        </form>
    </div>
@endsection
