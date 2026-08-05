<?php

namespace App\Http\Controllers;

use App\DataTables\VerfikasiDataTable;
use App\Http\Requests\VerifikasiRequest;
use App\Models\Permohonan;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource (Split Queue Workspace & DataTable view).
     */
    public function index(VerfikasiDataTable $dataTable, Request $request)
    {
        $antreanList = Verifikasi::latest()->get();

        // Selected active item for verification form (default to first or active_id)
        $activeId = $request->query('active_id');
        $activeItem = null;

        if ($activeId) {
            $activeItem = Verifikasi::with('permohonan')->find($activeId);
        }

        if (!$activeItem && $antreanList->count() > 0) {
            $activeItem = $antreanList->first();
            if ($activeItem) {
                $activeItem->load('permohonan');
            }
        }

        $users = User::where('is_active', true)->get();
        $totalAntrean = $antreanList->where('status_verifikasi', 'Menunggu')->count();

        return $dataTable->render('pages.verifikasi.index', compact('antreanList', 'activeItem', 'users', 'totalAntrean'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permohonanList = Permohonan::latest()->get();
        $users = User::where('is_active', true)->get();
        return view('pages.verifikasi.create', compact('permohonanList', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VerifikasiRequest $request)
    {
        $data = $request->validated();

        $data['check_sppt'] = $request->has('check_sppt');
        $data['check_skpt'] = $request->has('check_skpt');
        $data['check_pl'] = $request->has('check_pl');
        $data['check_sp'] = $request->has('check_sp');
        $data['check_skpl_sppl_lama'] = $request->has('check_skpl_sppl_lama');
        $data['check_pl_lama'] = $request->has('check_pl_lama');

        if ($request->hasFile('bukti_tanda_terima')) {
            $file = $request->file('bukti_tanda_terima');
            $filename = 'tanda-terima-' . $data['no_registrasi'] . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_terima_files', $filename, 'public');
            $data['bukti_tanda_terima'] = $path;
        }

        if ($data['status_verifikasi'] === 'Terverifikasi') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        $verifikasi = Verifikasi::create($data);

        // Sync with permohonan if exists
        if ($verifikasi->permohonan_id) {
            $permohonan = Permohonan::find($verifikasi->permohonan_id);
            if ($permohonan) {
                $permohonan->update([
                    'check_sppt' => $verifikasi->check_sppt,
                    'check_skpt' => $verifikasi->check_skpt,
                    'check_pl' => $verifikasi->check_pl,
                    'check_sp' => $verifikasi->check_sp,
                    'check_skpl_sppl_lama' => $verifikasi->check_skpl_sppl_lama,
                    'check_pl_lama' => $verifikasi->check_pl_lama,
                    'status_verifikasi' => $verifikasi->status_verifikasi,
                    'keterangan_petugas' => $verifikasi->keterangan,
                    'file_tanda_terima' => $verifikasi->bukti_tanda_terima ?? $permohonan->file_tanda_terima,
                ]);
            }
        }

        return redirect()->route('verifikasi.index')->with('success', 'Data Verifikasi Checklist berhasil disimpan.');
    }

    /**
     * Display the specified resource in JSON format.
     */
    public function show(Verifikasi $verifikasi)
    {
        $verifikasi->load(['permohonan', 'verifier']);
        return response()->json([
            'status' => 'success',
            'data' => $verifikasi,
            'checklist_count' => $verifikasi->checklist_count,
            'file_url' => $verifikasi->bukti_tanda_terima ? asset('storage/' . $verifikasi->bukti_tanda_terima) : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Verifikasi $verifikasi)
    {
        $permohonanList = Permohonan::latest()->get();
        $users = User::where('is_active', true)->get();
        return view('pages.verifikasi.edit', compact('verifikasi', 'permohonanList', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VerifikasiRequest $request, Verifikasi $verifikasi)
    {
        $data = $request->validated();

        $data['check_sppt'] = $request->has('check_sppt');
        $data['check_skpt'] = $request->has('check_skpt');
        $data['check_pl'] = $request->has('check_pl');
        $data['check_sp'] = $request->has('check_sp');
        $data['check_skpl_sppl_lama'] = $request->has('check_skpl_sppl_lama');
        $data['check_pl_lama'] = $request->has('check_pl_lama');

        if ($request->hasFile('bukti_tanda_terima')) {
            if ($verifikasi->bukti_tanda_terima && Storage::disk('public')->exists($verifikasi->bukti_tanda_terima)) {
                Storage::disk('public')->delete($verifikasi->bukti_tanda_terima);
            }

            $file = $request->file('bukti_tanda_terima');
            $filename = 'tanda-terima-' . $data['no_registrasi'] . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('bukti_terima_files', $filename, 'public');
            $data['bukti_tanda_terima'] = $path;
        }

        if ($data['status_verifikasi'] === 'Terverifikasi') {
            $data['verified_by'] = Auth::id();
            $data['verified_at'] = now();
        }

        $verifikasi->update($data);

        // Sync back to permohonans table
        if ($verifikasi->permohonan_id) {
            $permohonan = Permohonan::find($verifikasi->permohonan_id);
            if ($permohonan) {
                $permohonan->update([
                    'check_sppt' => $verifikasi->check_sppt,
                    'check_skpt' => $verifikasi->check_skpt,
                    'check_pl' => $verifikasi->check_pl,
                    'check_sp' => $verifikasi->check_sp,
                    'check_skpl_sppl_lama' => $verifikasi->check_skpl_sppl_lama,
                    'check_pl_lama' => $verifikasi->check_pl_lama,
                    'status_verifikasi' => $verifikasi->status_verifikasi,
                    'keterangan_petugas' => $verifikasi->keterangan,
                    'file_tanda_terima' => $verifikasi->bukti_tanda_terima ?? $permohonan->file_tanda_terima,
                ]);
            }
        }

        return redirect()->route('verifikasi.index', ['active_id' => $verifikasi->id])->with('success', 'Verifikasi berkas ' . $verifikasi->no_registrasi . ' berhasil disimpan dan diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Verifikasi $verifikasi)
    {
        if ($verifikasi->bukti_tanda_terima && Storage::disk('public')->exists($verifikasi->bukti_tanda_terima)) {
            Storage::disk('public')->delete($verifikasi->bukti_tanda_terima);
        }

        $verifikasi->delete();

        return redirect()->route('verifikasi.index')->with('success', 'Data Verifikasi berhasil dihapus.');
    }
}
