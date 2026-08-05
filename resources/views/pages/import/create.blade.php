@extends('layouts.dashboard.template')

@push('styles')
<style>
    .wizard-steps {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    .wizard-step-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        color: #8c98a4;
        font-size: 0.9rem;
        z-index: 1;
        background-color: #fff;
        padding: 0 10px;
    }
    .wizard-step-item.active {
        color: #1e293b;
    }
    .wizard-step-item.completed {
        color: #198754;
    }
    .step-badge {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #e2e8f0;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
    }
    .wizard-step-item.active .step-badge {
        background-color: #0f172a;
        color: #fff;
    }
    .wizard-step-item.completed .step-badge {
        background-color: #198754;
        color: #fff;
    }
    .wizard-line {
        flex: 1;
        height: 2px;
        background-color: #e2e8f0;
        margin: 0 15px;
    }
    .dropzone-box {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 50px 20px;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .dropzone-box:hover {
        border-color: #3b82f6;
        background-color: #f1f5f9;
    }
    .summary-card {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        background-color: #ffffff;
    }
    .summary-card.success-border {
        border: 1.5px solid #10b981;
    }
    .summary-card.warning-border {
        border: 1.5px solid #f59e0b;
    }
    .summary-card .number {
        font-size: 1.8rem;
        font-weight: 700;
        margin-top: 5px;
    }
    .badge-siap {
        background-color: #d1fae5;
        color: #065f46;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .badge-duplikat {
        background-color: #fef3c7;
        color: #92400e;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .btn-dark-navy {
        background-color: #0f172a;
        color: #ffffff;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
    }
    .btn-dark-navy:hover {
        background-color: #1e293b;
        color: #ffffff;
    }
    .btn-gold {
        background-color: #b45309;
        color: #ffffff;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
    }
    .btn-gold:hover {
        background-color: #92400e;
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Import Data Permohonan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Manajemen Data</li>
            <li class="breadcrumb-item active">Import Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body pt-4">

                    <!-- Step Header Wizard -->
                    <div class="wizard-steps">
                        <!-- Step 1 -->
                        <div class="wizard-step-item {{ $step == 1 ? 'active' : ($step > 1 ? 'completed' : '') }}">
                            <div class="step-badge">
                                @if($step > 1) <i class="bi bi-check-lg"></i> @else 1 @endif
                            </div>
                            <span>Pilih sumber data</span>
                        </div>

                        <div class="wizard-line"></div>

                        <!-- Step 2 -->
                        <div class="wizard-step-item {{ $step == 2 ? 'active' : ($step > 2 ? 'completed' : '') }}">
                            <div class="step-badge">
                                @if($step > 2) <i class="bi bi-check-lg"></i> @else 2 @endif
                            </div>
                            <span>Pratinjau & validasi</span>
                        </div>

                        <div class="wizard-line"></div>

                        <!-- Step 3 -->
                        <div class="wizard-step-item {{ $step == 3 ? 'active' : '' }}">
                            <div class="step-badge">3</div>
                            <span>Konfirmasi simpan</span>
                        </div>
                    </div><!-- End Step Header -->


                    @if($step == 1)
                    <!-- STEP 1: PILIH SUMBER DATA -->
                    <div class="mt-4">
                        <p class="text-secondary mb-4">
                            Unggah berkas hasil ekspor Excel dari <strong>land.bpbatam.go.id</strong>, atau gunakan simulasi batch mingguan yang sudah tersedia untuk mendemonstrasikan alur impor.
                        </p>

                        <form action="{{ route('import-data.preview') }}" method="POST" enctype="multipart/form-data" id="form-upload-step1">
                            @csrf

                            <!-- Dropzone File Upload -->
                            <div class="dropzone-box mb-4" onclick="document.getElementById('file-input').click()">
                                <i class="bi bi-upload fs-1 text-secondary mb-2 d-block"></i>
                                <h6 class="fw-bold mb-1">Seret berkas ke sini, atau klik untuk memilih</h6>
                                <p class="text-muted small mb-0">Format .xlsx — struktur 14 kolom sesuai ekspor land.bpbatam</p>
                                <input type="file" name="file" id="file-input" class="d-none" accept=".xlsx,.xls,.csv" onchange="document.getElementById('form-upload-step1').submit()">
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" name="use_simulation" value="1" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-play-circle me-1"></i> Gunakan Simulasi Batch Mingguan (Demo Data)
                                </button>

                                <button type="submit" class="btn btn-dark-navy">
                                    Lanjutkan ke pratinjau &rarr;
                                </button>
                            </div>
                        </form>
                    </div>

                    @elseif($step == 2)
                    <!-- STEP 2: PRATINJAU & VALIDASI -->
                    <div class="mt-4">
                        <!-- Summary Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="summary-card">
                                    <span class="text-muted small fw-semibold">Total baris terbaca</span>
                                    <div class="number text-dark">{{ $totalRows }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card success-border">
                                    <span class="text-muted small fw-semibold">Data baru</span>
                                    <div class="number text-success">{{ $newDataCount }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card warning-border">
                                    <span class="text-muted small fw-semibold">Terdeteksi duplikat</span>
                                    <div class="number text-warning">{{ $duplicateCount }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Preview -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle border-top">
                                <thead class="table-light">
                                    <tr class="text-uppercase small text-muted">
                                        <th>NO. REGISTRASI</th>
                                        <th>PEMOHON</th>
                                        <th>JENIS</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">TGL SURAT</th>
                                        <th class="text-center">VALIDASI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($previewItems as $item)
                                    <tr>
                                        <td class="fw-bold">{{ $item['no_registrasi'] }}</td>
                                        <td>{{ $item['pemohon'] }}</td>
                                        <td>{{ $item['jenis'] }}</td>
                                        <td class="text-center">
                                            @if(strtolower($item['status']) == 'selesai')
                                                <span class="badge bg-success-light text-success px-2 py-1">Selesai</span>
                                            @else
                                                <span class="badge bg-primary-light text-primary px-2 py-1">{{ $item['status'] }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($item['tgl_surat'])->translatedFormat('d M Y') }}</td>
                                        <td class="text-center">
                                            @if($item['status_validasi'] == 'Siap diimpor')
                                                <span class="badge-siap">Siap diimpor</span>
                                            @else
                                                <span class="badge-duplikat">Duplikat — dilewati</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Bar Step 2 -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('import-data.create') }}" class="btn btn-outline-secondary px-4">
                                &larr; Kembali
                            </a>

                            <form action="{{ route('import-data.confirm') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark-navy">
                                    Lanjutkan ke konfirmasi &rarr;
                                </button>
                            </form>
                        </div>
                    </div>

                    @elseif($step == 3)
                    <!-- STEP 3: KONFIRMASI SIMPAN -->
                    <div class="text-center py-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-light rounded-circle mb-3" style="width: 70px; height: 70px; background-color: #d1fae5;">
                            <i class="bi bi-check2-square text-success fs-1"></i>
                        </div>

                        <h3 class="fw-bold mb-2">Siap menyimpan {{ $newDataCount }} permohonan baru</h3>
                        <p class="text-secondary col-md-8 mx-auto mb-4">
                            Data akan ditambahkan ke Data Permohonan dengan status verifikasi <strong>Belum Diverifikasi</strong>, lalu otomatis masuk ke antrean petugas.
                        </p>

                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('import-data.create') }}" class="btn btn-outline-secondary px-4 py-2">
                                &larr; Kembali
                            </a>

                            <form action="{{ route('import-data.store') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-gold px-4 py-2">
                                    Simpan {{ $newDataCount }} data ke sistem
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
