@extends('layouts.app')

@section('content')
    <div class="row mb-2">
        <div class="col-sm-6">
            <a href="{{ route('jenispelanggaran.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                Kembali</a>
        </div>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4 h5 ml-3">Edit Jenis Pelanggaran</h2>
                </div>
            </div>
        </div>

        <div class="card-body border-0 p-4">
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
            <form action="{{ route('jenispelanggaran.update', $jenis->id) }}" method="post" class="m-0">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Jenis Pelanggaran</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $jenis->nama }}" />
                    </div>
                    <div class="mb-3">
                        <label for="desk" class="form-label">Deskripsi Pelanggaran</label>
                        <input type="text" name="deskripsi" id="desk" class="form-control"
                            value="{{ $jenis->deskripsi }}" />
                    </div>
                    <div class="mb-3">
                        <label for="poin" class="form-label">Poin Pelanggaran</label>
                        <input type="text" name="poin" id="poin" class="form-control"
                            value="{{ $jenis->poin }}" />
                    </div>
                    <input type="hidden" name="id" value="{{ $jenis->id }}">

                    <div class="text-center mt-3">
                        <a href="{{ route('jenispelanggaran.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>

    @endsection
