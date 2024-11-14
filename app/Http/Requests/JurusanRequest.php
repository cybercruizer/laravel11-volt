<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JurusanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $jurusan = $this->route('jurusan');
        $jurusanId = $jurusan ? $jurusan->id : null;

        return [
            'kode' => [
                'required',
                'string',
                'max:10',
                //Rule::unique('jurusan', 'kode')->ignore($jurusanId)
            ],
            'nama' => 'required|string|max:50',
            'user_id' => [
                'required',
                //Rule::exists('users', 'id')->where(function ($query) {
                //    $query->whereHas('roles', function ($q) {
                //        $q->where('name', 'Kapro');
                //    });
                //})
            ],
            'is_active' => 'required|boolean'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'kode' => 'Kode jurusan',
            'nama' => 'Nama jurusan',
            'user_id' => 'Ketua program',
            'is_active' => 'Status'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode.required' => ':attribute wajib diisi',
            'kode.unique' => ':attribute sudah digunakan',
            'kode.max' => ':attribute maksimal 10 karakter',
            'nama.required' => ':attribute wajib diisi',
            'nama.max' => ':attribute maksimal 255 karakter',
            'user_id.required' => ':attribute wajib dipilih',
            'user_id.exists' => ':attribute tidak valid',
            'is_active.required' => ':attribute wajib dipilih',
            'is_active.boolean' => ':attribute tidak valid'
        ];
    }
}