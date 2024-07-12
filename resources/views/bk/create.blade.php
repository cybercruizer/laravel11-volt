@extends('layouts.app')
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Input Pelanggaran siswa</h2>
            </div>
        </div>
    </div>

    <form action="{{ route('pelanggaran.store') }}" method="POST">
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
            
            <div class="row">
                <div class="col-md-6"></div>
                    <div class="form-group">
                        <label for="nama">Nama Siswa</label>
                        <select name="siswa" id="siswa_id" class="form-select select2">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="form-group"></div>
                        <label for="pelanggaran_id">Pelanggaran</label>
                        <select name="pelanggaran_id" id="pelanggaran_id" class="form-select">
                            @foreach ($pelanggaran as $item)
                                <option value="{{ $item->id }}">{{ $item->pelanggaran }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col">
                    <div class="form-group"></div>
                        <label for="tanggal">Tanggal pelanggaran</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal"/>
                    </div>
                </div>
            </div>
            
            
            
            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>


        </div>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('select2/js/select2.full.min.js') }}"></script>
    <script>
        var path = "{{ route('siswa.search') }}";
   
        $('#siswa_id').select2
        ({
            placeholder: 'Pilih Siswa',
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
            }
        });
    </script>
@endpush