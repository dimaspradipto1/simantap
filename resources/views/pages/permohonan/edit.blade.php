@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Data Permohonan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('permohonan.index') }}">Data Permohonan</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title fw-bold text-dark m-0" style="font-size: 1.25rem;">
                            Edit Permohonan: <span class="text-primary">{{ $permohonan->no_registrasi }}</span>
                        </h5>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                            Dibuat: {{ $permohonan->created_at ? $permohonan->created_at->format('d/m/Y H:i') : '-' }}
                        </span>
                    </div>

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

                    <form action="{{ route('permohonan.update', $permohonan->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Informasi Utam Permohonan -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-person-lines-fill me-1"></i> Informasi Pemohon & Berkas</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="no_registrasi" class="form-label fw-semibold">No. Registrasi <span class="text-danger">*</span></label>
                            <input type="text" name="no_registrasi" class="form-control @error('no_registrasi') is-invalid @enderror" id="no_registrasi" value="{{ old('no_registrasi', $permohonan->no_registrasi) }}" required>
                            @error('no_registrasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="pemohon" class="form-label fw-semibold">Nama Pemohon <span class="text-danger">*</span></label>
                            <input type="text" name="pemohon" class="form-control @error('pemohon') is-invalid @enderror" id="pemohon" value="{{ old('pemohon', $permohonan->pemohon) }}" required>
                            @error('pemohon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="jenis_permohonan" class="form-label fw-semibold">Jenis Permohonan <span class="text-danger">*</span></label>
                            <select name="jenis_permohonan" class="form-select @error('jenis_permohonan') is-invalid @enderror" id="jenis_permohonan" required>
                                <option value="Pelayanan Perpanjangan Hak Atas Tanah" {{ old('jenis_permohonan', $permohonan->jenis_permohonan) == 'Pelayanan Perpanjangan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Perpanjangan Hak Atas Tanah</option>
                                <option value="Pelayanan Peralihan Hak Atas Tanah" {{ old('jenis_permohonan', $permohonan->jenis_permohonan) == 'Pelayanan Peralihan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Peralihan Hak Atas Tanah</option>
                                <option value="Pelayanan Pelepasan Hak Atas Tanah" {{ old('jenis_permohonan', $permohonan->jenis_permohonan) == 'Pelayanan Pelepasan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Pelepasan Hak Atas Tanah</option>
                                <option value="Pelayanan Pemecahan Hak Atas Tanah" {{ old('jenis_permohonan', $permohonan->jenis_permohonan) == 'Pelayanan Pemecahan Hak Atas Tanah' ? 'selected' : '' }}>Pelayanan Pemecahan Hak Atas Tanah</option>
                            </select>
                            @error('jenis_permohonan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_surat" class="form-label fw-semibold">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat" class="form-control @error('tanggal_surat') is-invalid @enderror" id="tanggal_surat" value="{{ old('tanggal_surat', $permohonan->tanggal_surat ? $permohonan->tanggal_surat->format('Y-m-d') : '') }}">
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section 2: Detail Berkas & Dokumen -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-file-earmark-text me-1"></i> Detail Nomor Dokumen</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="surat_permohonan" class="form-label fw-semibold">Surat Permohonan</label>
                            <input type="text" name="surat_permohonan" class="form-control" id="surat_permohonan" value="{{ old('surat_permohonan', $permohonan->surat_permohonan) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="nomor_pl" class="form-label fw-semibold">Nomor PL</label>
                            <input type="text" name="nomor_pl" class="form-control" id="nomor_pl" value="{{ old('nomor_pl', $permohonan->nomor_pl) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="no_spj_ppt" class="form-label fw-semibold">No. SPJ/PPT</label>
                            <input type="text" name="no_spj_ppt" class="form-control" id="no_spj_ppt" value="{{ old('no_spj_ppt', $permohonan->no_spj_ppt) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="no_skep_kpt" class="form-label fw-semibold">No. SKEP/KPT</label>
                            <input type="text" name="no_skep_kpt" class="form-control" id="no_skep_kpt" value="{{ old('no_skep_kpt', $permohonan->no_skep_kpt) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="no_rekom" class="form-label fw-semibold">No. Rekom</label>
                            <input type="text" name="no_rekom" class="form-control" id="no_rekom" value="{{ old('no_rekom', $permohonan->no_rekom) }}">
                        </div>

                        <div class="col-md-6">
                            <label for="pembeli" class="form-label fw-semibold">Pembeli</label>
                            <input type="text" name="pembeli" class="form-control" id="pembeli" value="{{ old('pembeli', $permohonan->pembeli) }}">
                        </div>

                        <!-- Section 3: Status & Penugasan -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-gear-wide-connected me-1"></i> Status & Petugas Penanggung Jawab</h6>
                        </div>

                        <div class="col-md-4">
                            <label for="status_proses" class="form-label fw-semibold">Status Proses <span class="text-danger">*</span></label>
                            <select name="status_proses" class="form-select" id="status_proses" required>
                                <option value="Diproses" {{ old('status_proses', $permohonan->status_proses) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ old('status_proses', $permohonan->status_proses) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ old('status_proses', $permohonan->status_proses) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="status_verifikasi" class="form-label fw-semibold">Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verifikasi" class="form-select" id="status_verifikasi" required>
                                <option value="Terverifikasi" {{ old('status_verifikasi', $permohonan->status_verifikasi) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="Menunggu" {{ old('status_verifikasi', $permohonan->status_verifikasi) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Belum Verifikasi" {{ old('status_verifikasi', $permohonan->status_verifikasi) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="ditugaskan" class="form-label fw-semibold">Ditugaskan Kepada</label>
                            <select name="ditugaskan" class="form-select" id="ditugaskan">
                                <option value="">-- Pilih Petugas --</option>
                                <option value="Rahmat Ikraldo Busyra" {{ old('ditugaskan', $permohonan->ditugaskan) == 'Rahmat Ikraldo Busyra' ? 'selected' : '' }}>Rahmat Ikraldo Busyra</option>
                                <option value="Jaka Prasetya" {{ old('ditugaskan', $permohonan->ditugaskan) == 'Jaka Prasetya' ? 'selected' : '' }}>Jaka Prasetya</option>
                                <option value="Wiendi Andriyani" {{ old('ditugaskan', $permohonan->ditugaskan) == 'Wiendi Andriyani' ? 'selected' : '' }}>Wiendi Andriyani</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}" {{ old('ditugaskan', $permohonan->ditugaskan) == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section 4: Checklist Tanda Terima Dokumen -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-card-checklist me-1"></i> Checklist Tanda Terima Dokumen</h6>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_sppt" value="1" id="check_sppt" {{ old('check_sppt', $permohonan->check_sppt) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_sppt">SPPT</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_skpt" value="1" id="check_skpt" {{ old('check_skpt', $permohonan->check_skpt) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_skpt">SKPT</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_pl" value="1" id="check_pl" {{ old('check_pl', $permohonan->check_pl) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_pl">PL</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_sp" value="1" id="check_sp" {{ old('check_sp', $permohonan->check_sp) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_sp">SP</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_skpl_sppl_lama" value="1" id="check_skpl_sppl_lama" {{ old('check_skpl_sppl_lama', $permohonan->check_skpl_sppl_lama) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_skpl_sppl_lama">SKPL & SPPL Lama</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="check_pl_lama" value="1" id="check_pl_lama" {{ old('check_pl_lama', $permohonan->check_pl_lama) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="check_pl_lama">PL Lama</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: Keterangan & File Upload -->
                        <div class="col-12 pt-3">
                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-paperclip me-1"></i> Catatan Petugas & Lampiran</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="keterangan_petugas" class="form-label fw-semibold">Keterangan Petugas</label>
                            <textarea name="keterangan_petugas" class="form-control" id="keterangan_petugas" rows="3">{{ old('keterangan_petugas', $permohonan->keterangan_petugas) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="file_tanda_terima" class="form-label fw-semibold">Ganti File Tanda Terima (Opsional)</label>
                            <input type="file" name="file_tanda_terima" class="form-control" id="file_tanda_terima">
                            @if($permohonan->file_tanda_terima)
                            <div class="mt-2 small text-muted">
                                File saat ini: <a href="{{ asset('storage/' . $permohonan->file_tanda_terima) }}" target="_blank" class="fw-semibold text-primary"><i class="bi bi-file-earmark-check me-1"></i>{{ basename($permohonan->file_tanda_terima) }}</a>
                            </div>
                            @endif
                        </div>

                        <!-- Submit Action Buttons -->
                        <div class="col-12 pt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('permohonan.index') }}" class="btn btn-light border px-4 rounded-pill">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">
                                <i class="bi bi-check-circle me-1"></i> Perbarui Permohonan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
