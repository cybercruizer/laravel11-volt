@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">{{$judul}} {{$tgl}}</h2>
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
                    <th>Nama</th>
                    <th>Kelas</th>
                </thead>
                <tbody>
                    @foreach ($data as $s)
                        <td>{{$loop->iteration}}</td>
                        <td>{{$s->siswa->student_name}}</td>
                        <td>{{$s->siswa->kelas->class_name}}</td>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
@endsection
