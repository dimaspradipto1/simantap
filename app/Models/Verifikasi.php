<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasis';

    protected $fillable = [
        'permohonan_id',
        'no_registrasi',
        'pemohon',
        'jenis_permohonan',
        'status_verifikasi',
        'waktu_menunggu',
        'ditugaskan',
        'check_sppt',
        'check_skpt',
        'check_pl',
        'check_sp',
        'check_skpl_sppl_lama',
        'check_pl_lama',
        'keterangan',
        'bukti_tanda_terima',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'check_sppt' => 'boolean',
        'check_skpt' => 'boolean',
        'check_pl' => 'boolean',
        'check_sp' => 'boolean',
        'check_skpl_sppl_lama' => 'boolean',
        'check_pl_lama' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Total checklist centang (0-6)
     */
    public function getChecklistCountAttribute(): int
    {
        $count = 0;
        if ($this->check_sppt) $count++;
        if ($this->check_skpt) $count++;
        if ($this->check_pl) $count++;
        if ($this->check_sp) $count++;
        if ($this->check_skpl_sppl_lama) $count++;
        if ($this->check_pl_lama) $count++;
        return $count;
    }

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
