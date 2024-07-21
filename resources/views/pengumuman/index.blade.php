@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row">
            <div class="col-12 col-md-9">
                <h2 class="mb-4 h5 ml-3">Pengumuman</h2>
            </div>
            <div class="col-6 col-md-3 text-end">
                @can('pengumuman-create')
                    <a href="{{ route('woroworo.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Pengumuman</a>
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

            <table class="table table-bordered table-striped table-responsive mb-0">
                @foreach ($woro2 as $item)
                    <tr>
                        <td colspan="3">Tanggal : {{ $item->created_at->format('Y-m-d') }} , dibuat oleh : {{ $item->user->name }}, Kategori : {{ $item->kategori }}</td>
                    </tr>
                    <tr>
                        <td width="5%">
                            {{ $loop->iteration }}
                        </td>
                        <td width="85%">
                            <h5 class="h6"><strong>Judul: {{ $item->judul }}</strong></h5><hr>
                            {{ Str::limit(htmlspecialchars(trim(strip_tags($item->konten))),100) }}
                        </td>
                        <td width="10%" class="align-middle">
                                <form action="{{ route('woroworo.destroy', $item->id) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    
                                        <div class="btn-group">
                                            <a href="{{ route('woroworo.show', $item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            @can('pengumuman-edit')
                                            <a href="{{ route('woroworo.edit', $item->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus pengumuman dengan judul: {{$item->judul}} ?')" type="submit"><i class="fas fa-trash"></i></button>
                                            @endcan
                                        </div>
                                    
                                    
                                </form>
                                                    
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
@endsection