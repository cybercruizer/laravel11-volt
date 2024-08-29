@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 h5 ml-3">Ubah Pengumuman</h2>
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

        <form action="{{ route('woroworo.update', $woro2->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group mb-3">
                <label for="judul">Judul Pengumuman</label>
                <input type="text" class="form-control" name="judul" id="judul" placeholder="Judul Pengumuman"
                    value="{{ $woro2->judul }}">
            </div>

            <div class="row">
                <div class="form-group col-3 mb-3">
                    <label for="kategori">Kategori</label>
                    <select class="form-select" name="kategori" id="kategori">
                        <option value="umum" {{ $woro2->kategori == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="kurikulum" {{ $woro2->kategori == 'kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                        <option value="kesiswaan" {{ $woro2->kategori == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
                        <option value="keuangan" {{ $woro2->kategori == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="walikelas" {{ $woro2->kategori == 'walikelas' ? 'selected' : '' }}>Khusus Wali Kelas</option>
                    </select>
                </div>
                <div class="form-group col-3 mb-3">
                    <label for="status">Status</label>
                    <select class="form-select" name="status" id="status">
                        <option value="aktif" {{ $woro2->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $woro2->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="konten">Konten</label>
                <textarea class="form-control" name="konten" id="konten" rows="3">{!! $woro2->konten !!}</textarea>
            </div>
            <div class="row">
                <div class="col-6 form-group mb-3">
                    <label for="gambar" class="form-label">Pilih file lampiran</label>
                    <input
                        type="file"
                        class="form-control"
                        name="gambar"
                        id="gambar"
                        placeholder="{{ $woro2->gambar ?? 'Pilih gambar lampiran' }}"
                        aria-describedby="fileHelpId"
                        value="{{ $woro2->gambar }}"
                    />
                    <div id="fileHelpId" class="form-text">ekstensi: png,jpg,jpeg,webp | max : 2 MB</div>
                </div>
            </div>
            <div class="text-center mt-3"><button type="submit" class="btn btn-success btn-lg">Simpan</button></div>
        </form>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('ckeditor4-custom/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('konten');
    </script>
@endpush
