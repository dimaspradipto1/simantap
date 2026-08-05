@extends('layouts.dashboard.template')

@section('content')
<style>
  .verif-header {
    margin-bottom: 1.5rem;
  }
  .verif-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.2rem;
  }
  .verif-subtitle {
    font-size: 0.875rem;
    color: #64748b;
  }
  .queue-card-list {
    max-height: calc(100vh - 240px);
    overflow-y: auto;
    padding-right: 6px;
  }
  .queue-item {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
  }
  .queue-item:hover {
    border-color: #f59e0b;
    background-color: #fffdfa;
    transform: translateX(2px);
  }
  .queue-item.active {
    border: 2px solid #d97706;
    background-color: #fffdfa;
    box-shadow: 0 4px 15px -3px rgba(245, 158, 11, 0.15);
  }
  .queue-name {
    font-weight: 700;
    font-size: 0.95rem;
    color: #0f172a;
    margin-bottom: 2px;
  }
  .queue-reg {
    font-size: 0.775rem;
    color: #94a3b8;
    margin-bottom: 6px;
  }
  .queue-officer {
    font-size: 0.75rem;
    color: #64748b;
  }
  .badge-wait {
    background-color: #fef3c7;
    color: #92400e;
    font-size: 0.725rem;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 12px;
    position: absolute;
    top: 14px;
    right: 14px;
  }

  /* Workspace Right Side */
  .workspace-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
  }
  .field-label-sm {
    font-size: 0.725rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #94a3b8;
    margin-bottom: 3px;
  }
  .field-value-sm {
    font-size: 0.925rem;
    font-weight: 700;
    color: #0f172a;
  }

  /* Document Checklist Item Card */
  .chk-item-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 0.85rem;
    transition: all 0.2s ease;
    cursor: pointer;
  }
  .chk-item-card:hover {
    border-color: #cbd5e1;
    background-color: #f8fafc;
  }
  .chk-item-card.checked {
    border-color: #10b981;
    background-color: #f0fdf4;
  }
  .chk-item-card .form-check-input {
    width: 22px;
    height: 22px;
    cursor: pointer;
  }
  .chk-item-card .form-check-input:checked {
    background-color: #10b981;
    border-color: #10b981;
  }
  .chk-title {
    font-weight: 700;
    font-size: 0.95rem;
    color: #0f172a;
    margin-bottom: 1px;
  }
  .chk-desc {
    font-size: 0.775rem;
    color: #64748b;
  }

  .dropzone-upload {
    border: 2px dashed #cbd5e1;
    border-radius: 14px;
    padding: 2.5rem 1.5rem;
    text-align: center;
    background-color: #f8fafc;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .dropzone-upload:hover {
    border-color: #f59e0b;
    background-color: #fffdfa;
  }

  .btn-gold-save {
    background: linear-gradient(135deg, #b45309 0%, #92400e 100%);
    color: #ffffff;
    font-weight: 700;
    border-radius: 12px;
    padding: 0.85rem 2rem;
    border: none;
    box-shadow: 0 4px 15px rgba(180, 83, 9, 0.25);
    transition: all 0.3s ease;
  }
  .btn-gold-save:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(180, 83, 9, 0.35);
    color: #ffffff;
  }

  .nav-tabs-custom {
    border-bottom: 2px solid #e2e8f0;
  }
  .nav-tabs-custom .nav-link {
    border: none;
    color: #64748b;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 0;
  }
  .nav-tabs-custom .nav-link.active {
    color: #d97706;
    border-bottom: 3px solid #d97706;
    background: transparent;
  }
</style>

