@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h2 class="mb-4 h5 ml-3">{{ $title }}</h2>
            </div>
            <div class="col-md-6 text-end">
                @can('pelanggaran-create')
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Input
                        Pelanggaran</a>
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
                <div class="accordion" id="accordionExample">
                    @forelse ($pelanggaran as $day => $items)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $day }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $day }}" aria-expanded="true"
                                    aria-controls="collapse{{ $day }}">
                                    {{ $day }}
                                </button>
                            </h2>
                            <div id="collapse{{ $day }}" class="accordion-collapse collapse {{ $loop->last ? 'show' : '' }}"
                                aria-labelledby="heading{{ $day }}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <table class="table table-stripped">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jenis Pelanggaran</th>
                                            <th>Poin</th>
                                            <th>Deskripsi</th>
                                            <th>Tindak Lanjut</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody>
                                            @forelse ($items as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->siswa->student_name }}</td>
                                                    <td>{{ $item->siswa->kelas->class_name }}</td>
                                                    <td>{{ $item->jenisPelanggaran->nama }}</td>
                                                    <td>{{ $item->jenisPelanggaran->poin }}</td>
                                                    <td class="text-wrap">{{ $item->deskripsi }}</td>
                                                    <td class="text-wrap">{{ $item->tindaklanjut }}</td>
                                                    <td>

                                                        <form action="{{ route('pelanggaran.destroy', $item->id) }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('pelanggaran.edit', $item->id) }}"
                                                                    class='btn btn-primary btn-sm'><i
                                                                        class="fa fa-edit"></i></a>
                                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                                        class="fa fa-trash"></i></button>
                                                            </div>
                                                        </form>

                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
