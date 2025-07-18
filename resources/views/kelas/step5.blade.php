@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h2 class="mb-4 h5">{{ __('Daftar Kelas') }}</h2>
    </div>
    <div class="row mt-3">
        <div class="col-6">

        </div>
        <div class="col-6 text-end mr-3">
            {{--
            @can('kelas-create')
                <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Wali
                    Kelas</a>
            @endcan
            --}}
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
        <x-step-progress :current="5" />

        <h3>Step 5: Hasil Kenaikan Kelas</h3>

        <p><strong>Dari:</strong> {{ $classLama->class_name }} ({{ $classLama->year_id }})</p>
        <p><strong>Ke:</strong> {{ $classBaru->class_name }} ({{ $classBaru->year_id }})</p>

        <table class="table table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas Lama</th>
                    <th>Kelas Baru</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $classLama->class_name }}</td>
                        <td>{{ $classBaru->class_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('kelas.step1') }}" class="btn btn-primary mt-3">🔁 Mulai Lagi</a>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
@endpush

@push('js-header')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endpush