<div class="container-fluid py-3">
    
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center verif-header">
        <div>
            <h1 class="verif-title">Verifikasi Checklist</h1>
            <p class="verif-subtitle">Centang dokumen, isi keterangan, unggah bukti tanda terima</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light rounded-circle shadow-sm border p-2" title="Notifikasi">
                <i class="bi bi-bell text-secondary"></i>
            </button>
            <a href="{{ route('verifikasi.create') }}" class="btn btn-light rounded-circle shadow-sm border p-2" title="Tambah Verifikasi Manual">
                <i class="bi bi-pencil-square text-primary"></i>
            </a>
            <a href="{{ route('verifikasi.create') }}" class="btn btn-primary rounded-pill px-3 fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Tambah Data Manual
            </a>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4" role="alert">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Mode Switch Tabs (Lembar Kerja Split vs Tabel DataTables) -->
    <ul class="nav nav-tabs nav-tabs-custom mb-4" id="verifTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="workspace-tab" data-bs-toggle="tab" data-bs-target="#workspace-pane" type="button" role="tab">
                <i class="bi bi-layout-split me-2"></i>Lembar Kerja Checklist Antrean
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="datatable-tab" data-bs-toggle="tab" data-bs-target="#datatable-pane" type="button" role="tab">
                <i class="bi bi-table me-2"></i>Tabel Data & Riwayat Verifikasi (DataTables)
            </button>
        </li>
    </ul>

    <div class="tab-content" id="verifTabsContent">
        
        <!-- TAB 1: LEMBAR KERJA ANTREAN SPLIT VIEW (PERSISIS GAMBAR REFERENSI) -->
        <div class="tab-pane fade show active" id="workspace-pane" role="tabpanel">
            <div class="row g-4">
                
                <!-- Left Sidebar Column: Antrean List -->
                <div class="col-lg-4 col-xl-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark m-0">Antrean ({{ $totalAntrean }})</h6>
                        <select class="form-select form-select-sm border-0 bg-light text-muted w-auto" style="font-size: 0.8rem;">
                            <option>Semua petugas</option>
                        </select>
                    </div>

                    <div class="queue-card-list">
                        @forelse($antreanList as $item)
                        <div class="queue-item {{ $activeItem && $activeItem->id == $item->id ? 'active' : '' }}" onclick="window.location.href='{{ route('verifikasi.index', ['active_id' => $item->id]) }}'">
                            <span class="badge-wait">{{ $item->waktu_menunggu ?? '0h' }}</span>
                            <div class="queue-name">{{ $item->pemohon }}</div>
                            <div class="queue-reg">{{ $item->no_registrasi }}</div>
                            <div class="queue-officer">
                                Ditugaskan: <span class="fw-medium text-dark">{{ $item->ditugaskan ?? 'Petugas' }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 text-center text-muted bg-white rounded-3 border">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            Tidak ada antrean verifikasi.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Workspace Column: Detail & Form Checklist -->
                <div class="col-lg-8 col-xl-9">
                    @if($activeItem)
                    <div class="workspace-card">
                        
                        <!-- Header Active Item -->
                        <div class="d-flex justify-content-between align-items-start mb-4">
                            <div>
                                <h2 class="fw-bold text-dark m-0" style="font-size: 1.6rem;">{{ $activeItem->pemohon }}</h2>
                                <p class="text-muted small mt-1 mb-0">
                                    No. Registrasi <span class="fw-bold text-dark">{{ $activeItem->no_registrasi }}</span> · 
                                    <span>{{ $activeItem->jenis_permohonan ?? 'Pelayanan Perpanjangan Hak Atas Tanah' }}</span>
                                </p>
                            </div>
                            <div>
                                @if(strtolower($activeItem->status_verifikasi) == 'terverifikasi')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2 fs-6">
                                        <i class="bi bi-check-lg me-1"></i>Terverifikasi
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2 fs-6">
                                        Menunggu ({{ $activeItem->waktu_menunggu ?? '0h' }})
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 4 Fields Metadata Grid -->
                        <div class="row g-3 mb-4 p-3 rounded-3 bg-light border">
                            <div class="col-md-3 col-6">
                                <div class="field-label-sm">NOMOR PL</div>
                                <div class="field-value-sm">{{ $activeItem->permohonan->nomor_pl ?? '226.97.96040000.B1.002' }}</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="field-label-sm">TANGGAL SURAT</div>
                                <div class="field-value-sm">{{ $activeItem->permohonan->tanggal_surat ? $activeItem->permohonan->tanggal_surat->format('j M Y') : '5 Agu 2026' }}</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="field-label-sm">NO SPJ/PPT</div>
                                <div class="field-value-sm">{{ $activeItem->permohonan->no_spj_ppt ?? '7002/A2.3/L/6/2026' }}</div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="field-label-sm">NO SKEP/KPT</div>
                                <div class="field-value-sm">{{ $activeItem->permohonan->no_skep_kpt ?? '6302/A2.3/L/6/2026' }}</div>
                            </div>
                        </div>

                        <!-- Form Verification Update -->
                        <form action="{{ route('verifikasi.update', $activeItem->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="no_registrasi" value="{{ $activeItem->no_registrasi }}">
                            <input type="hidden" name="pemohon" value="{{ $activeItem->pemohon }}">
                            <input type="hidden" name="jenis_permohonan" value="{{ $activeItem->jenis_permohonan }}">
                            <input type="hidden" name="status_verifikasi" value="Terverifikasi">
                            <input type="hidden" name="ditugaskan" value="{{ $activeItem->ditugaskan }}">

                            <!-- Section Title -->
                            <div class="field-label-sm mb-3">CHECKLIST DOKUMEN TANDA TERIMA</div>

                            <!-- 6 Document Cards Stack -->
                            <!-- 1. SPPT -->
                            <div class="chk-item-card {{ $activeItem->check_sppt ? 'checked' : '' }}" onclick="toggleCheckbox('check_sppt', this)">
                                <input class="form-check-input" type="checkbox" name="check_sppt" value="1" id="check_sppt" {{ $activeItem->check_sppt ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">SPPT</div>
                                    <div class="chk-desc">Surat Pemberitahuan Pajak Terhutang</div>
                                </div>
                            </div>

                            <!-- 2. SKPT -->
                            <div class="chk-item-card {{ $activeItem->check_skpt ? 'checked' : '' }}" onclick="toggleCheckbox('check_skpt', this)">
                                <input class="form-check-input" type="checkbox" name="check_skpt" value="1" id="check_skpt" {{ $activeItem->check_skpt ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">SKPT</div>
                                    <div class="chk-desc">Surat Keterangan Tanah</div>
                                </div>
                            </div>

                            <!-- 3. PL -->
                            <div class="chk-item-card {{ $activeItem->check_pl ? 'checked' : '' }}" onclick="toggleCheckbox('check_pl', this)">
                                <input class="form-check-input" type="checkbox" name="check_pl" value="1" id="check_pl" {{ $activeItem->check_pl ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">PL</div>
                                    <div class="chk-desc">Peta Lokasi</div>
                                </div>
                            </div>

                            <!-- 4. SP -->
                            <div class="chk-item-card {{ $activeItem->check_sp ? 'checked' : '' }}" onclick="toggleCheckbox('check_sp', this)">
                                <input class="form-check-input" type="checkbox" name="check_sp" value="1" id="check_sp" {{ $activeItem->check_sp ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">SP</div>
                                    <div class="chk-desc">Surat Permohonan</div>
                                </div>
                            </div>

                            <!-- 5. SKPL & SPPL Lama -->
                            <div class="chk-item-card {{ $activeItem->check_skpl_sppl_lama ? 'checked' : '' }}" onclick="toggleCheckbox('check_skpl_sppl_lama', this)">
                                <input class="form-check-input" type="checkbox" name="check_skpl_sppl_lama" value="1" id="check_skpl_sppl_lama" {{ $activeItem->check_skpl_sppl_lama ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">SKPL & SPPL Lama</div>
                                    <div class="chk-desc">Dokumen periode sebelumnya</div>
                                </div>
                            </div>

                            <!-- 6. PL Lama -->
                            <div class="chk-item-card {{ $activeItem->check_pl_lama ? 'checked' : '' }}" onclick="toggleCheckbox('check_pl_lama', this)">
                                <input class="form-check-input" type="checkbox" name="check_pl_lama" value="1" id="check_pl_lama" {{ $activeItem->check_pl_lama ? 'checked' : '' }}>
                                <div>
                                    <div class="chk-title">PL Lama</div>
                                    <div class="chk-desc">Peta lokasi periode sebelumnya</div>
                                </div>
                            </div>

                            <!-- Keterangan Textarea -->
                            <div class="mb-4 mt-4">
                                <label for="keterangan" class="field-label-sm">Keterangan (opsional)</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="mb. dokumen lengkap, diserahkan langsung oleh pemohon...">{{ old('keterangan', $activeItem->keterangan ?? 'Dokumen lengkap, diserahkan langsung oleh pemohon.') }}</textarea>
                            </div>

                            <!-- Bukti Tanda Terima File Upload Dropzone -->
                            <div class="mb-4">
                                <label class="field-label-sm">Bukti tanda terima (foto/scan yang telah ditandatangani)</label>
                                <div class="dropzone-upload" onclick="document.getElementById('bukti_tanda_terima_input').click()">
                                    <i class="bi bi-cloud-arrow-up fs-2 text-warning mb-2 d-block"></i>
                                    <div class="fw-bold text-dark mb-1" id="upload-label-text">Klik untuk unggah bukti tanda terima</div>
                                    <div class="text-muted small">JPG, PNG, WEBP, PDF — maks. 10MB</div>
                                    <input type="file" name="bukti_tanda_terima" id="bukti_tanda_terima_input" class="d-none" accept=".jpg,.jpeg,.png,.webp,.pdf" onchange="showFileName(this)">
                                </div>
                                @if($activeItem->bukti_tanda_terima)
                                <div class="mt-2 text-success small fw-semibold">
                                    <i class="bi bi-file-earmark-check me-1"></i> File terunggah: <a href="{{ asset('storage/' . $activeItem->bukti_tanda_terima) }}" target="_blank" class="text-success text-decoration-underline">{{ basename($activeItem->bukti_tanda_terima) }}</a>
                                </div>
                                @endif
                            </div>

                            <!-- Bottom Submit Action Bar -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <div class="text-muted small fw-semibold" id="counter-text">
                                    {{ $activeItem->checklist_count }}/6 dokumen dicentang
                                </div>

                                <button type="submit" class="btn btn-gold-save">
                                    Simpan & tandai terverifikasi
                                </button>
                            </div>

                        </form>

                    </div>
                    @else
                    <div class="workspace-card text-center py-5">
                        <i class="bi bi-check-circle fs-1 text-muted mb-3 d-block"></i>
                        <h4 class="fw-bold text-dark mb-2">Pilih Antrean Permohonan</h4>
                        <p class="text-muted small">Silakan pilih salah satu data pemohon dari daftar antrean di sebelah kiri untuk mulai melakukan verifikasi checklist berkas.</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- TAB 2: YAJRA DATATABLES VIEW (SYARAT WAJIB DATATABLES) -->
        <div class="tab-pane fade" id="datatable-pane" role="tabpanel">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0">Riwayat & Daftar Verifikasi Berkas</h5>
                    <a href="{{ route('verifikasi.create') }}" class="btn btn-primary rounded-pill px-3">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Verifikasi Baru
                    </a>
                </div>
                <div class="table-responsive">
                    {!! $dataTable->table(['class' => 'table align-middle w-100']) !!}
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        function toggleCheckbox(inputId, cardElement) {
            var input = document.getElementById(inputId);
            if (event.target !== input) {
                input.checked = !input.checked;
            }
            if (input.checked) {
                cardElement.classList.add('checked');
            } else {
                cardElement.classList.remove('checked');
            }
            updateChecklistCounter();
        }

        function updateChecklistCounter() {
            var checkboxes = document.querySelectorAll('.chk-item-card input[type="checkbox"]');
            var count = 0;
            checkboxes.forEach(function(cb) {
                if (cb.checked) count++;
            });
            var counterEl = document.getElementById('counter-text');
            if (counterEl) {
                counterEl.innerText = count + '/6 dokumen dicentang';
            }
        }

        function showFileName(input) {
            if (input.files && input.files[0]) {
                var fileName = input.files[0].name;
                document.getElementById('upload-label-text').innerText = 'File dipilih: ' + fileName;
            }
        }

        $(document).ready(function() {
            // Delete confirmation with SweetAlert for Verifikasi DataTable
            $(document).on('click', '.btn-delete-verif', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var regNo = $(this).data('name') || 'data ini';
                var form = $('.form-delete-verif-' + id);

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda akan menghapus data verifikasi " + regNo + ".",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
