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

        <div class="row">
            <div class="col-12 col-md-6">

            </div>
            <div class="col-12 col-md-6">
                <table class="table table-stripped">
                    <h2 class="h6">Daftar Jenis Pelanggaran</h2>
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
    </div>
@endsection
