@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Input Pelanggaran Siswa</h2>
            </div>
        </div>
    </div>
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
        <form action="{{ route('pelanggaran.store') }}" method="post">
            @csrf
            @method('POST')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="siswa_id">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id" class="form-select select2">
                            @foreach ($siswas as $s)
                                <option value="{{ $s->student_number }}">{{$s->student_number}}-{{ $s->student_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="siswa_id">Jenis Pelanggaran</label>
                        <select name="siswa_id" id="siswa_id" class="form-select select2">
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $s->student_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>
        </form>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
