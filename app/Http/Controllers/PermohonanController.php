<?php

namespace App\Http\Controllers;

use App\DataTables\PermohonanDataTable;
use App\Http\Requests\PermohonanRequest;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PermohonanDataTable $dataTable)
    {
        $totalCount = Permohonan::count();
        return $dataTable->render('pages.permohonan.index', compact('totalCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('is_active', true)->get();
        return view('pages.permohonan.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermohonanRequest $request)
    {
        $data = $request->validated();

        // Checkbox Booleans
        $data['check_sppt'] = $request->has('check_sppt');
        $data['check_sp'] = $request->has('check_sp');
        $data['check_skpt'] = $request->has('check_skpt');
        $data['check_skpl_sppl_lama'] = $request->has('check_skpl_sppl_lama');
        $data['check_pl'] = $request->has('check_pl');
        $data['check_pl_lama'] = $request->has('check_pl_lama');

        // File upload handling
        if ($request->hasFile('file_tanda_terima')) {
            $file = $request->file('file_tanda_terima');
            $filename = 'tanda-terima-' . $data['no_registrasi'] . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('permohonan_files', $filename, 'public');
            $data['file_tanda_terima'] = $path;
        }

        if (auth()->check()) {
            $data['uploaded_by_name'] = auth()->user()->name;
        }

        Permohonan::create($data);

        return redirect()->route('permohonan.index')->with('success', 'Data Permohonan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource in JSON format for Detail Modal.
     */
    public function show(Permohonan $permohonan)
    {
        $permohonan->load('assignedUser');
        $tglSuratFormatted = $permohonan->tanggal_surat ? $permohonan->tanggal_surat->format('j M Y') : '-';
        
        return response()->json([
            'status' => 'success',
            'data' => $permohonan,
            'checklist_count' => $permohonan->checklist_count,
            'tanggal_surat_formatted' => $tglSuratFormatted,
            'file_url' => $permohonan->file_tanda_terima ? asset('storage/' . $permohonan->file_tanda_terima) : null,
            'file_basename' => $permohonan->file_tanda_terima ? basename($permohonan->file_tanda_terima) : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permohonan $permohonan)
    {
        $users = User::where('is_active', true)->get();
        return view('pages.permohonan.edit', compact('permohonan', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermohonanRequest $request, Permohonan $permohonan)
    {
        $data = $request->validated();

        // Checkbox Booleans
        $data['check_sppt'] = $request->has('check_sppt');
        $data['check_sp'] = $request->has('check_sp');
        $data['check_skpt'] = $request->has('check_skpt');
        $data['check_skpl_sppl_lama'] = $request->has('check_skpl_sppl_lama');
        $data['check_pl'] = $request->has('check_pl');
        $data['check_pl_lama'] = $request->has('check_pl_lama');

        // File upload handling
        if ($request->hasFile('file_tanda_terima')) {
            if ($permohonan->file_tanda_terima && Storage::disk('public')->exists($permohonan->file_tanda_terima)) {
                Storage::disk('public')->delete($permohonan->file_tanda_terima);
            }

            $file = $request->file('file_tanda_terima');
            $filename = 'tanda-terima-' . $data['no_registrasi'] . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('permohonan_files', $filename, 'public');
            $data['file_tanda_terima'] = $path;
            
            if (auth()->check()) {
                $data['uploaded_by_name'] = auth()->user()->name;
            }
        }

        $permohonan->update($data);

        return redirect()->route('permohonan.index')->with('success', 'Data Permohonan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permohonan $permohonan)
    {
        if ($permohonan->file_tanda_terima && Storage::disk('public')->exists($permohonan->file_tanda_terima)) {
            Storage::disk('public')->delete($permohonan->file_tanda_terima);
        }

        $permohonan->delete();

        if (request()->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => 'Data permohonan berhasil dihapus.']);
        }

        return redirect()->route('permohonan.index')->with('success', 'Data Permohonan berhasil dihapus.');
    }
}
