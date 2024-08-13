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
                        <th width="5%">No</th>
                        <th width="30%">Nama Siswa</th>
                        <th width="60%">Pelanggaran</th>
                        <th width="5%">Total Poin</th>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->student_name }}</td>
                                    <td><ul>
                                        @forelse ($s->pelanggarans as $p)
                                            <li>{{ $p->jenisPelanggaran->nama }}-{{ $p->jenisPelanggaran->poin }}</li>
                                        @empty
                                            -
                                        @endforelse
                                    </ul></td>
                                    <td>{{ $s->pelanggarans->sum('poin') }}</td>
{{--                                     <td>
                                        
                                           <form action="{{ route('pelanggaran.destroy', $s->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('pelanggaran.edit', $s->id) }}" class='btn btn-primary btn-sm'><i
                                                        class="fa fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </form> 
                                        
                                    </td> --}}
                                </tr>
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
