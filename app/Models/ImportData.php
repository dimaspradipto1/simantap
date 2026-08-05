<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportData extends Model
{
    use HasFactory;

    protected $table = 'import_data';

    protected $fillable = [
        'batch_id',
        'no_registrasi',
        'surat_permohonan',
        'jenis',
        'pemohon',
        'pembeli',
        'status',
        'tgl_surat',
        'nomor_pl',
        'no_spj_ppt',
        'no_skep_kpt',
        'no_iph',
        'no_rekom',
        'alasan_pending',
        'status_validasi',
        'status_verifikasi',
        'file_name',
        'user_id',
    ];

    protected $casts = [
        'tgl_surat' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
