@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">Pelanggaran Siswa</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input
                    Pelanggaran</a>
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
        @php
            $status = $status ?? 'awal';
        @endphp

        <form action="{{ route('pelanggaran.cari') }}" method="POST">
            <div class="row mb-3">
                @csrf
                <div class="col-9 col-md-6 mr-0 pr-0">
                    <select name="cari" class="form-select" id="siswaSelect" placeholder="Pilih Nama Siswa">
                        <option selected>-- Pilih siswa --</option>
                    </select>
                </div>
                <div class="col-3 col-md-3 text-start ml-0 pl-0">
                    <button type="submit" class="btn btn-primary"> Cari</button>
                </div>
            </div>
        </form>

        <div class="row mb-3">
            <div class="col-md-6 col-12 border-1 shadow mr-2 mt-3">
                @if ($status == 'awal')
                <p> </p>
                @else
                    <h2 class="mb-4 h5 ml-3">Detail Identitas Siswa</h2>
                    <table class="table table-stripped table-responsive">
                        <tr>
                            <td>NIS</td>
                            <td>{{ $detailSiswa->student_number }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>{{ $detailSiswa->student_name }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>{{ $detailSiswa->student_address }}</td>
                        </tr>
                        <tr>
                            <td>TTL</td>
                            <td>{{ $detailSiswa->student_pob }}, {{ $detailSiswa->student_dob }}</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>{{ $detailSiswa->kelas->class_name }}</td>
                        </tr>
                    </table>
                @endif
            </div>
            <div class="col-md-6 col-12 border-1 shadow ml-2 mt-3">
                @if ($status == 'awal')
                <p> </p>
                @else
                    <h2 class="mb-4 h5 ml-3">Rekap Pelanggaran</h2>
                    <table class="table table-stripped table-responsive">
                        <tr>
                            <td>Alpha</td>
                            <td>{{ $detailSiswa->presensis->where('keterangan', 'A')->count() }}</td>
                        </tr>
                        <tr>
                            <td>Total Poin</td>
                            <td>{{ $detailSiswa->pelanggarans->sum('poin') }}</td>
                        </tr>
                    </table>
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 shadow p-2">
                <h2 class="mb-4 h5 ml-3">Daftar Pelanggaran</h2>
                <table class="table table-stripped">
                    <thead>
                        <th>No</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Deskripsi</th>
                        <th>Tindak lanjut</th>
                    </thead>
                    <tbody>
                        @if ($status == 'awal')
                            <tr>
                                <td colspan="5">Belum ada data, silakan pilih siswa</td>
                            </tr>
                        @else
                            @foreach ($siswas as $tgl => $pelanggarans)
                                <tr>
                                    <td colspan="5" class="bg-warning">Tanggal : {{ $tgl }}</td>
                                </tr>
                                @foreach ($pelanggarans as $pelanggaran)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pelanggaran->jenisPelanggaran->nama }}</td>
                                        <td>{{ $pelanggaran->jenisPelanggaran->poin }}</td>
                                        <td>{{ $pelanggaran->deskripsi }}</td>
                                        <td>{{ $pelanggaran->tindaklanjut }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .input-group>.select2-container--bootstrap-5 {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap-5 .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
        }
    </style>
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
