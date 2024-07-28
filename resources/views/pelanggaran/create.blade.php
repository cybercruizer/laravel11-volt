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
                <div class="col-md-6 col-12 mb-2">
                    <div class="form-group mb-2 col-10">
                        <label for="siswa_id">Nama Siswa</label>
                        <select name="siswa" class="form-select" id="siswaSelect">
                            <option selected>--Pilih Nama Siswa--</option>
                        </select>
                    </div>
                    <div class="form-group mb-2 col-10">
                        <label for="pelanggaran_id">Jenis Pelanggaran</label>
                        <select name="pelanggaran" id="pelanggaran_id" class="form-select">
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2 col-10">
                        <label for="tanggal">Tanggal Pelanggaran</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                    </div>
                    <div class="form-group mb-2 col-10">
                        <label for="deskripsi">Deskripsi pelanggaran</label>
                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="5" class="form-control"></textarea>
                        
                    </div>
                    <div class="form-group mb-2 col-10">
                        <label for="tl">Tindak Lanjut</label>
                        <textarea name="tindaklanjut" id="tl" cols="30" rows="5" class="form-control"></textarea>
                    </div>

                </div>
                <div class="col-12 col-md-6">
                    <table class="table table-stripped table-bordered">
                        <h2 class="h6"><i class="fa fa-list"></i>  Daftar Jenis Pelanggaran</h2>
                        <thead>
                            <th>No</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Poin</th>
                        </thead>
                        <tbody>
                            @foreach ($jenis as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->poin }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-start mt-3 mb-3"><button type="submit" class="btn btn-success">Simpan</button></div>
        </form>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        // CSRF Token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {

            $("#siswaSelect").select2({
                theme: 'bootstrap-5',
                minimumInputLength: 3,
                width: '100%',
                ajax: {
                    url: "{{ route('siswas.getSiswas') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            cari: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });

        });
    </script>
@endpush
