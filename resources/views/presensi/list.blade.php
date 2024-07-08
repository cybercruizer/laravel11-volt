@extends('layouts.app')

@section('content')
        <div class="card-header">
            <h2 class="mb-4 h5">{{ __('Daftar Siswa') }}</h2>
        </div>
        <div class="card card-body border-0 shadow table-wrapper table-responsive">
            <a href="" class="btn btn-primary">Presensi siswa</a>
            <table class="table table-bordered">
                <thead>
                   <tr>
                      <th>Nama</th>
                      @foreach ($tanggals as $tanggal)
                          <th>{{ $tanggal }}</th>
                      @endforeach
                      <th>Ket</th>
                   </tr>
                </thead>
                <tbody>
                    @foreach ($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->student_name }}</td>
                        @foreach ($tanggals as $tanggal )
                            @php
                                $presensi= $siswa->presensis[$tanggal] ?? null;
                            @endphp
                            <td>
                                {{ $presensi->keterangan }}
                            </td>

                        @endforeach
                    </tr>
                    @endforeach

                </tbody>
             </table>
        </div>
@endsection

