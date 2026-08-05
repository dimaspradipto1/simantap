<?php

namespace Database\Seeders;

use App\Models\Permohonan;
use App\Models\Verifikasi;
use Illuminate\Database\Seeder;

class VerifikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $queueSamples = [
            [
                'no_registrasi' => 'EXT0420269898',
                'pemohon' => 'Fitri Handayani',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '0h',
                'ditugaskan' => 'Wiendi Andriyani',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => 'mb. dokumen lengkap, diserahkan langsung oleh pemohon...',
            ],
            [
                'no_registrasi' => 'EXT0420269897',
                'pemohon' => 'Agus Salim Hasibuan',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '1h',
                'ditugaskan' => 'Rahmat Ikraldo Busyra',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => null,
            ],
            [
                'no_registrasi' => 'EXT0420269894',
                'pemohon' => 'Muhammad Ridwan',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '2h',
                'ditugaskan' => 'Rahmat Ikraldo Busyra',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => null,
            ],
            [
                'no_registrasi' => 'EXT0420269893',
                'pemohon' => 'Rina Marlina',
                'jenis_permohonan' => 'Pelayanan Peralihan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '2h',
                'ditugaskan' => 'Jaka Prasetya',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => null,
            ],
            [
                'no_registrasi' => 'EXT0420269899',
                'pemohon' => 'Siti Rohaya',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Terverifikasi',
                'waktu_menunggu' => '3h',
                'ditugaskan' => 'Wiendi Andriyani',
                'check_sppt' => true,
                'check_skpt' => true,
                'check_pl' => true,
                'check_sp' => true,
                'check_skpl_sppl_lama' => true,
                'check_pl_lama' => false,
                'keterangan' => 'Dokumen 5/6 lengkap.',
            ],
            [
                'no_registrasi' => 'EXT0420269891',
                'pemohon' => 'PT Delta Mega Kencana',
                'jenis_permohonan' => 'Pelayanan Pelepasan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '3h',
                'ditugaskan' => 'Rahmat Ikraldo Busyra',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => null,
            ],
            [
                'no_registrasi' => 'EXT0420269890',
                'pemohon' => 'Dewi Anggraini',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Menunggu',
                'waktu_menunggu' => '4h',
                'ditugaskan' => 'Wiendi Andriyani',
                'check_sppt' => false,
                'check_skpt' => false,
                'check_pl' => false,
                'check_sp' => false,
                'check_skpl_sppl_lama' => false,
                'check_pl_lama' => false,
                'keterangan' => null,
            ],
            [
                'no_registrasi' => 'EXT0420269900',
                'pemohon' => 'Lim Kok Wei',
                'jenis_permohonan' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status_verifikasi' => 'Terverifikasi',
                'waktu_menunggu' => null,
                'ditugaskan' => 'Rahmat Ikraldo Busyra',
                'check_sppt' => true,
                'check_skpt' => true,
                'check_pl' => true,
                'check_sp' => true,
                'check_skpl_sppl_lama' => true,
                'check_pl_lama' => true,
                'keterangan' => 'Dokumen 6/6 lengkap dan terverifikasi.',
            ]
        ];

        foreach ($queueSamples as $item) {
            $permohonan = Permohonan::where('no_registrasi', $item['no_registrasi'])->first();
            $item['permohonan_id'] = $permohonan ? $permohonan->id : null;
            Verifikasi::updateOrCreate(['no_registrasi' => $item['no_registrasi']], $item);
        }
    }
}
