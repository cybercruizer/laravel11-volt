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
        <x-step-progress :current="4" />

        <h3>Step 4: Konfirmasi Perpindahan Kelas</h3>

        <p><strong>Kelas Lama:</strong> {{ $classLama->class_name }} ({{ $classLama->tahunajaran->year_name }})</p>
        <p><strong>Kelas Baru:</strong> {{ $classBaru->class_name }} ({{ $classBaru->tahunajaran->year_name }})</p>

        <h5>Daftar Siswa:</h5>
        <ul class="list-group mb-4">
            @foreach ($students as $student)
                <li class="list-group-item">{{ $student->student_name }}</li>
            @endforeach
        </ul>

        <form method="POST" action="{{ route('kelas.step4') }}">
            @csrf
            <div class="d-flex justify-content-between">
                <a href="{{ route('kelas.step3') }}" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-success">Konfirmasi & Proses</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
@endpush

@push('js-header')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endpush
