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
        'pemohon',
        'jenis',
        'status',
        'tgl_surat',
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
