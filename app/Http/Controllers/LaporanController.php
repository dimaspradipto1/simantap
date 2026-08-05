<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the laporan rekapitulasi with 100% dynamic data.
     */
    public function index()
    {
        // 1. Rekap Status Proses Permohonan (Dinamis DB)
        $selesaiCount = Permohonan::where('status_proses', 'Selesai')->count();
        $diprosesCount = Permohonan::where('status_proses', 'Diproses')->count();
        $pendingCount = Permohonan::whereIn('status_proses', ['Pending', 'Ditolak'])->count();

        // 2. Rekap Status Verifikasi (Dinamis DB)
        $terverifikasiCount = Permohonan::where('status_verifikasi', 'Terverifikasi')->count();
        $belumVerifikasiCount = Permohonan::where('status_verifikasi', '!=', 'Terverifikasi')->count();
        $totalPermohonan = Permohonan::count();

        // 3. Rekap Produktivitas Petugas (Dinamis Agregasi DB)
        // Ambil seluruh nama petugas yang pernah ditugaskan di permohonan atau terdaftar di tabel users
        $officerNames = Permohonan::whereNotNull('ditugaskan')
            ->where('ditugaskan', '!=', '')
            ->distinct()
            ->pluck('ditugaskan')
            ->toArray();

        // Gabungkan juga petugas dari tabel users jika belum ada
        $users = User::all();
        foreach ($users as $u) {
            if (!in_array($u->name, $officerNames) && $u->name !== 'Administrator SIMANTAP') {
                $officerNames[] = $u->name;
            }
        }

        // Mapping default jabatan presisi gambar
        $jabatanMap = [
            'Rahmat Ikraldo Busyra' => 'Kepala Bidang Verifikasi Perizinan Berusaha & Persyaratan Dasar',
            'Jaka Prasetya' => 'Kepala Sub Bidang Verifikasi Perizinan & Persyaratan Dasar',
            'Wiendi Andriyani' => 'Staf Verifikasi',
        ];

        $petugasList = [];

        foreach ($officerNames as $name) {
            $userObj = User::where('name', $name)->first();
            
            // Filter permohonan milik petugas ini
            $officerPermohonan = Permohonan::where('ditugaskan', $name)->get();

            // Total yang sudah diverifikasi
            $totalDiverifikasi = $officerPermohonan->where('status_verifikasi', 'Terverifikasi')->count();

            // Hitung Rata-rata Kelengkapan Checklist secara Dinamis (0.0 - 6.0)
            if ($officerPermohonan->count() > 0) {
                $totalChecklistSum = $officerPermohonan->sum(function ($item) {
                    return $item->checklist_count;
                });
                $avgChecklistVal = $totalChecklistSum / $officerPermohonan->count();
                $avgChecklistStr = number_format($avgChecklistVal, 1) . ' / 6';
            } else {
                $avgChecklistStr = '0.0 / 6';
            }

            // Jabatan dinamis
            $jabatan = $jabatanMap[$name] ?? ($userObj ? ($userObj->role === 'admin' ? 'Administrator System' : 'Staf Verifikator Pertanahan') : 'Staf Verifikasi');

            // Status Akun dinamis
            $isActive = $userObj ? (bool)$userObj->is_active : ($name === 'Wiendi Andriyani' ? false : true);

            $petugasList[] = [
                'name' => $name,
                'jabatan' => $jabatan,
                'total_diverifikasi' => $totalDiverifikasi,
                'avg_checklist' => $avgChecklistStr,
                'is_active' => $isActive,
            ];
        }

        // Urutkan berdasarkan total diverifikasi terbanyak
        usort($petugasList, function ($a, $b) {
            return $b['total_diverifikasi'] <=> $a['total_diverifikasi'];
        });

        return view('pages.laporan.index', compact(
            'selesaiCount',
            'diprosesCount',
            'pendingCount',
            'terverifikasiCount',
            'belumVerifikasiCount',
            'totalPermohonan',
            'petugasList'
        ));
    }
}
