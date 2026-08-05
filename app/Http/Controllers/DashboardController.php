<?php

namespace App\Http\Controllers;

use App\Models\ImportData;
use App\Models\Permohonan;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role ?? 'user';

        $data = [
            'user' => $user,
            'role' => $role,
        ];

        if ($role === 'admin') {
            $data['totalPermohonan'] = Permohonan::count();
            $data['permohonanSelesai'] = Permohonan::where('status_proses', 'Selesai')->count();
            $data['permohonanDiproses'] = Permohonan::where('status_proses', 'Diproses')->count();
            $data['menungguVerifikasi'] = Permohonan::where('status_verifikasi', 'Menunggu')->count();
            $data['terverifikasi'] = Permohonan::where('status_verifikasi', 'Terverifikasi')->count();
            
            $data['totalUser'] = User::count();
            $data['totalPetugas'] = User::where('role', 'petugas')->where('is_active', true)->count();
            $data['totalImport'] = ImportData::count();

            $data['latestPermohonan'] = Permohonan::with('assignedUser')->latest()->take(6)->get();
            $data['jenisPermohonanStats'] = Permohonan::select('jenis_permohonan', DB::raw('count(*) as total'))
                ->groupBy('jenis_permohonan')
                ->pluck('total', 'jenis_permohonan')
                ->toArray();

            $data['checklistStats'] = [
                'SPPT' => Permohonan::where('check_sppt', true)->count(),
                'Surat Permohonan' => Permohonan::where('check_sp', true)->count(),
                'SKPT' => Permohonan::where('check_skpt', true)->count(),
                'SKPL / SPPL Lama' => Permohonan::where('check_skpl_sppl_lama', true)->count(),
                'PL' => Permohonan::where('check_pl', true)->count(),
                'PL Lama' => Permohonan::where('check_pl_lama', true)->count(),
            ];

            $data['petugasList'] = User::where('role', 'petugas')
                ->withCount(['permohonans' => function ($q) {
                    $q->where('status_verifikasi', 'Menunggu');
                }])
                ->get();

        } elseif ($role === 'petugas') {
            $assignedQuery = Permohonan::where(function ($q) use ($user) {
                $q->where('assigned_to', $user->id)
                  ->orWhere('ditugaskan', $user->name);
            });

            $data['myTotalTugas'] = (clone $assignedQuery)->count();
            $data['myMenungguVerifikasi'] = (clone $assignedQuery)->where('status_verifikasi', 'Menunggu')->count();
            $data['myTerverifikasi'] = (clone $assignedQuery)->where('status_verifikasi', 'Terverifikasi')->count();
            $data['mySelesai'] = (clone $assignedQuery)->where('status_proses', 'Selesai')->count();

            $data['systemAntreanCount'] = Verifikasi::where('status_verifikasi', 'Menunggu')->count();
            $data['myTugasList'] = (clone $assignedQuery)->latest()->take(10)->get();
            $data['systemAntreanList'] = Verifikasi::where('status_verifikasi', 'Menunggu')->latest()->take(5)->get();

        } else {
            // Role user (pemohon / umum)
            $userQuery = Permohonan::where(function ($q) use ($user) {
                $q->where('uploaded_by_name', $user->name)
                  ->orWhere('pemohon', $user->name);
            });

            $data['myTotalPermohonan'] = (clone $userQuery)->count();
            $data['myDiproses'] = (clone $userQuery)->where('status_proses', 'Diproses')->count();
            $data['mySelesai'] = (clone $userQuery)->where('status_proses', 'Selesai')->count();
            $data['myTerverifikasi'] = (clone $userQuery)->where('status_verifikasi', 'Terverifikasi')->count();

            $data['myPermohonanList'] = (clone $userQuery)->latest()->take(10)->get();
        }

        return view('layouts.dashboard.index', $data);
    }
}
