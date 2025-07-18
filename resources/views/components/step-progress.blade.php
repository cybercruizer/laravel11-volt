@props(['current'])

@php
    $steps = [
        1 => 'Pilih Kelas Lama',
        2 => 'Pilih Siswa',
        3 => 'Pilih Kelas Baru',
        4 => 'Konfirmasi',
        5 => 'Hasil'
    ];
    $percentage = ($current / count($steps)) * 100;
@endphp

<div class="mb-4">
    <p><strong>Langkah {{ $current }} dari {{ count($steps) }}:</strong> {{ $steps[$current] }}</p>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
