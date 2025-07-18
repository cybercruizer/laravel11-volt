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
        <x-step-progress :current="2" />

        <h3>Step 2: Pilih Siswa yang Akan Dinaikkan Kelas</h3>

        <form method="POST" action="{{ route('kelas.step2') }}">
            @csrf
            <div class="mb-3"></div>
                <input type="checkbox" id="select-all" class="form-check-input">
                <label for="select-all" class="form-check-label">Pilih Semua</label>
                <hr>

                @foreach ($students as $student)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->student_id }}"
                            id="siswa-{{ $student->student_id }}">
                        <label class="form-check-label" for="siswa-{{ $student->student_id }}">
                            {{ $student->student_name }}
                        </label>
                    </div>
                @endforeach
                <hr>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('kelas.step1') }}" class="btn btn-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-success">Lanjut</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('input[name="students[]"]');
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => cb.checked = selectAll.checked);
            });
        });
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
@endpush

@push('js-header')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
@endpush
