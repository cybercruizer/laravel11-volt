@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h2 class="mb-4 h5">{{ __('Daftar Wali Kelas') }}</h2>
    </div>
    <div class="row mt-3">
        <div class="col-6">

        </div>
        <div class="col-6 text-end mr-3">
            @can('walikelas-create')
                <a href="{{ route('walikelas.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Buat Wali
                    Kelas</a>
            @endcan

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
                    <th>Kelas</th>
                    <th>Wali Kelas</th>
                    @can('walikelas-create')
                        <th>Action</th>
                    @endcan

                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $data)
                    <tr data-id="{{ $data->class_id }}" data-user-id="{{ $data->user_id }}">
                        <td>{{ $data->class_name }}</td>
                        <td>
                            <input type="hidden" id="walikelas" value="{{ $data->user_id }}">
                            {{ $guru->where('id', $data->user_id)->first()->name ?? '' }}
                        </td>
                        @can('walikelas-create')
                            <td>
                                <a href="javascript:void(0)" class="btn btn-warning" id="btn-edit"><i
                                        class="fas fa-edit"></i></a>
                                <a href="{{ route('walikelas.destroy', $data->class_id) }}" class="btn btn-danger"><i
                                        class="fas fa-trash"></i></a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Modal structure -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Walikelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">
                    <input type="hidden" id="kelas-id" name="kelas_id"></span>
                    <p><strong>Nama kelas:</strong> <br /> <input type="text" name="nama" id="nama-kelas"
                            class="form-control"></span></p>
                    <p><strong>Wali kelas:</strong> <br />
                        <select class="form-select" id="walikelas-select" name="walikelas">
                            <!-- options will be populated via AJAX route('walikelas.guru.ajax') -->
                        </select>

                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="user-update">Update</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="edit-modal-label">Edit Class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="class_name">Class Name</label>
              <input type="text" class="form-control" id="class_name" readonly>
            </div>
            <div class="form-group">
              <label for="nama_guru">Nama Guru</label>
              <select class="form-control" id="nama_guru">
                <!-- options will be populated via AJAX -->
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="submit-edit">Submit</button>
        </div>
      </div>
    </div>
</div>

<script>
    $(document).ready(function() {
      $('#btn-edit').on('click', function() {
        var class_id = $(this).data('edit');
        $.ajax({
          type: 'GET',
          //url: '{{ route('walikelas.edit', ':class_id') }}'.replace(':class_id', class_id),
          url: '{{ route('walikelas.guru.ajax') }}',
          success: function(data) {
            $('#nama_guru').empty();
            $.each(data, function(index, value) {
              $('#nama_guru').append('<option value="' + value.id + '">' + value.name + '</option>');
            });
          }
        });
        $.ajax({
          type: 'GET',
          url: '{{ route('walikelas.kelas.ajax', ':class_id') }}'.replace(':class_id', class_id),
          success: function(data) {
            $('#class_name').val(data.class_id);
            $('#class_name').text(data.class_name);
          }
        });
        $('#edit-modal').modal('show');
      });
  
      $('#submit-edit').on('click', function() {
        var class_id = $('#btn-edit').data('edit');
        var nama_guru = $('#nama_guru').val();
        $.ajax({
          type: 'PUT',
          url: route('walikelas.update', class_id),
          data: { nama_guru: nama_guru },
          success: function(data) {
            $('#edit-modal').modal('hide');
            // refresh the page or update the data
          }
        });
      });
    });
  </script>
--}}
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
        const userId = tr.data('user-id');
        const className = tr.find('td:first').text();

        // Set values in modal
        $('#kelas-id').val(classId);
        $('#nama-kelas').val(className);

        // Fetch available teachers via AJAX
        $.ajax({
            url: '{{ route('walikelas.guru.ajax') }}',
            type: 'GET',
            success: function(response) {
                const selectElement = $('#walikelas-select');
                selectElement.empty();

                // Add empty option
                selectElement.append('<option value="">Pilih Wali Kelas</option>');

                // Add teachers to select
                response.forEach(function(guru) {
                    const selected = guru.id === userId ? 'selected' : '';
                    selectElement.append(
                        `<option value="${guru.id}" ${selected}>${guru.name}</option>`
                    );
                });
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error loading guru: ' + error
                });
            }
        });

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
            url: `/walikelas/${classId}`,
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

@push('scripts')
    <script src="{{asset('sweetalert2.all.min.js')}}"></script>
@endpush
