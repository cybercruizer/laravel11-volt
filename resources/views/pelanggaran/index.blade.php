@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
            </div>
            <div class="col-md-6 text-end">
                @can('pelanggaran-create')
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input Pelanggaran</a>
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

        <div class="row">
            <div class="col-12">
                <table class="table table-stripped">
                    <thead>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Poin</th>
                        <th>Deskripsi</th>
                        <th>Tindak Lanjut</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @forelse ($pelanggaran as $day => $items)
                            <tr>
                                <td colspan="8" class="bg-warning"><strong>{{ $day }}</strong> </td>
                            </tr>
                            
                            @forelse ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->student_name }}</td>
                                    <td>{{ $item->siswa->kelas->class_name }}</td>
                                    <td>{{ $item->jenisPelanggaran->nama }}</td>
                                    <td>{{ $item->jenisPelanggaran->poin }}</td>
                                    <td class="text-wrap">{{ $item->deskripsi }}</td>
                                    <td class="text-wrap">{{ $item->tindaklanjut }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
