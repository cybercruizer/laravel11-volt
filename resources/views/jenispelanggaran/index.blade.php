@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
            </div>
            <div class="col-6 text-end">
                @can('jenispelanggaran-create')
                <!-- Modal trigger button -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah">
                    Tambah Jenis Pelanggaran
                </button>
                @endcan
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

        <table class="table table-bordered table-striped table-responsive mb-0">
            <thead>
                <th>No</th>
                <th>Jenis Pelanggaran</th>
                <th>Deskripsi</th>
                <th>Poin</th>
                @can('jenispelanggaran-edit')
                <th>Aksi</th>
                @endcan

            </thead>
            @foreach ($jenis as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->deskripsi }}</td>
                    <td>{{ $s->poin }}</td>
                    @can('jenispelanggaran-edit')
                    <td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('jenispelanggaran.destroy', $s->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('jenispelanggaran.edit', $s->id) }}" class='btn btn-primary btn-sm'><i
                                        class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                    @endcan
                </tr>
            @endforeach
        </table>
    </div>
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="tambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form action="{{ route('jenispelanggaran.store') }}" method="post">
                @csrf
                @method('POST');
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">
                            Tambah Pelanggaran
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="nama" class="">Nama Pelanggaran</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                aria-describedby="helpId" placeholder="Tulis jenis pelanggaran" /><br>
                            <label for="desc" class="form-label">Deskripsi Pelanggaran</label>
                            <input type="text" class="form-control" name="deskripsi" id="desc"
                                aria-describedby="helpId" placeholder="Tulis deskripsi pelanggaran" /><br>
                            <label for="poin" class="form-label">Poin Pelanggaran</label>
                            <input type="text" class="form-control" name="poin" id="poin"
                                aria-describedby="helpId" placeholder="Tulis poin pelanggaran" /><br>
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

    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options,
        );
    </script>
@endsection
