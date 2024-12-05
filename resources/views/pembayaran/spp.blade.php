@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h2 class="mb-4 h5 ml-3">{{$title}}</h2>
            </div>
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

            @forelse ($pembayaran as $s => $val)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s }}</td>
                    <td>{{ $val[0]->nama }}</td>
                    @forelse($val as $bayar)
                        @if($loop->iteration==$bayar->tahap)
                            <td><small>{{ $bayar->jumlah }}</small></td>
                        @endif
                    @empty
                        <td colspan="12">Kosong</td>
                    @endforelse
                    
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center"><strong>~ Tidak ada data ~</strong></td>
                </tr>
            @endforelse
        </table>
    </div>
@endsection
