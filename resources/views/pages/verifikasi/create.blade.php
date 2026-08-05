@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Verifikasi Manual</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('verifikasi.index') }}">Verifikasi Checklist</a></li>
            <li class="breadcrumb-item active">Tambah Manual</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h5 class="card-title fw-bold text-dark mb-4" style="font-size: 1.25rem;">Formulir Verifikasi Checklist Manual</h5>

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Terdapat kesalahan pengisian:</div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('verifikasi.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf

                        <!-- Section 1: Informasi Permohonan -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-person-lines-fill me-1"></i> Informasi Berkas & Pemohon</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="no_registrasi" class="form-label fw-semibold">No. Registrasi <span class="text-danger">*</span></label>
                            <input type="text" name="no_registrasi" class="form-control @error('no_registrasi') is-invalid @enderror" id="no_registrasi" value="{{ old('no_registrasi') }}" placeholder="Contoh: EXT0420269898" required>
                        </div>

                        <div class="col-md-6">
                            <label for="pemohon" class="form-label fw-semibold">Nama Pemohon</label>
                            <input type="text" name="pemohon" class="form-control" id="pemohon" value="{{ old('pemohon') }}" placeholder="Contoh: Fitri Handayani">
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_permohonan" class="form-label fw-semibold">Jenis Permohonan</label>
                            <select name="jenis_permohonan" class="form-select" id="jenis_permohonan">
                                <option value="Pelayanan Perpanjangan Hak Atas Tanah" {{ old('jenis_permohonan') == 'Pelayanan Perpanjangan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Perpanjangan Hak Atas Tanah</option>
                                <option value="Pelayanan Peralihan Hak Atas Tanah" {{ old('jenis_permohonan') == 'Pelayanan Peralihan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Peralihan Hak Atas Tanah</option>
                                <option value="Pelayanan Pelepasan Hak Atas Tanah" {{ old('jenis_permohonan') == 'Pelayanan Pelepasan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Pelepasan Hak Atas Tanah</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="ditugaskan" class="form-label fw-semibold">Ditugaskan Kepada</label>
                            <input type="text" name="ditugaskan" class="form-control" id="ditugaskan" value="{{ old('ditugaskan', 'Wiendi Andriyani') }}" placeholder="Nama petugas penanggung jawab">
                        </div>

                        <div class="col-md-6">
                            <label for="status_verifikasi" class="form-label fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verifikasi" class="form-select" id="status_verifikasi" required>
                                <option value="Terverifikasi" {{ old('status_verifikasi') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="Menunggu" {{ old('status_verifikasi', 'Menunggu') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="waktu_menunggu" class="form-label fw-semibold">Waktu Menunggu</label>
                            <input type="text" name="waktu_menunggu" class="form-control" id="waktu_menunggu" value="{{ old('waktu_menunggu', '0h') }}" placeholder="Contoh: 0h, 1h, 2h">
                        </div>

                        <!-- Section 2: Checklist 6 Dokumen -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-card-checklist me-1"></i> Checklist Dokumen Tanda Terima</h6>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_sppt" value="1" id="check_sppt" {{ old('check_sppt') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_sppt">SPPT</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_skpt" value="1" id="check_skpt" {{ old('check_skpt') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_skpt">SKPT</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_pl" value="1" id="check_pl" {{ old('check_pl') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_pl">PL</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_sp" value="1" id="check_sp" {{ old('check_sp') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_sp">SP</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_skpl_sppl_lama" value="1" id="check_skpl_sppl_lama" {{ old('check_skpl_sppl_lama') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_skpl_sppl_lama">SKPL & SPPL Lama</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_pl_lama" value="1" id="check_pl_lama" {{ old('check_pl_lama') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_pl_lama">PL Lama</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Keterangan & Upload File -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-paperclip me-1"></i> Catatan & Lampiran Tanda Terima</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan" rows="3" placeholder="Dokumen lengkap, diserahkan langsung oleh pemohon...">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="bukti_tanda_terima" class="form-label fw-semibold">Unggah Bukti Tanda Terima (PDF/JPG/PNG)</label>
                            <input type="file" name="bukti_tanda_terima" class="form-control" id="bukti_tanda_terima">
                            <div class="form-text">Maksimal 10 MB.</div>
                        </div>

                        <!-- Submit Action Buttons -->
                        <div class="col-12 pt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('verifikasi.index') }}" class="btn btn-light border px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">
                                <i class="bi bi-save me-1"></i> Simpan Data Verifikasi
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
