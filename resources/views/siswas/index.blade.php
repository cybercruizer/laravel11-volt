@extends('layouts.app')

@section('content')
    
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                @role('Admin|Bk')
                    <h2 class="mb-4 h5">{{ __('Daftar Siswa') }}</h2>
                @endrole
                @role('WaliKelas')
                    <h2 class="mb-4 h5">{{ __('Daftar Siswa kelas :' . Auth::user()->kelas->class_name) }}</h2>
                @endrole
            </div>
            <div class="col-6 text-end">
                @can('siswa-create')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#studentRegistrationModal">
                        <i class="fas fa-user-plus"></i> Tambah Siswa
                    </button>
                @endcan
            </div>            
        </div>


    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-bordered" id="siswaDataTables">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Bootstrap Modal for Student Registration -->
    <div class="modal fade" id="studentRegistrationModal" tabindex="-1" aria-labelledby="studentRegistrationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="studentRegistrationForm" method="POST" action="{{ route('siswas.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="studentRegistrationModalLabel">Student Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Student Number -->
                        <div class="mb-3">
                            <label for="student_number" class="form-label">NIS</label>
                            <input type="text" class="form-control @error('student_number') is-invalid @enderror"
                                id="student_number" name="student_number" value="{{ old('student_number') }}" required>
                            @error('student_number')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Student Name -->
                        <div class="mb-3">
                            <label for="student_name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('student_name') is-invalid @enderror"
                                id="student_name" name="student_name" value="{{ old('student_name') }}" required>
                            @error('student_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Class ID -->
                        <div class="mb-3">
                            <label for="class_id" class="form-label">Kelas</label>
                            <select class="form-select @error('class_id') is-invalid @enderror" id="class_id"
                                name="class_id" required>
                                <option value="">Pilih Kelas</option>
                                @role('WaliKelas')
                                    <option value="{{ Auth::user()->kelas->class_id }}"
                                        {{ old('class_id') == Auth::user()->kelas->class_id ? 'selected' : '' }}>{{ Auth::user()->kelas->class_name }}
                                    </option>
                                @else
                                    @foreach ($kelas as $k)
                                        <option value="{{ $k->class_id }}"
                                            {{ old('class_id') == $k->class_id ? 'selected' : '' }}>{{ $k->class_name }}
                                        </option>
                                    @endforeach
                                @endrole
                                
                            </select>
                            @error('class_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Place of Birth -->
                        <div class="mb-3">
                            <label for="student_pob" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control @error('student_pob') is-invalid @enderror"
                                id="student_pob" name="student_pob" value="{{ old('student_pob') }}" required>
                            @error('student_pob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-3">
                            <label for="student_dob" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('student_dob') is-invalid @enderror"
                                id="student_dob" name="student_dob" value="{{ old('student_dob') }}" required>
                            @error('student_dob')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input @error('student_gender') is-invalid @enderror" type="radio"
                                    name="student_gender" id="L" value="L"
                                    {{ old('student_gender') == 'L' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="L">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('student_gender') is-invalid @enderror" type="radio"
                                    name="student_gender" id="P" value="P"
                                    {{ old('student_gender') == 'P' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="P">Perempuan</label>
                            </div>
                            @error('student_gender')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Siswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#siswaDataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('siswas') }}",
                columns: [{
                        data: 'student_number',
                        name: 'student_number'
                    },
                    {
                        data: 'student_name',
                        name: 'student_name'
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas'
                    },
                    //{ data: 'student_email', name: 'student_email' }
                    {
                        data: 'aksi',
                        render: function(data) {
                            return '<a href="/siswas/' + data +
                                '" class="btn btn-success btn-sm" target="_blank">Detail</a>  <a href="/siswas/edit/' +
                                data + '" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                        }
                    }
                ]
            });
        });
    </script>
@endpush
