<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiRequest extends FormRequest
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
            'permohonan_id' => ['nullable', 'exists:permohonans,id'],
            'no_registrasi' => ['required', 'string', 'max:100'],
            'pemohon' => ['nullable', 'string', 'max:255'],
            'jenis_permohonan' => ['nullable', 'string', 'max:255'],
            'status_verifikasi' => ['required', 'string', 'max:100'],
            'waktu_menunggu' => ['nullable', 'string', 'max:100'],
            'ditugaskan' => ['nullable', 'string', 'max:255'],
            'check_sppt' => ['nullable', 'boolean'],
            'check_skpt' => ['nullable', 'boolean'],
            'check_pl' => ['nullable', 'boolean'],
            'check_sp' => ['nullable', 'boolean'],
            'check_skpl_sppl_lama' => ['nullable', 'boolean'],
            'check_pl_lama' => ['nullable', 'boolean'],
            'keterangan' => ['nullable', 'string'],
            'bukti_tanda_terima' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ];
    }
}
