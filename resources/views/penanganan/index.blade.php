@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">{{ $title }}</h2>
            </div>
            <div class="col-md-6 text-end">
                @can('penanganan-create')
                    <a href="{{ route('penanganan.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input
                        Penanganan siswa</a>
                @endcan

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

        <div class="row">
            <div class="col-12">

            </div>
        </div>
    </div>
@endsection