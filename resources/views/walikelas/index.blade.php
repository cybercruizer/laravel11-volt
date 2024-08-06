@extends('layouts.app')

@section('content')
        <div class="card-header">
            <h2 class="mb-4 h5">{{ __('Daftar Wali Kelas') }}</h2>
        </div>
        <div class="row mt-3">
            <div class="col-6">

            </div>
            <div class="col-6 text-end mr-3">
                @can('walikelas-create')
                    <a href="{{ route('walikelas.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Wali Kelas</a>
                @endcan
               
            </div>
        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
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
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        @can('walikelas-create')
                            <th>Action</th>
                        @endcan
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelas as $data)
                        <tr>
                            <td>{{ $data->class_name }}</td>
                            <td>{{ $guru->where('id', $data->user_id)->first()->name ?? '' }} </td>
                            @can('walikelas-create')
                            <td>
                                <a href="{{ route('walikelas.edit', $data->class_id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('walikelas.destroy', $data->class_id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
