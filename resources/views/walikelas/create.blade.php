@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Pengaturan Wali Kelas</h2>
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
        <form action="{{ route('walikelas.store') }}" method="POST">
            @csrf
            <table class="table table-bordered table-striped table-responsive mb-0">
                @foreach ($kelas as $kel)
                    <tr>
                        <td>{{ $kel->class_name }}</td>
                        <td>
                            <select name="class_id[]" class="form-select" id="">
                                @foreach ($guru as $g)
                                    <option value="{{ $g->id }}"
                                        {{ $g->id == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>

        </form>
    </div>

@endsection
