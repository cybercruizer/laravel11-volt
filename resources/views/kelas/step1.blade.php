@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h2 class="mb-4 h5">{{ __('Naikkan kelas') }}</h2>
    </div>
    <div class="row mt-3">
        <div class="col-6">

        </div>
        <div class="col-6 text-end mr-3">

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
        <x-step-progress :current="1" />

        <h3>Step 1: Pilih Kelas Lama</h3>

        <form method="POST" action="{{ route('kelas.step1') }}">
            @csrf

            <div class="mb-3">
                <label for="class_id" class="form-label">Kelas Lama</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->class_id }}">{{ $class->class_name }} (Tahun: {{ $class->tahunajaran->year_code }}) (Jml siswa: {{ $class->siswas->count() }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Lanjut</button>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
@endpush

@push('js-header')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endpush
