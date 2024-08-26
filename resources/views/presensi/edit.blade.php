@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Edit Presensi Siswa</h2>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Konten -->
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
        <form action="{{ route('presensi.edit', $tanggal) }}" method="GET">
            @csrf
            <div class="input-group md-3">
                <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                <input type="date" class="form-control" value="{{ $tanggal }}"
                    placeholder="{{ $tanggal }}" aria-label="Pilih Tanggal"
                    aria-describedby="button-addon2" name="tanggal">
                <button class="btn btn-primary" type="submit" id="button-addon2">Tampilkan</button>
            </div>
        </form>

        <br>
        <form method="POST" action="{{ route('presensi.update', $tanggal) }}" class="form-horizontal">
            @csrf
            @method('PUT')
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="kelas" value="{{ $kelas->class_id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Presensi</th>
                        <th>Keterangan</th>
                </thead>
                <tbody>
                    @forelse ($presensis as $presensi)
                        <tr>
                            <input type="hidden" name="siswa[{{ $presensi->student_id }}][id]"
                                value="{{ $presensi->student_id }}">
                            <td>{{ $loop->iteration }}.</td>
                            <td>{{ $presensi->siswa->student_name }}</td>
                            <td>
                                <SELECt name="siswa[{{ $presensi->student_id }}][keterangan]" class="form-select">
                                    <option value="H" {{ $presensi->keterangan === 'H' ? 'selected' : '' }}>
                                        Hadir</option>
                                    <option value="S" {{ $presensi->keterangan === 'S' ? 'selected' : '' }}>
                                        Sakit</option>
                                    <option value="I" {{ $presensi->keterangan === 'I' ? 'selected' : '' }}>
                                        Ijin</option>
                                    <option value="A" {{ $presensi->keterangan === 'A' ? 'selected' : '' }}>
                                        Alpha</option>
                                    <option value="T" {{ $presensi->keterangan === 'T' ? 'selected' : '' }}>
                                        Terlambat</option>
                                    <option value="N" {{ $presensi->keterangan === 'N' ? 'selected' : '' }}>
                                        Non-Shift PKL</option>
                                </SELECt>
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                    name="siswa[{{ $presensi->student_id }}][alasan]"
                                    value="{{ $presensi->alasan }}">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center"><strong>~ Presensi untuk tanggal ini tidak ditemukan ~</strong></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-primary">Kirim</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>
    
@endsection
