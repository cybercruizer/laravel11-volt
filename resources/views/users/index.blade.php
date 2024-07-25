@extends('layouts.app')

@section('content')
    <div class="card-header">
        <div class="row margin-tb">
            <div class="col-md-6 pull-left">
                <h5>Manajemen User</h5>
            </div>
            <div class="col-md-6 text-end">
                <a class="btn btn-success btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Buat User </a>
            </div>
        </div>
    </div>

    @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
    @endsession
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($data as $key => $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                                <label class="badge bg-success">
                                    {{ $v }}
                                </label>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}"><i
                                class="fa fa-solid fa-eye"></i></a>
                        <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}"><i
                                class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('users.destroy', $user->id) }}" style="display:inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="card-footer">
        {!! $data->links('pagination::bootstrap-5') !!}
    </div>
@endsection
