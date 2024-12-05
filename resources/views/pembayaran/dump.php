@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
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
                <th class="col-1">No</th>
                <th class="col-3">TP</th>
                <th class="col-2">Nama Tagihan</th>
                <th class="col-2">Kode</th>
                <th class="col-2">Bulanan</th>
                <th class="col-2">Tingkat</th>
        {{--<th class="col-2">Aksi</th>--}}

            </thead>
            @forelse ($jenis as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->tp }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->kode }}</td>
                    <td>{{ $s->bulanan }}</td>
                    <td>{{$s->kelas}}</td>
                    {{--<td>
                        <div class="btn-group" role="group">
                            <form action="{{ route('tagihan.destroy', $s->no) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <a href="{{ route('tagihan.edit', $s->no) }}" class='btn btn-primary btn-sm'><i
                                        class="fa fa-edit"></i></a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>--}}
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center"><strong>~ Tidak ada data ~</strong></td>
                </tr>
            @endforelse
        </table>
    </div>
    {{-- <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="tambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
        aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <form action="{{ route('tagihan.store') }}" method="post">
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
                            <label for="nama" class="">Nama Tagihan</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Tulis nama tagihan" /><br>

                            <label for="jenis" class="">Jenis Tagihan</label>
                            <select name="jenis" class="form-select" id="jenis">
                                <option value="">-- Pilih Jenis Tagihan --</option>
                                <option value="bulanan">Rutin Bulanan</option>
                                <option value="tahunan">Tahunan</option>
                            </select><br>

                            <label for="ta" class="">Tahun Ajaran</label>
                            <select name="ta" class="form-select" id="ta">
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                @foreach ($ta as $t)
                                    <option value="{{ $t->year_id }}">{{$t->year_name}}</option>
                                @endforeach
                                
                            </select><br>
        
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="text" class="form-control" name="nominal" id="nominal"
                                placeholder="Tulis nominal tagihan" /><br>

                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" id="keterangan"
                                placeholder="Tulis keterangan tagihan" /><br>
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
    </div> --}}

    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(
            document.getElementById("modalId"),
            options,
        );
    </script>
@endsection
