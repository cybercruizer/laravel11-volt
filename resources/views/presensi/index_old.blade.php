@extends('layouts.app')

@section('content')
        <div class="card-header">
            <h2 class="mb-4 h5">{{ __('Daftar Siswa') }}</h2>
        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendance_data as $student_id => $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data['name'] }}</td>
                                @foreach ($data['attendances'] as $attendance)
                                    <td><span>{{ $attendance['date'] }}</span><br></td>
                                    <td><span>{{ $attendance['status'] }}</span><br></td>
                                @endforeach
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
@endsection

