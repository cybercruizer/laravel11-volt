@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row margin-tb">
            <div class="col-md-6 col-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
            </div>
            @role('Admin||Keuangan||Kapro')
                <form method="post" action="{{route('pembayaran.spp')}}">
                @csrf
                    <div class="col-md-4 col-4">
                        <div class="input-group">
                            <select name="class_id" id="class_id" class="form-select">
                                <option value="">--Pilih Kelas--</option>
                                @foreach ($kelas as $k )
                                    <option value="{{$k->class_id}}">{{$k->class_name}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </div>
                </form> 
            @endrole
        </div>
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
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        <table class="table table-bordered table-striped table-responsive mb-0">
            <thead>
                <tr>
                    <th class="col-1 text-center" rowspan="2">No</th>
                    <th class="col-1 text-center" rowspan="2">NIS</th>
                    <th class="col-2 text-center" rowspan="2">Nama</th>
                    <th colspan="12" class="text-center">Tahap</th>
                </tr>
                <tr>
                    @php
                        $bl=['JUL','AGS','SEP','OKT','NOV','DES','JAN','FEB','MAR','APR','MEI','JUN',]
                    @endphp
                    @foreach($bl as $b)
                        <th>{{$b}}</th>
                    @endforeach
                    
                </tr>
                
            </thead>

            @forelse ($siswa as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->student_number }}</td>
                    <td>{{ $s->student_name }}
                        @php
                            $pembayaranSiswa = $pembayaran[$s->student_number] ?? [];
                            $tahapBayar = collect($pembayaranSiswa)->keyBy('tahap');
                            $kategori = count($pembayaranSiswa) > 0 ? $pembayaranSiswa[0]->kategori ?? '' : '';
                        @endphp
                        <br><small style="color: red">{{ $kategori }}</small>
                    </td>
                    
                    @for ($i = 1; $i <= 12; $i++)
                        <td>
                            @if ($tahapBayar->has($i))
                                <small>{{ $tahapBayar[$i]->jumlah / 1000 }}</small>
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center"><strong>~ Tidak ada data ~</strong></td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
