<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_registrasi',
        'pemohon',
        'jenis_permohonan',
        'surat_permohonan',
        'nomor_pl',
        'no_spj_ppt',
        'no_rekom',
        'no_skep_kpt',
        'no_iph',
        'pembeli',
        'tanggal_surat',
        'status_proses',
        'status_verifikasi',
        'waktu_menunggu',
        'ditugaskan',
        'assigned_to',
        'check_sppt',
        'check_sp',
        'check_skpt',
        'check_skpl_sppl_lama',
        'check_pl',
        'check_pl_lama',
        'keterangan_petugas',
        'file_tanda_terima',
        'uploaded_by_name',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'check_sppt' => 'boolean',
        'check_sp' => 'boolean',
        'check_skpt' => 'boolean',
        'check_skpl_sppl_lama' => 'boolean',
        'check_pl' => 'boolean',
        'check_pl_lama' => 'boolean',
    ];

    /**
     * Hitung total checklist yang sudah centang (true)
     */
    public function getChecklistCountAttribute(): int
    {
        $count = 0;
        if ($this->check_sppt) $count++;
        if ($this->check_sp) $count++;
        if ($this->check_skpt) $count++;
        if ($this->check_skpl_sppl_lama) $count++;
        if ($this->check_pl) $count++;
        if ($this->check_pl_lama) $count++;
        return $count;
    }

    /**
     * Relationship to User (Officer assigned)
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
