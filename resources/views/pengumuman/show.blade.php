@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h5 ml-3"><strong>{{ $woro2->judul }}</strong></h2>
                    <h6 class="h6">{{ $woro2->created_at->format('Y-m-d') }}, Kategori : {{ $woro2->kategori }}</h6>

                </div>
            </div>
        </div>
        <div class="card-body border-0 shadow">
            <p>{!! $woro2->konten !!}</p>
        </div>

        <div class="card-footer text-muted">
            <div class="row">
                <div class="col-md-12"></div>
                    <h6 class="h6">File lampiran</h6>
                    @if($woro2->gambar)
                        <a href="{{ asset($woro2->gambar) }}" target="_blank"><img src="{{ asset($woro2->gambar) }}" width="200px"></a>
                    @else
                        <span class="text-muted">Tidak ada lampiran</span>
                    @endif
                    <span class="text-muted">*klik gambar untuk memperbesar</span>
                </div>
            </div>
        </div>
        
    </div>
@endsection
