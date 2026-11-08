<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\User;
use App\Models\Verifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display a listing of the laporan rekapitulasi with dynamic filtering and sorting by date.
     */
    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $sortBy = $request->query('sort_by', 'diverifikasi_desc');

        // Base query for Permohonan with date filtering
        $query = Permohonan::query();

        if ($startDate) {
            $query->where(function ($q) use ($startDate) {
                $q->whereDate('tanggal_surat', '>=', $startDate)
                  ->orWhere(function ($sub) use ($startDate) {
                      $sub->whereNull('tanggal_surat')->whereDate('created_at', '>=', $startDate);
                  });
            });
        }

        if ($endDate) {
            $query->where(function ($q) use ($endDate) {
                $q->whereDate('tanggal_surat', '<=', $endDate)
                  ->orWhere(function ($sub) use ($endDate) {
                      $sub->whereNull('tanggal_surat')->whereDate('created_at', '<=', $endDate);
                  });
            });
        }

        // 1. Rekap Status Proses Permohonan (Dinamis DB sesuai filter tanggal)
        $selesaiCount = (clone $query)->where('status_proses', 'Selesai')->count();
        $diprosesCount = (clone $query)->where('status_proses', 'Diproses')->count();
        $pendingCount = (clone $query)->whereIn('status_proses', ['Pending', 'Ditolak'])->count();

        // 2. Rekap Status Verifikasi (Dinamis DB sesuai filter tanggal)
        $terverifikasiCount = (clone $query)->where('status_verifikasi', 'Terverifikasi')->count();
        $belumVerifikasiCount = (clone $query)->where('status_verifikasi', '!=', 'Terverifikasi')->count();
        $totalPermohonan = (clone $query)->count();

        // 3. Rekap Produktivitas Petugas (Dinamis Agregasi DB)
        $officerNames = (clone $query)->whereNotNull('ditugaskan')
            ->where('ditugaskan', '!=', '')
            ->distinct()
            ->pluck('ditugaskan')
            ->toArray();

        // Gabungkan petugas dari tabel users jika belum ada
        $users = User::all();
        foreach ($users as $u) {
            if (!in_array($u->name, $officerNames) && $u->name !== 'Administrator SIMANTAP') {
                $officerNames[] = $u->name;
            }
        }

        // Mapping default jabatan
        $jabatanMap = [
            'Rahmat Ikraldo Busyra' => 'Kepala Bidang Verifikasi Perizinan Berusaha & Persyaratan Dasar',
            'Jaka Prasetya' => 'Kepala Sub Bidang Verifikasi Perizinan & Persyaratan Dasar',
            'Wiendi Andriyani' => 'Staf Verifikasi',
        ];

        $petugasList = [];

        foreach ($officerNames as $name) {
            $userObj = User::where('name', $name)->first();
            
            // Filter permohonan milik petugas ini sesuai periode tanggal
            $officerPermohonan = (clone $query)->where('ditugaskan', $name)->get();

            // Total yang sudah diverifikasi
            $totalDiverifikasi = $officerPermohonan->where('status_verifikasi', 'Terverifikasi')->count();

            // Hitung Rata-rata Kelengkapan Checklist (0.0 - 6.0)
            if ($officerPermohonan->count() > 0) {
                $totalChecklistSum = $officerPermohonan->sum(function ($item) {
                    return $item->checklist_count;
                });
                $avgChecklistVal = $totalChecklistSum / $officerPermohonan->count();
                $avgChecklistStr = number_format($avgChecklistVal, 1) . ' / 6';
            } else {
                $avgChecklistVal = 0.0;
                $avgChecklistStr = '0.0 / 6';
            }

            // Cari tanggal aktivitas / tanggal surat terakhir untuk petugas ini
            $latestDateItem = $officerPermohonan->sortByDesc(function ($item) {
                return $item->tanggal_surat ? $item->tanggal_surat->timestamp : $item->created_at->timestamp;
            })->first();

            $latestDateFormatted = '-';
            $latestDateTimestamp = 0;
            if ($latestDateItem) {
                $dateVal = $latestDateItem->tanggal_surat ?? $latestDateItem->created_at;
                if ($dateVal) {
                    $carbonDate = Carbon::parse($dateVal);
                    $latestDateFormatted = $carbonDate->format('d M Y');
                    $latestDateTimestamp = $carbonDate->timestamp;
                }
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
                'avg_checklist_val' => $avgChecklistVal,
                'is_active' => $isActive,
                'latest_date' => $latestDateFormatted,
                'latest_date_timestamp' => $latestDateTimestamp,
                'total_permohonan' => $officerPermohonan->count(),
            ];
        }

        // Pengurutan petugas berdasarkan parameter sorting
        usort($petugasList, function ($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'date_desc':
                    if ($b['latest_date_timestamp'] === $a['latest_date_timestamp']) {
                        return $b['total_diverifikasi'] <=> $a['total_diverifikasi'];
                    }
                    return $b['latest_date_timestamp'] <=> $a['latest_date_timestamp'];

                case 'date_asc':
                    if ($a['latest_date_timestamp'] == 0 && $b['latest_date_timestamp'] > 0) return 1;
                    if ($b['latest_date_timestamp'] == 0 && $a['latest_date_timestamp'] > 0) return -1;
                    if ($a['latest_date_timestamp'] === $b['latest_date_timestamp']) {
                        return $b['total_diverifikasi'] <=> $a['total_diverifikasi'];
                    }
                    return $a['latest_date_timestamp'] <=> $b['latest_date_timestamp'];

                case 'name_asc':
                    return strcmp($a['name'], $b['name']);

                case 'checklist_desc':
                    return $b['avg_checklist_val'] <=> $a['avg_checklist_val'];

                case 'diverifikasi_asc':
                    return $a['total_diverifikasi'] <=> $b['total_diverifikasi'];

                case 'diverifikasi_desc':
                default:
                    if ($b['total_diverifikasi'] === $a['total_diverifikasi']) {
                        return $b['latest_date_timestamp'] <=> $a['latest_date_timestamp'];
                    }
                    return $b['total_diverifikasi'] <=> $a['total_diverifikasi'];
            }
        });

        // 4. Data Rincian Permohonan (untuk tabel detail laporan dengan sorting tanggal)
        $permohonanList = (clone $query)
            ->orderBy('tanggal_surat', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('pages.laporan.index', compact(
            'selesaiCount',
            'diprosesCount',
            'pendingCount',
            'terverifikasiCount',
            'belumVerifikasiCount',
            'totalPermohonan',
            'petugasList',
            'permohonanList',
            'startDate',
            'endDate',
            'sortBy'
        ));
    }
}
