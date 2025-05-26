<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetitionSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lomba_nama' => 'required|string|max:255',
            'lomba_penyelenggara' => 'required|string|max:255',
            'lomba_kategori' => 'required|string|max:255',
            'lomba_tanggal_mulai' => 'required|date',
            'lomba_tanggal_selesai' => 'required|date|after_or_equal:lomba_tanggal_mulai',
            'lomba_link_pendaftaran' => 'nullable|url',
            'lomba_link_poster' => 'nullable|url',
            'lomba_tingkatan_id' => 'required|exists:m_tingkatans,id',
            'lomba_keahlian_id' => 'required|exists:m_keahlians,id',
        ];
    }

    public function messages(): array
    {
        return [
            'lomba_nama.required' => 'Nama lomba wajib diisi',
            'lomba_penyelenggara.required' => 'Penyelenggara lomba wajib diisi',
            'lomba_kategori.required' => 'Kategori lomba wajib diisi',
            'lomba_tanggal_mulai.required' => 'Tanggal mulai lomba wajib diisi',
            'lomba_tanggal_selesai.required' => 'Tanggal selesai lomba wajib diisi',
            'lomba_tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai',
            'lomba_tingkatan_id.required' => 'Tingkatan lomba wajib dipilih',
            'lomba_keahlian_id.required' => 'Bidang keahlian wajib dipilih',
        ];
    }
}
