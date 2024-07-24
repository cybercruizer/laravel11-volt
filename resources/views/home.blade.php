@extends('layouts.app2')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <div class="row">
            <p class="h4">Dashboard <span class="text-muted text-sm"> / {{date('Y-m-d')}}</span></p>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 col-lg-8 mb-4">
            <div class="card bg-yellow-100 border-0 shadow">
                <div class="card-body p-2">
                    <h5 class="h6 mb-0">{{ $chart1->options['chart_title'] }}</h5>
                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div class="col-12 col-lg-12 mb-4">
                <h5 class="h5">Hari ini:</h5>
            </div>
            <hr class="bg-danger border-2 border-top border-danger" />
            <div class="col-12 col-lg-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div
                                    class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0 shadow bg-warning text-white">
                                    <i class="fa fa-running fa-2x"></i>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5"> Siswa Alpha <a href="/alpha/{{date('Y-m-d')}}" class="text-sm text-danger"><i class="fa fa-info-circle"></i></a></h2>
                                    <h3 class="mb-1">{{ $alpha ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0"> Siswa Alpha <a href="/alpha/{{date('Y-m-d')}}" class="text-sm text-danger"><i class="fa fa-info-circle"></i></a></h2>
                                    <h3 class="fw-extrabold mb-2">{{ $alpha ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12 mb-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div
                                    class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0 shadow bg-danger text-white">
                                    <i class="fa fa-user-clock fa-2x"></i>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5"> Siswa Terlambat <a href="/terlambat/{{date('Y-m-d')}}" class="text-sm text-success"><i class="fa fa-info-circle"></i></a></h2>
                                    <h3 class="mb-1">{{ $terlambat ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0"> Siswa Terlambat <a href="/terlambat/{{date('Y-m-d')}}" class="text-sm text-success"><i class="fa fa-info-circle"></i></a></h2>
                                    <h3 class="fw-extrabold mb-2">{{ $terlambat ?? 0 }} </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12 col-lg-12">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="row d-block d-xl-flex align-items-center">
                            <div
                                class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0 shadow">
                                    <i class="fa fa-user-edit fa-2x"></i>
                                </div>
                                <div class="d-sm-none">
                                    <h2 class="fw-extrabold h5"> Belum Presensi</h2>
                                    <h3 class="mb-1">{{ $belum ?? 0 }}</h3>
                                </div>
                            </div>
                            <div class="col-12 col-xl-7 px-xl-0">
                                <div class="d-none d-sm-block">
                                    <h2 class="h6 text-gray-400 mb-0"> Belum Presensi</h2>
                                    <h3 class="fw-extrabold mb-2">{{ $belum ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row mb-2">
        {{-- Nominasi --}}
        <div class="col-12 col-md-6 mt-1">
            <div class="card border-0 shadow mb-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Nominasi</h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-aplha-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-alpha" type="button" role="tab" aria-controls="nav-alpha"
                                aria-selected="true">Alpha</button>
                            <button class="nav-link" id="nav-terlambat-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-terlambat" type="button" role="tab" aria-controls="nav-terlambat"
                                aria-selected="false">Terlambat</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-alpha" role="tabpanel"
                            aria-labelledby="nav-alpha-tab">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-bottom" scope="col">No</th>
                                            <th class="border-bottom" scope="col">Nama</th>
                                            <th class="border-bottom" scope="col">Kelas</th>
                                            <th class="border-bottom" scope="col">Jumlah Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nom_alphas as $al)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $al->siswa->student_name }}</td>
                                                <td>{{ $al->siswa->kelas->class_name }}</td>
                                                <td>{{ $al->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-terlambat" role="tabpanel"
                            aria-labelledby="nav-terlambat-tab">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="border-bottom" scope="col">No</th>
                                            <th class="border-bottom" scope="col">Nama</th>
                                            <th class="border-bottom" scope="col">Kelas</th>
                                            <th class="border-bottom" scope="col">Jumlah<br>Terlambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nom_terlambat as $al)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $al->siswa->student_name }}</td>
                                                <td>{{ $al->siswa->kelas->class_name }}</td>
                                                <td>{{ $al->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Nominasi --}}
        {{-- Pengumuman --}}
        <div class="col-12 col-md-6 mt-1">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Pengumuman</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($woro2 as $item)
                        <div class="row">
                            <div class="col-1">
                                {{ $loop->iteration }}
                            </div>
                            <div class="col-11">
                                <strong class="text-uppercase">{{ $item->judul }}</strong> <br>
                                <span class="badge bg-warning text-primary"><a href="{{ route('woroworo.show', $item->id) }}" role="button">Baca Lengkap ...</a></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-11">
                               <p class="text-muted" style="font-size: 0.8em">{{$item->created_at->format('Y-m-d')}} oleh : {{$item->user->name}} | Kategori : <span class="badge bg-success text-white">{{$item->kategori}}</span></p>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
                <div class="card-footer py-4">
                    <a href="{{ route('woroworo.index') }}" class="btn btn-primary btn-sm">Lihat Semua Pengumuman</a>
                </div>
            </div>
        </div>
        {{-- End Pengumuman --}}
    </div>
    {!! $chart1->renderChartJsLibrary() !!}
    {!! $chart1->renderJs() !!}
@endsection
