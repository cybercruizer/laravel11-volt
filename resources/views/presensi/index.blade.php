@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Isi Presensi Siswa</h2>
            </div>
        </div>
    </div>

    <form action="{{ route('presensi.store') }}" method="POST">
        @csrf
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col col-md-6">
                    @role('Admin|Bk|WaliKelas')
                        {{ html()->date($name = 'tanggal', $value = \Carbon\Carbon::now(), $format = 'Y-m-d')->class('form-control')->type('date') }}
                        <span class="text-danger text-sm"> * Perhatikan tanggal presensi ini</span>
                    @endrole
                </div>
                <div class="col-6 text-end">
                    @can('presensi-create')
                    <!-- Modal trigger button -->
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah">
                        Tambah presensi 1 siswa
                    </button>
                    @endcan
                </div>
            </div><br><br>
            
            <table class="table table-bordered table-striped table-responsive mb-0">
                <thead>
                    <tr class="text-center">
                        <th class="col-1">No</th>
                        <th class="col-2">Nama Siswa</th>
                        <th class="col-1">NIS</th>
                        <th class="col-1">Keterangan</th>
                        <th class="col-2">Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $student->student_name }}</td>
                            <td>{{ $student->student_number }}</td>
                            <input type="hidden" name="student_id[]" value="{{ $student->student_id }}">
                            <td>
                                <select name="keterangan[]" id="student_id" class="form-select">
                                    <option value="H">Hadir</option>
                                    <option value="A">Alpha</option>
                                    <option value="S">Sakit</option>
                                    <option value="I">Ijin</option>
                                    <option value="T">Terlambat</option>
                                    <option value="N">Non-Shift PKL</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="alasan[]"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>
        </div>
    </form>
    <div class="modal fade" id="tambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form action="{{ route('presensi1.store') }}" method="post">
                @csrf
                @method('POST');
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Tambah Presensi 1 siswa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="">Nama Siswa</label>
                            <select name="student_id" id="nama" class="form-select">
                                @foreach ($students as $student)
                                    <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                aria-describedby="helpId" />
                            <br>
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select name="keterangan" id="keterangan" class="form-select">
                                <option value="H">Hadir</option>
                                <option value="S">Sakit</option>
                                <option value="I">Ijin</option>
                                <option value="A">Alpha</option>
                                <option value="T">Terlambat</option>
                                <option value="N">Non-Shift</option>
                            </select>
                            <br>
                            <label for="alasan" class="form-label">Alasan</label>
                            <input name="alasan" id="alasan" type="text" class="form-control" placeholder="Isikan alasan siswa (tidak wajib)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
