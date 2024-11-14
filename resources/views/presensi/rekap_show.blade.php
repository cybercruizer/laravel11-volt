@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">{{$title}} {{ $dari }} sampai {{ $sampai }}</h2>
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
        <form action="{{ route('presensi.rekap.show') }}" method="post">
            @csrf
            @method('POST')
            <div class="row d-print-none">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="dari" class="form-label">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control" value="{{ $dari}}">
                    </div>
                    
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="sampai" class="form-label">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control" value="{{ $sampai}}">
                    </div>
                </div>
                @role('Admin|Bk|Kurikulum|Kapro')
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select name="kelas" id="kelas" class="form-select">
                                <option value="0">-- Semua --</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->class_id }}">{{ $k->class_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endrole
                <div class="col-md-3 mb-3 mt-auto">
                    <button type="submit" class="btn btn-info">Tampilkan</button>
                </div>

            </div>
        </form>
        <div class="table-responsive row mt-2"></div>
            <table class="table table-bordered table-striped table-responsive mb-0">
                <thead>
                    <tr class="text-center">
                        <th class="col-1">No</th>
                        <th class="col-3">Nama Siswa</th>
                        <th class="col-1">NIS</th>
                        <th class="col-1">S</th>
                        <th class="col-1">I</th>
                        <th class="col-1">A</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->student_name }}</td>
                        <td>{{ $item->student_number }}</td>
                        <td>{{ $item->totalS }}</td>
                        <td>{{ $item->totalI }}</td>
                        <td>{{ $item->totalA }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

@endsection
