@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Isi Presensi Siswa</h2>
            </div>
        </div>
    </div>
        <div class="card card-body border-0 shadow">
            <table class="table table-bordered">
                <tr>
                    <td>
                        Nama lengkap
                    </td>
                    <td>
                        {{ $siswa->student_name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Kelas
                    </td>
                    <td>
                        {{ $siswa->kelas->class_name }}
                    </td>
                </tr>
                <tr>
                    <td>
                        NIS
                    </td>
                    <td>
                        {{ $siswa->student_number }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Alamat
                    </td>
                    <td>
                        {{ $siswa->student_address }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Jenis Kelamin
                    </td>
                    <td>
                        {{ $siswa->student_gender }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Tempat Tanggal Lahir
                    </td>
                    <td>
                        {{ $siswa->student_pob }}, {{ $siswa->student_dob }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Nomor Telp
                    </td>
                    <td>
                        {{ $siswa->student_phone ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>
@endsection
