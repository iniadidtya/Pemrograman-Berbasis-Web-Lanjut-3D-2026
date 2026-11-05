<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib true agar request diizinkan masuk
    }

    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string|min:3|max:150',
            'penulis' => 'required|string|min:3|max:100',
            // date('Y') akan mengambil tahun saat ini secara otomatis
            'tahun_terbit' => 'required|integer|between:1900,' . date('Y'),
        ];
    }

    // Pesan error custom bahasa Indonesia
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'exists' => ':attribute yang dipilih tidak valid.',
            'min' => ':attribute minimal :min karakter.',
            'max' => ':attribute maksimal :max karakter.',
            'between' => ':attribute harus antara :min sampai :max.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus berupa angka bulat.'
        ];
    }

    // Mengubah nama atribut agar ramah dibaca (kategori_id -> Kategori)
    public function attributes(): array
    {
        return [
            'kategori_id' => 'Kategori',
            'judul' => 'Judul buku',
            'penulis' => 'Penulis',
            'tahun_terbit' => 'Tahun terbit'
        ];
    }
}