@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">Pelanggaran Siswa bulan {{ $month }}</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input Pelanggaran</a>
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
            <div class="col-12">
                <table class="table table-stripped">
                    <thead>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Poin</th>
                        <th>Deskripsi</th>
                        <th>Tindak Lanjut</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($pelanggaran as $day => $items)
                            <tr>
                                <td colspan="6" class="bg-warning"><strong>{{ $day }}</strong> </td>
                            </tr>
                            
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->student_name }}</td>
                                    <td>{{ $item->jenisPelanggaran->poin }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->tindaklanjut }}</td>
                                    <td>
                                        
                                            <form action="{{ route('pelanggaran.destroy', $item->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pelanggaran.edit', $item->id) }}" class='btn btn-primary btn-sm'><i
                                                        class="fa fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </form>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
