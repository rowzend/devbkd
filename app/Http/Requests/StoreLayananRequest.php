<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLayananRequest extends FormRequest
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
        return [
            'nama' => 'required|string',
            'url' => 'required|string',
            'deskripsi' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }

    public function messages() :array
    {
        return [
            'nama.required' => 'Nama kosong',
            'deskripsi.required' => 'Deskripsi kosong',
            'url.required' => 'URL kosong',
            'thumbnail.mimes' => 'Hanya boleh jpeg,png,jpg,gif,svg',
            'thumbnail.max' => 'File hanya boleh 2MB',
        ];
    }
}
