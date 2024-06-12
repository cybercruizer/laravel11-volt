@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <h2 class="mb-4 h5">{{ __('Daftar Siswa') }}</h2>

            <p class="text-info mb-0">Daftar siswa aktif</p>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="border-gray-200">{{ __('NIS') }}</th>
                        <th class="border-gray-200">{{ __('Nama') }}</th>
                        <th class="border-gray-200">{{ __('Kelas') }}</th>
                        <th class="border-gray-200">{{ __('email') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswas as $siswa)
                        <tr>
                            <td><span class="fw-normal">{{ $siswa->student_number }}</span></td>
                            <td><span class="fw-normal">{{ $siswa->student_name }}</span></td>
                            <td><span class="fw-normal">{{ $siswa->kelas->class_name}}</span></td>
                            <td><span class="fw-normal">{{ $siswa->student_email }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div
                class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
                {{ $siswas->links() }}
            </div>
        </div>
    </div>
@endsection
