@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Data Siswa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswas.update', $siswa->student_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_name" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control @error('student_name') is-invalid @enderror" 
                                    id="student_name" name="student_name" value="{{ old('student_name', $siswa->student_name) }}" required>
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_number" class="form-label">NIS</label>
                                <input type="text" class="form-control @error('student_number') is-invalid @enderror" 
                                    id="student_number" name="student_number" value="{{ old('student_number', $siswa->student_number) }}" required>
                                @error('student_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label">Kelas</label>
                                <select class="form-select @error('class_id') is-invalid @enderror" 
                                    id="class_id" name="class_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->class_id }}" 
                                            {{ old('class_id', $siswa->class_id) == $class->class_id ? 'selected' : '' }}>
                                            {{ $class->class_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_category" class="form-label">Kategori Siswa</label>
                                <select name="student_category" id="student_category" disabled="disabled" class="form-select">
                                    <option value="REG" {{old('student_category', $siswa->student_category) == 'REG' ? 'selected' : ''}} >REGULER</option>
                                    <option value="AP50" {{old('student_category', $siswa->student_category) == 'AP50' ? 'selected' : ''}} >AP50</option>
                                    <option value="AP100" {{old('student_category', $siswa->student_category) == 'AP100' ? 'selected' : ''}} >AP100</option>
                                </select>
                                @error('student_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_pob" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('student_pob') is-invalid @enderror" 
                                    id="student_pob" name="student_pob" value="{{ old('student_pob', $siswa->student_pob) }}">
                                @error('student_pob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_dob" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('student_dob') is-invalid @enderror" 
                                    id="student_dob" name="student_dob" value="{{ old('student_dob', $siswa->student_dob) }}">
                                @error('student_dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_gender" class="form-label">Gender</label>
                                <select class="form-select @error('student_gender') is-invalid @enderror" 
                                    id="student_gender" name="student_gender">
                                    <option value="L" {{ old('student_gender', $siswa->student_gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('student_gender', $siswa->student_gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('student_gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_phone" class="form-label">No HP</label>
                                <input type="tel" class="form-control @error('student_phone') is-invalid @enderror" 
                                    id="student_phone" name="student_phone" value="{{ old('student_phone', $siswa->student_phone) }}">
                                @error('student_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ortu_phone" class="form-label">No HP Orang tua/wali</label>
                                <input type="tel" class="form-control @error('ortu_phone') is-invalid @enderror" 
                                    id="ortu_phone" name="ortu_phone" value="{{ old('ortu_phone', $siswa->ortu_phone) }}">
                                @error('ortu_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{--<div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_nik" class="form-label">NIK</label>
                                <input type="text" class="form-control @error('student_nik') is-invalid @enderror" 
                                    id="student_nik" name="student_nik" value="{{ old('student_nik', $siswa->student_nik) }}">
                                @error('student_nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_nkk" class="form-label">NKK</label>
                                <input type="text" class="form-control @error('student_nkk') is-invalid @enderror" 
                                    id="student_nkk" name="student_nkk" value="{{ old('student_nkk', $siswa->student_nkk) }}">
                                @error('student_nkk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="mb-3">
                            <label for="student_school_name" class="form-label">Asal SMP</label>
                            <input type="text" class="form-control @error('student_school_name') is-invalid @enderror" 
                                id="student_school_name" name="student_school_name" 
                                value="{{ old('student_school_name', $siswa->student_school_name) }}">
                            @error('student_school_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="province" class="form-label">Propinsi</label>
                                <select name="student_province" id="province" class="form-select">
                                    <option value="">Select Province</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->code }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                {{--<input type="text" class="form-control @error('student_province') is-invalid @enderror" 
                                    id="province" name="student_province" 
                                    value="{{ old('student_province', $siswa->student_province) }}">--}}
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="regency" class="form-label">Kab/Kota</label>
                                <select name="student_city" id="regency" class="form-select">
                                    
                                </select>
                                {{--<input type="text" class="form-control @error('student_city') is-invalid @enderror" 
                                    id="regency" name="student_city" value="{{ old('student_city', $siswa->student_city) }}">--}}
                                @error('student_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="district" class="form-label">Kecamatan</label>
                                <select name="student_district" id="district" class="form-select">
                                    
                                </select>
                                {{--<input type="text" class="form-control @error('student_district') is-invalid @enderror" 
                                    id="student_district" name="student_district" 
                                    value="{{ old('student_district', $siswa->student_district) }}">--}}
                                @error('student_district')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="village" class="form-label">Desa</label>
                                <select name="student_village" id="village" class="form-select">
                                    
                                </select>
                                {{--<input type="text" class="form-control @error('student_village') is-invalid @enderror" 
                                    id="student_village" name="student_village" 
                                    value="{{ old('student_village', $siswa->student_village) }}">--}}
                                @error('student_village')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="student_address" class="form-label">Alamat /ancer-ancer </label>
                            <textarea class="form-control @error('student_address') is-invalid @enderror" 
                                id="student_address" name="student_address" rows="3">{{ old('student_address', $siswa->student_address) }}</textarea>
                            @error('student_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_year_in" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control @error('student_year_in') is-invalid @enderror" 
                                    id="student_year_in" name="student_year_in" 
                                    value="{{ old('student_year_in', $siswa->student_year_in) }}">
                                @error('student_year_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="student_year_out" class="form-label">Tahun Lulus</label>
                                <input type="number" class="form-control @error('student_year_out') is-invalid @enderror" 
                                    id="student_year_out" name="student_year_out" 
                                    value="{{ old('student_year_out', $siswa->student_year_out) }}">
                                @error('student_year_out')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{$siswa->student_status}}
                            <label for="student_status" class="form-label">Status Siswa</label>
                            <select name="student_status" id="student_status" class="form-select">
                                <option value="A" {{old('student_status', $siswa->student_status) == 'A' ? 'selected' : ''}} >AKTIF</option>
                                <option value="L" {{old('student_status', $siswa->student_status) == 'L' ? 'selected' : ''}} >CUTI</option>
                                <option value="K" {{old('student_status', $siswa->student_status) == 'K' ? 'selected' : ''}} >KELUAR</option>
                            </select>
                            @error('student_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('siswas.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
    // Setup AJAX headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showLoading(element) {
        element.prop('disabled', true);
        element.html('<option value="">Loading...</option>');
    }

    // Province change
    $('#province').on('change', function() {
        var provinceCode = $(this).val();
        var $regency = $('#regency');
        var $district = $('#district');
        var $village = $('#village');

        // Reset dependent dropdowns
        $regency.empty().append('<option value="">Select Regency</option>').prop('disabled', true);
        $district.empty().append('<option value="">Select District</option>').prop('disabled', true);
        $village.empty().append('<option value="">Select Village</option>').prop('disabled', true);

        if (provinceCode) {
            showLoading($regency);
            
            $.ajax({
                url: `/wilayah/regencies/${provinceCode}`,
                method: 'GET',
                success: function(data) {
                    console.log('Received data:', data); // Debug log
                    
                    $regency.empty().append('<option value="">Select Regency</option>');
                    
                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, item) {
                            $regency.append($('<option>', {
                                value: item.code,
                                text: item.name
                            }));
                        });
                        $regency.prop('disabled', false);
                    } else {
                        console.error('Received empty or invalid data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading regencies. Please check console for details.');
                    $regency.empty().append('<option value="">Error loading regencies</option>');
                }
            });
        }
    });

    // Similar updates for regency change handler
    $('#regency').on('change', function() {
        var regencyCode = $(this).val();
        var $district = $('#district');
        var $village = $('#village');

        $district.empty().append('<option value="">Select District</option>').prop('disabled', true);
        $village.empty().append('<option value="">Select Village</option>').prop('disabled', true);

        if (regencyCode) {
            showLoading($district);
            
            $.ajax({
                url: `/wilayah/districts/${regencyCode}`,
                method: 'GET',
                success: function(data) {
                    console.log('Received district data:', data); // Debug log
                    
                    $district.empty().append('<option value="">Select District</option>');
                    
                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, item) {
                            $district.append($('<option>', {
                                value: item.code,
                                text: item.name
                            }));
                        });
                        $district.prop('disabled', false);
                    } else {
                        console.error('Received empty or invalid district data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading districts. Please check console for details.');
                    $district.empty().append('<option value="">Error loading districts</option>');
                }
            });
        }
    });

    // Similar updates for district change handler
    $('#district').on('change', function() {
        var districtCode = $(this).val();
        var $village = $('#village');

        $village.empty().append('<option value="">Select Village</option>').prop('disabled', true);

        if (districtCode) {
            showLoading($village);
            
            $.ajax({
                url: `/wilayah/villages/${districtCode}`,
                method: 'GET',
                success: function(data) {
                    console.log('Received village data:', data); // Debug log
                    
                    $village.empty().append('<option value="">Select Village</option>');
                    
                    if (Array.isArray(data) && data.length > 0) {
                        $.each(data, function(index, item) {
                            $village.append($('<option>', {
                                value: item.code,
                                text: item.name
                            }));
                        });
                        $village.prop('disabled', false);
                    } else {
                        console.error('Received empty or invalid village data');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Ajax Error:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                    alert('Error loading villages. Please check console for details.');
                    $village.empty().append('<option value="">Error loading villages</option>');
                }
            });
        }
    });
});
</script>
@endpush