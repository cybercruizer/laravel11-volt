@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h5 class="mb-4 h5">{{ $title }}</h5>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <form action="{{ route('presensi.admin') }}" method="GET" class="d-print-none">
            <div class="col-md-6 mb-3">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <select class="form-select" name="bulan">
                        <option value="01" {{ $bulan == '01' ? 'selected' : '' }}>Januari</option>
                        <option value="02" {{ $bulan == '02' ? 'selected' : '' }}>Februari</option>
                        <option value="03" {{ $bulan == '03' ? 'selected' : '' }}>Maret</option>
                        <option value="04" {{ $bulan == '04' ? 'selected' : '' }}>April</option>
                        <option value="05" {{ $bulan == '05' ? 'selected' : '' }}>Mei</option>
                        <option value="06" {{ $bulan == '06' ? 'selected' : '' }}>Juni</option>
                        <option value="07" {{ $bulan == '07' ? 'selected' : '' }}>Juli</option>
                        <option value="08" {{ $bulan == '08' ? 'selected' : '' }}>Agustus</option>
                        <option value="09" {{ $bulan == '09' ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                        <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Desember</option>
                    </select>
                    <select name="tahun" id="tahun" class="form-select">
                        <option value="2023" {{ $tahun == '2023' ? 'selected' : '' }}>2023</option>
                        <option value="2024" {{ $tahun == '2024' ? 'selected' : '' }}>2024</option>
                        <option value="2025" {{ $tahun == '2025' ? 'selected' : '' }}>2025</option>
                    </select>
                    <button class="btn btn-primary" type="submit" id="button-addon2">Tampilkan</button>
                </div>
            </div>
        </form>

        <br>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <table class="table table-bordered">
            <thead>
                <tr class="bg-primary text-white">
                    <th class="text-center" rowspan="2">No</th>
                    <th class="text-center" rowspan="2">Kelas</th>
                    <th class="text-center" colspan="{{ $jumlahHari }}">Tanggal</th>
                </tr>
                <tr>
                    @for ($day = 1; $day <= $jumlahHari; $day++)
                            @php
                                //convert $day to carbon format
                                $hr = \Carbon\Carbon::create($tahun, $bulan, $day, 0, 0, 0);
                                //$day = $day->format('d');
                                //$isSunday $day->dayOfWeek === Carbon::SUNDAY;
                            @endphp
                            @if ($hr->dayOfWeek===\Carbon\Carbon::SUNDAY || $hr->dayOfWeek===\Carbon\Carbon::SATURDAY)
                                <th class="bg-danger text-white" data-bs-toggle="tooltip" data-bs-placement="top" title="Ahad">{{ $hr->format('d') }}</th>
                            @else
                                <th class="bg-light">{{ $hr->format('d') }}</th>
                            @endif
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>

                @forelse ($kelas as $kel)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kel->class_name }}</td>

                        @for ($day = 1; $day <= $jumlahHari; $day++)
                            <td>
                                @if ($kelasdata[$kel->class_id][$day] == "v")
                                    <i class="fa fa-check-circle text-success"></i>
                                @else
                                    <i class="fa fa-times-circle text-danger"></i>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td>Data tidak ditemukan</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
@endsection