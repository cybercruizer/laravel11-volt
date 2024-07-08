@extends('layouts.app')

@section('content')
        <div class="card-header">
            <h2 class="mb-4 h5">{{ __('Daftar Wali Kelas') }}</h2>
        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Nama Guru</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($walikelas as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->kelas->class_name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('walikelas.edit', $data->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('walikelas.destroy', $data->id) }}" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
