@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h5 ml-3"><strong>{{$woro2->judul}}</strong></h2>
                <h6 class="h6">{{$woro2->created_at->format('Y-m-d')}}, Kategori : {{$woro2->kategori}}</h6>

            </div>
        </div>
    </div>

    <form action="{{ route('woroworo.update', $woro2->id) }}" method="POST">
        @csrf
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
            <p>{{$woro2->konten}}</p>
        </div>
    </form>
@endsection
