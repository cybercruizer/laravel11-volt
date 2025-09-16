@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
            </div>
            @role('Admin||Keuangan||Kapro')
                <form method="post" action="{{route('pembayaran.lain')}}">
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
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    @foreach($tagihan as $bill)
                        <th>{{ Illuminate\Support\Str::limit($bill->nama,12) }}</th>
                    @endforeach
                    <th>Terbayar</th>
                    {{-- <th>Persentase</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse($nis as $student)
                    <tr>
                        <td>{{ $student->student_number }}</td>
                        <td>
                            {{ $student->student_name }}
                        </td>
                        
                        @php $studentTotal = 0; @endphp
                        @foreach($tagihan as $bill)
                            @php 
                                $amount = $data[$student->student_number][$bill->kode] ?? 0;
                                $studentTotal += $amount;
                            @endphp
                            <td>{{ number_format($amount, 0, ',', '.') }}</td>
                        @endforeach
                        
                        <td>{{ number_format($studentTotal, 0, ',', '.') }}
                            {{-- /{{number_format($bill->total_tagihan, 0, ',', '.') }} --}}
                        </td>
                            {{-- @php $persentase = $studentTotal/$bill->total_tagihan * 100; @endphp
                        <td>{{number_format($persentase, 0, ',', '.')}} %</td> --}}
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($tagihan) + 2 }}" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
            {{--<tfoot>
                <tr>
                    <td colspan="2"><strong>Total Keseluruhan</strong></td>
                    @php $overallTotal = 0; @endphp
                    @foreach($tagihan as $bill)
                        @php 
                            $billTotal = collect($data)->sum(function($student) use ($bill) {
                                return $student[$bill->kode] ?? 0;
                            });
                            $overallTotal += $billTotal;
                        @endphp
                        <td><strong>{{ number_format($billTotal, 0, ',', '.') }}</strong></td>
                    @endforeach
                    <td><strong>{{ number_format($overallTotal, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>--}}       
        </table>
    </div>
@endsection
