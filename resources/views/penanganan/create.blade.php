@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">{{ $title }}</h2>
            </div>
            <div class="col-md-6 text-end">
                

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
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <label for="siswa">Nama Siswa</label>
                    <select name="siswa" class="form-select" id="siswa">
                        <option selected>--Pilih Nama Siswa--</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <label for="siswa">Pelanggaran</label>
                    <select name="pelanggaran" class="form-select" id="pelanggaran" multiple>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <label for="tindaklanjut">Tindak Lanjut</label>
                    <select name="tindaklanjut" class="form-select" id="tindaklanjut">
                        <option selected>--Tindak Lanjut--</option>
                        <option value="TG">Teguran</option>
                        <option value="PO">Pemanggilan orang tua</option>
                        <option value="HV">Home visit</option>
                    </select>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" id="tanggal">
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <label for="tanggal">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5"></textarea>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="form-group mb-2 col-10">
                    <button class="btn btn-primary" id="btn-submit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#siswa").select2({
                theme: 'bootstrap-5',
                placeholder: '--- Ketik Nama Siswa untuk mencari ---',
                minimumInputLength: 3,
                width: '100%',
                ajax: {
                    url: "{{ route('siswas.getSiswas') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            _token: CSRF_TOKEN,
                            cari: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });
            $('#siswa').change(function() {
                var studentId = $(this).val();

                if (studentId) {
                    $.ajax({
                        url: '/penanganan/getPelanggaran/' +
                        studentId, // Route that handles the AJAX request
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            populateSelect(response);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });

                    function populateSelect(data) {
                        var select = $('#pelanggaran');
                        data.forEach(function(item) {
                            var option = $('<option></option>')
                                .val(item.id)
                                .text(item.pelanggaran + ' - ' + item.tanggal);
                            select.append(option);
                        });
                    }
                } else {
                    $('#pelanggaran').empty();
                    $('#pelanggaran').append('<option value="">Select Pelanggaran</option>');
                }
            });
        });
    </script>
@endpush
