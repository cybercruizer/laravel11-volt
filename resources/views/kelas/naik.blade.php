@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h2 class="mb-4 h5">{{ __('Daftar Kelas') }}</h2>
    </div>
    <div class="row mt-3">
        <div class="col-6">

        </div>
        <div class="col-6 text-end mr-3">
            {{--
            @can('kelas-create')
                <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Wali
                    Kelas</a>
            @endcan
            --}}
        </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
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
        <table class="table table-bordered table-striped mb-0">
            <thead>
                <tr>
                    <th class="col-1">No</th>
                    <th>Nama Kelas</th>
                    <th>Kode Kelas</th>
                    @can('kelas-create')
                        <th>Action</th>
                    @endcan

                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $data => $key)
                    <tr class="table-warning">
                        <td colspan="3">{{ $data }}</td>
                    </tr>
                    @foreach ($key as $key)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $key->class_name }}</td>
                            <td>{{ $key->class_code }}</td>
                            @can('kelas-edit')
                                <td>
                                    <button id="btn-edit" class="btn btn-warning" data-id="{{ $key->class_id }}" data-kode-kelas="{{ $key->class_code }}"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-delete" data-id="{{ $key->class_id }}"><i class="fas fa-trash"></i></button>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal structure -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">
                    <input type="hidden" id="kelas-id" name="kelas_id"></span>
                    <p>
                        <strong>Nama kelas:</strong> <br /> <input type="text" name="nama" id="nama-kelas"
                            class="form-control"></span>
                    </p>
                    <p>
                        <strong>Kode kelas:</strong> <br /> <input type="text" name="kode" id="kode-kelas"
                            class="form-control"></span>
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="user-update">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<script>
$(document).ready(function() {
    // Handle edit button click
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
    });
    $(document).on('click', '#btn-edit', function() {
        const tr = $(this).closest('tr');
        const classId = tr.data('id');
        const classCode = tr.data('kode-kelas');
        const className = tr.find('td:first').text();

        // Set values in modal
        $('#kelas-id').val(classId);
        $('#nama-kelas').val(className);
        $('#kode-kelas').val(className);

        // Show modal
        $('#userEditModal').modal('show');
    });

    // Handle update button click
    $('#user-update').click(function() {
        const classId = $('#kelas-id').val();
        const walikelasId = $('#walikelas-select').val();

        if (!walikelasId) {
            Toast.fire({
                icon: 'warning',
                title: 'Silakan pilih wali kelas'
            });
            return;
        }

        // Send update request
        $.ajax({
            url: `/kelas/${classId}`,
            type: 'PUT',
            data: {
                user_id: walikelasId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $('#user-update').prop('disabled', true).text('Memperbarui...');
            },
            success: function(response) {
                if (response.status === 'success') {
                    $('#userEditModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: `Wali Kelas ${response.details.className}`,
                        html: `Berhasil diupdate dari:<br>
                             <strong>${response.details.oldTeacher}</strong> ke 
                            <strong>${response.details.newTeacher}</strong>`
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.message || 'Terjadi kesalahan saat memperbarui wali kelas'
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Terjadi kesalahan saat memperbarui wali kelas';
                
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing error response:', e);
                }
                
                Toast.fire({
                    toast:'true',
                    icon: 'error',
                    title: errorMessage
                });
            },
            complete: function() {
                $('#user-update').prop('disabled', false).text('Update');
            }
        });
    });
});
</script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.min.css">
@endpush

@push('js-header')
    <script src="{{asset('vendor/sweetalert/sweetalert.all.js')}}"></script>
@endpush
