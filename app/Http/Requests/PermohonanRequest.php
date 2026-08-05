<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermohonanRequest extends FormRequest
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
        $id = $this->route('permohonan') ? $this->route('permohonan')->id : null;

        return [
            'no_registrasi' => ['required', 'string', 'max:100', Rule::unique('permohonans', 'no_registrasi')->ignore($id)],
            'pemohon' => ['required', 'string', 'max:255'],
            'jenis_permohonan' => ['required', 'string', 'max:255'],
            'surat_permohonan' => ['nullable', 'string', 'max:255'],
            'nomor_pl' => ['nullable', 'string', 'max:255'],
            'no_spj_ppt' => ['nullable', 'string', 'max:255'],
            'no_rekom' => ['nullable', 'string', 'max:255'],
            'no_skep_kpt' => ['nullable', 'string', 'max:255'],
            'pembeli' => ['nullable', 'string', 'max:255'],
            'tanggal_surat' => ['nullable', 'date'],
            'status_proses' => ['required', 'string', 'max:100'],
            'status_verifikasi' => ['required', 'string', 'max:100'],
            'waktu_menunggu' => ['nullable', 'string', 'max:100'],
            'ditugaskan' => ['nullable', 'string', 'max:255'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'check_sppt' => ['nullable', 'boolean'],
            'check_sp' => ['nullable', 'boolean'],
            'check_skpt' => ['nullable', 'boolean'],
            'check_skpl_sppl_lama' => ['nullable', 'boolean'],
            'check_pl' => ['nullable', 'boolean'],
            'check_pl_lama' => ['nullable', 'boolean'],
            'keterangan_petugas' => ['nullable', 'string'],
            'file_tanda_terima' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,doc,docx,xlsx,csv', 'max:10240'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'no_registrasi.required' => 'Nomor Registrasi wajib diisi.',
            'no_registrasi.unique' => 'Nomor Registrasi sudah terdaftar.',
            'pemohon.required' => 'Nama Pemohon wajib diisi.',
            'jenis_permohonan.required' => 'Jenis Permohonan wajib diisi.',
            'status_proses.required' => 'Status Proses wajib dipilih.',
            'status_verifikasi.required' => 'Status Verifikasi wajib dipilih.',
        ];
    }
}
