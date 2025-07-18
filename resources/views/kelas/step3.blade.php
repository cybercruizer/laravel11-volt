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
        <x-step-progress :current="3" />

        <h3>Step 3: Pilih Kelas Baru</h3>

        <form method="POST" action="{{ route('kelas.step3') }}">
            @csrf

            <div class="mb-3">
                <label for="class_baru_id" class="form-label">Kelas Baru</label>
                <select name="class_baru_id" id="class_baru_id" class="form-select" required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->class_id }}">{{ $class->class_name }} (Tahun: {{ $class->tahunajaran->year_code }})</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('kelas.step2') }}" class="btn btn-secondary">← Kembali</a>
                <button type="submit" class="btn btn-primary">Lanjut</button>
            </div>
        </form>
    </div>
    @endsection

    @push('styles')
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
    @endpush

    @push('js-header')
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endpush
