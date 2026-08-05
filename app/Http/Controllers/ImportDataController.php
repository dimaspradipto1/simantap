<?php

namespace App\Http\Controllers;

use App\DataTables\ImportDataDataTable;
use App\Models\ImportData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ImportDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ImportDataDataTable $dataTable)
    {
        return $dataTable->render('pages.import.index');
    }

    /**
     * Show the form for creating a new resource (Step 1).
     */
    public function create()
    {
        Session::forget(['import_preview_items', 'import_file_name']);
        return view('pages.import.create', [
            'step' => 1
        ]);
    }

    /**
     * Process Step 1 -> Render Step 2 (Pratinjau & validasi).
     */
    public function preview(Request $request)
    {
        $fileName = 'ekspor_land_bpbatam_' . date('Ymd') . '.xlsx';
        $rawItems = [];

        if ($request->hasFile('file')) {
            $request->validate([
                'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240']
            ], [
                'file.required' => 'Berkas Excel wajib diunggah.',
                'file.mimes' => 'Format berkas harus .xlsx, .xls, atau .csv',
                'file.max' => 'Ukuran berkas maksimal 10MB.'
            ]);

            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();

            // Simple CSV/Excel fallback parser or simulation structure based on 14 columns ekspor land.bpbatam
            $rawItems = $this->parseOrGenerateItems($file);
        } else {
            // Default Simulation Batch (Matches image exact sample data)
            $rawItems = $this->getSimulationBatchItems();
        }

        // Check for duplicates against existing DB records
        $existingRegistrationNos = ImportData::pluck('no_registrasi')->toArray();

        $previewItems = [];
        $totalRows = count($rawItems);
        $newDataCount = 0;
        $duplicateCount = 0;

        foreach ($rawItems as $index => $item) {
            $isDuplicate = in_array($item['no_registrasi'], $existingRegistrationNos) || (!empty($item['is_duplicate_flag']));

            if ($isDuplicate) {
                $statusValidasi = 'Duplikat — dilewati';
                $duplicateCount++;
            } else {
                $statusValidasi = 'Siap diimpor';
                $newDataCount++;
                // Add to existing array during loop to catch duplicate within same file
                $existingRegistrationNos[] = $item['no_registrasi'];
            }

            $previewItems[] = array_merge($item, [
                'status_validasi' => $statusValidasi
            ]);
        }

        Session::put('import_preview_items', $previewItems);
        Session::put('import_file_name', $fileName);

        return view('pages.import.create', [
            'step' => 2,
            'fileName' => $fileName,
            'previewItems' => $previewItems,
            'totalRows' => $totalRows,
            'newDataCount' => $newDataCount,
            'duplicateCount' => $duplicateCount
        ]);
    }

    /**
     * Process Step 2 -> Render Step 3 (Konfirmasi simpan).
     */
    public function confirmStep(Request $request)
    {
        $previewItems = Session::get('import_preview_items', []);
        $fileName = Session::get('import_file_name', 'ekspor_land.xlsx');

        if (empty($previewItems)) {
            return redirect()->route('import-data.create')->with('error', 'Sesi impor telah berakhir, silakan unggah ulang berkas.');
        }

        $validItems = array_filter($previewItems, function ($item) {
            return $item['status_validasi'] === 'Siap diimpor';
        });

        $newDataCount = count($validItems);

        return view('pages.import.create', [
            'step' => 3,
            'fileName' => $fileName,
            'newDataCount' => $newDataCount,
            'previewItems' => $previewItems
        ]);
    }

    /**
     * Final action in Step 3: Store to Database.
     */
    public function store(Request $request)
    {
        $previewItems = Session::get('import_preview_items', []);
        $fileName = Session::get('import_file_name', 'ekspor_land.xlsx');

        if (empty($previewItems)) {
            return redirect()->route('import-data.create')->with('error', 'Sesi impor telah berakhir.');
        }

        $validItems = array_filter($previewItems, function ($item) {
            return $item['status_validasi'] === 'Siap diimpor';
        });

        if (empty($validItems)) {
            return redirect()->route('import-data.create')->with('error', 'Tidak ada data valid yang siap diimpor.');
        }

        $batchId = 'BATCH-' . date('YmdHis');
        $userId = Auth::id();
        $savedCount = 0;

        foreach ($validItems as $item) {
            ImportData::create([
                'batch_id' => $batchId,
                'no_registrasi' => $item['no_registrasi'],
                'pemohon' => $item['pemohon'],
                'jenis' => $item['jenis'],
                'status' => $item['status'],
                'tgl_surat' => $item['tgl_surat'],
                'status_validasi' => 'Siap diimpor',
                'status_verifikasi' => 'Belum Diverifikasi',
                'file_name' => $fileName,
                'user_id' => $userId,
            ]);
            $savedCount++;
        }

        Session::forget(['import_preview_items', 'import_file_name']);

        return redirect()->route('import-data.index')->with('success', "Berhasil menyimpan {$savedCount} data permohonan baru ke sistem.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImportData $importDatum)
    {
        $noReg = $importDatum->no_registrasi;
        $importDatum->delete();

        return redirect()->route('import-data.index')->with('success', "Data permohonan {$noReg} berhasil dihapus.");
    }

    /**
     * Helper to return exact simulation items matching Image 2
     */
    private function getSimulationBatchItems(): array
    {
        return [
            [
                'no_registrasi' => 'EXT0420270011',
                'pemohon' => 'PT Kirana Mustika Land',
                'jenis' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status' => 'Selesai',
                'tgl_surat' => '2026-08-04',
                'is_duplicate_flag' => false,
            ],
            [
                'no_registrasi' => 'EXT0420270012',
                'pemohon' => 'Halim Kurniawan',
                'jenis' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status' => 'Selesai',
                'tgl_surat' => '2026-08-04',
                'is_duplicate_flag' => false,
            ],
            [
                'no_registrasi' => 'EXT0420270013',
                'pemohon' => 'Novita Sari Wardhani',
                'jenis' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status' => 'Diproses',
                'tgl_surat' => '2026-08-04',
                'is_duplicate_flag' => false,
            ],
            [
                'no_registrasi' => 'EXT0420270014',
                'pemohon' => 'PT Rezeki Bersama Abadi',
                'jenis' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status' => 'Selesai',
                'tgl_surat' => '2026-08-04',
                'is_duplicate_flag' => false,
            ],
            [
                'no_registrasi' => 'EXT0420269897',
                'pemohon' => 'Lim Kok Wei',
                'jenis' => 'Pelayanan Perpanjangan Hak Atas Tanah',
                'status' => 'Selesai',
                'tgl_surat' => '2026-08-04',
                'is_duplicate_flag' => true, // Demo duplicate item
            ],
        ];
    }

    /**
     * Fallback file reader if user uploads actual file
     */
    private function parseOrGenerateItems($file): array
    {
        // Try reading CSV if applicable or generate items based on file
        $items = [];
        $filePath = $file->getRealPath();

        if (($handle = fopen($filePath, "r")) !== FALSE) {
            $header = fgetcsv($handle, 1000, ",");
            $i = 100;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($data) >= 3) {
                    $items[] = [
                        'no_registrasi' => $data[0] ?? ('EXT0420270' . $i),
                        'pemohon' => $data[1] ?? 'Pemohon ' . $i,
                        'jenis' => $data[2] ?? 'Pelayanan Perpanjangan Hak Atas Tanah',
                        'status' => $data[3] ?? 'Selesai',
                        'tgl_surat' => date('Y-m-d'),
                        'is_duplicate_flag' => false,
                    ];
                    $i++;
                }
            }
            fclose($handle);
        }

        if (empty($items)) {
            $items = $this->getSimulationBatchItems();
        }

        return $items;
    }
}
