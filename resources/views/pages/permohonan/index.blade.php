@extends('layouts.dashboard.template')

@section('content')
<style>
  .permohonan-header {
    margin-bottom: 1.5rem;
  }
  .permohonan-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.2rem;
  }
  .permohonan-subtitle {
    font-size: 0.875rem;
    color: #64748b;
  }
  .filter-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
    padding: 1.25rem;
    margin-bottom: 1.5rem;
  }
  .search-input-wrapper {
    position: relative;
    flex-grow: 1;
  }
  .search-input-wrapper i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1rem;
  }
  .search-input-wrapper input {
    padding-left: 2.5rem;
    border-radius: 50px;
    border: 1px solid #e2e8f0;
    font-size: 0.9rem;
    height: 42px;
  }
  .search-input-wrapper input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  }
  .filter-select {
    border-radius: 50px;
    border: 1px solid #e2e8f0;
    font-size: 0.875rem;
    height: 42px;
    padding-left: 1rem;
    padding-right: 2rem;
    color: #475569;
  }
  .filter-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
  }

  /* Custom DataTables Styling */
  #permohonan-table {
    border-collapse: separate;
    border-spacing: 0 8px;
  }
  #permohonan-table thead th {
    border: none;
    color: #64748b;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 12px 16px;
    background: transparent;
  }
  #permohonan-table tbody tr {
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
    transition: all 0.2s ease;
  }
  #permohonan-table tbody tr:hover {
    background-color: #f8fafc;
  }
  #permohonan-table tbody td {
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    padding: 14px 16px;
    vertical-align: middle;
  }
  #permohonan-table tbody tr td:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
    border-left: 1px solid #f1f5f9;
  }
  #permohonan-table tbody tr td:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
    border-right: 1px solid #f1f5f9;
  }

  /* Modal Styling matching Image 2 */
  .modal-custom-header {
    padding: 1.75rem 2rem 1rem 2rem;
    border-bottom: none;
  }
  .modal-pemohon-title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.2rem;
  }
  .modal-pemohon-sub {
    font-size: 0.875rem;
    color: #64748b;
  }
  .tab-nav-custom {
    border-bottom: 2px solid #e2e8f0;
    padding: 0 2rem;
  }
  .tab-nav-custom .nav-link {
    border: none;
    color: #64748b;
    font-weight: 600;
    padding: 0.75rem 1rem;
    position: relative;
  }
  .tab-nav-custom .nav-link.active {
    color: #0284c7;
    background: transparent;
  }
  .tab-nav-custom .nav-link.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: #0284c7;
    border-radius: 3px 3px 0 0;
  }
  .field-label {
    font-size: 0.725rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    margin-bottom: 0.25rem;
  }
  .field-value {
    font-size: 0.95rem;
    font-weight: 600;
    color: #0f172a;
  }
  .chk-card {
    border-radius: 12px;
    padding: 0.85rem 1rem;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.2s ease;
  }
  .chk-card.active {
    background-color: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
  }
  .chk-card.inactive {
    background-color: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
  }
  .chk-icon-circle {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
  }
  .chk-card.active .chk-icon-circle {
    background-color: #16a34a;
    color: #ffffff;
  }
  .chk-card.inactive .chk-icon-circle {
    background-color: #cbd5e1;
    color: #64748b;
  }
  .file-box {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 12px;
  }
</style>

<div class="container-fluid py-3">
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center permohonan-header">
        <div>
            <h1 class="permohonan-title">Data Permohonan</h1>
            <p class="permohonan-subtitle">Seluruh data hasil impor beserta status checklist</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light rounded-circle shadow-sm border p-2" title="Notifikasi">
                <i class="bi bi-bell text-secondary"></i>
            </button>
            <a href="{{ route('permohonan.create') }}" class="btn btn-light rounded-circle shadow-sm border p-2" title="Tambah Data Permohonan">
                <i class="bi bi-pencil-square text-primary"></i>
            </a>
            <a href="{{ route('permohonan.create') }}" class="btn btn-primary rounded-pill px-3 fw-semibold">
                <i class="bi bi-plus-lg me-1"></i> Tambah Permohonan
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

    <!-- Filter Toolbar matching Image 1 -->
    <div class="filter-card">
        <div class="row g-3 align-items-center">
            <div class="col-lg-5 col-md-6">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" id="custom-search" class="form-control" placeholder="Cari nama pemohon, no. registrasi, atau nomor PL...">
                </div>
            </div>
            <div class="col-lg-3 col-md-3">
                <select id="filter-status-proses" class="form-select filter-select">
                    <option value="">Semua status proses</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3">
                <select id="filter-status-verifikasi" class="form-select filter-select">
                    <option value="">Semua status verifikasi</option>
                    <option value="Terverifikasi">Terverifikasi</option>
                    <option value="Menunggu">Menunggu</option>
                </select>
            </div>
            <div class="col-lg-1 col-md-12 text-end">
                <span id="data-counter" class="text-muted small fw-medium text-nowrap">
                    {{ $totalCount }} dari {{ $totalCount }} total data
                </span>
            </div>
        </div>
    </div>

    <!-- DataTable Container -->
    <div class="table-responsive">
        {!! $dataTable->table(['class' => 'table align-middle w-100']) !!}
    </div>
</div>

<!-- Modal Detail Permohonan (Presisi sesuai Image 2) -->
<div class="modal fade" id="modalDetailPermohonan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            
            <!-- Modal Header -->
            <div class="modal-custom-header d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="modal-pemohon-title" id="detail-pemohon">-</h2>
                    <p class="modal-pemohon-sub mb-0">
                        No. Registrasi <span id="detail-no-registrasi" class="fw-bold text-dark">-</span> · 
                        <span id="detail-jenis-permohonan">-</span>
                    </p>
                </div>
                <button type="button" class="btn-close rounded-circle border p-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav tab-nav-custom">
                <li class="nav-item">
                    <button class="nav-link active" type="button">Data Impor</button>
                </li>
            </ul>

            <!-- Modal Body -->
            <div class="modal-body p-4 p-md-5">
                
                <!-- 2-Column Grid Fields -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="field-label">SURAT PERMOHONAN</div>
                        <div class="field-value" id="detail-surat-permohonan">-</div>
                    </div>
                    <div class="col-md-6">
                        <div class="field-label">STATUS PROSES</div>
                        <div id="detail-status-proses-container">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2" id="detail-status-proses">Diproses</span>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="field-label">NOMOR PL</div>
                        <div class="field-value" id="detail-nomor-pl">-</div>
                    </div>
                    <div class="col-md-6">
                        <div class="field-label">TANGGAL SURAT</div>
                        <div class="field-value" id="detail-tanggal-surat">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-label">NO SPJ/PPT</div>
                        <div class="field-value" id="detail-no-spj-ppt">-</div>
                    </div>
                    <div class="col-md-6">
                        <div class="field-label">NO SKEP/KPT</div>
                        <div class="field-value" id="detail-no-skep-kpt">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="field-label">NO REKOM</div>
                        <div class="field-value" id="detail-no-rekom">-</div>
                    </div>
                    <div class="col-md-6">
                        <div class="field-label">PEMBELI</div>
                        <div class="field-value" id="detail-pembeli">-</div>
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <!-- Checklist Tanda Terima Dokumen Section -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark m-0" style="font-size: 1.05rem;">Checklist tanda terima dokumen</h5>
                    <div class="d-flex align-items-center gap-2">
                        <span id="detail-checklist-summary" class="text-muted small fw-semibold">0/6 lengkap</span>
                        <span id="detail-verifikasi-badge" class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                            <i class="bi bi-check-lg me-1"></i>Terverifikasi
                        </span>
                    </div>
                </div>

                <!-- 6 Checklist Cards Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-sppt">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>SPPT</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-skpt">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>SKPT</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-pl">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>PL</span>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-sp">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>SP</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-skpl-sppl-lama">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>SKPL & SPPL Lama</span>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="chk-card" id="chk-pl-lama">
                            <span class="chk-icon-circle"><i class="bi bi-check-lg"></i></span>
                            <span>PL Lama</span>
                        </div>
                    </div>
                </div>

                <!-- Keterangan Petugas -->
                <div class="mb-4">
                    <div class="field-label">KETERANGAN PETUGAS</div>
                    <p class="text-dark small mb-0" id="detail-keterangan-petugas">
                        Dokumen lengkap, diserahkan langsung oleh pemohon.
                    </p>
                </div>

                <!-- Attachment Box -->
                <div class="file-box mb-2" id="detail-file-container">
                    <i class="bi bi-file-earmark-text text-primary fs-3"></i>
                    <div>
                        <div class="fw-bold text-dark small" id="detail-file-name">tanda-terima-EXT0420269900.jpg</div>
                        <div class="text-muted small" style="font-size: 0.775rem;">
                            diunggah oleh <span id="detail-uploader-name">Rahmat Ikraldo Busyra</span>
                        </div>
                    </div>
                    <a id="detail-file-link" href="#" target="_blank" class="ms-auto btn btn-sm btn-light border text-primary rounded-pill px-3">
                        <i class="bi bi-download me-1"></i> Unduh
                    </a>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light border rounded-3 px-4 py-2 text-dark fw-semibold" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function() {
            var table = window.LaravelDataTables["permohonan-table"];

            // Custom search binding
            $('#custom-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Custom Filter status_proses
            $('#filter-status-proses').on('change', function() {
                table.column(3).search(this.value).draw();
            });

            // Custom Filter status_verifikasi
            $('#filter-status-verifikasi').on('change', function() {
                table.column(5).search(this.value).draw();
            });

            // Update Counter Text on draw
            table.on('draw', function() {
                var info = table.page.info();
                $('#data-counter').text(info.recordsDisplay + ' dari ' + info.recordsTotal + ' total data');
            });

            // Handle Detail Modal View
            $(document).on('click', '.btn-detail', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ url('permohonan') }}/" + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.status === 'success') {
                            var data = response.data;
                            
                            $('#detail-pemohon').text(data.pemohon || '-');
                            $('#detail-no-registrasi').text(data.no_registrasi || '-');
                            $('#detail-jenis-permohonan').text(data.jenis_permohonan || '-');
                            $('#detail-surat-permohonan').text(data.surat_permohonan || '-');
                            $('#detail-nomor-pl').text(data.nomor_pl || '-');
                            $('#detail-no-spj-ppt').text(data.no_spj_ppt || '-');
                            $('#detail-no-rekom').text(data.no_rekom || '-');
                            $('#detail-no-skep-kpt').text(data.no_skep_kpt || '-');
                            $('#detail-pembeli').text(data.pembeli || '-');
                            $('#detail-tanggal-surat').text(response.tanggal_surat_formatted || '-');
                            $('#detail-keterangan-petugas').text(data.keterangan_petugas || 'Tidak ada keterangan petugas.');

                            // Status Proses Badge
                            var statusProsesClass = 'bg-primary-subtle text-primary border-primary-subtle';
                            if (data.status_proses && data.status_proses.toLowerCase() === 'selesai') {
                                statusProsesClass = 'bg-success-subtle text-success border-success-subtle';
                            } else if (data.status_proses && data.status_proses.toLowerCase() === 'ditolak') {
                                statusProsesClass = 'bg-danger-subtle text-danger border-danger-subtle';
                            }
                            $('#detail-status-proses-container').html('<span class="badge ' + statusProsesClass + ' border rounded-pill px-3 py-2">' + (data.status_proses || 'Diproses') + '</span>');

                            // Status Verifikasi Badge
                            var verifBadgeHtml = '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1">Menunggu</span>';
                            if (data.status_verifikasi && data.status_verifikasi.toLowerCase() === 'terverifikasi') {
                                verifBadgeHtml = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1"><i class="bi bi-check-lg me-1"></i>Terverifikasi</span>';
                            }
                            $('#detail-verifikasi-badge').replaceWith($(verifBadgeHtml).attr('id', 'detail-verifikasi-badge'));

                            // Checklist summary
                            $('#detail-checklist-summary').text(response.checklist_count + '/6 lengkap');

                            // Render Checklist Cards
                            setChkCard('#chk-sppt', data.check_sppt);
                            setChkCard('#chk-skpt', data.check_skpt);
                            setChkCard('#chk-pl', data.check_pl);
                            setChkCard('#chk-sp', data.check_sp);
                            setChkCard('#chk-skpl-sppl-lama', data.check_skpl_sppl_lama);
                            setChkCard('#chk-pl-lama', data.check_pl_lama);

                            // Render File Attachment
                            if (response.file_url) {
                                $('#detail-file-container').show();
                                $('#detail-file-name').text(response.file_basename);
                                $('#detail-uploader-name').text((data.uploaded_by_name || 'Petugas') + ', ' + response.tanggal_surat_formatted);
                                $('#detail-file-link').attr('href', response.file_url);
                            } else {
                                $('#detail-file-container').hide();
                            }

                            $('#modalDetailPermohonan').modal('show');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengambil data permohonan.', 'error');
                    }
                });
            });

            function setChkCard(selector, isChecked) {
                var card = $(selector);
                var icon = card.find('.chk-icon-circle i');
                if (isChecked) {
                    card.removeClass('inactive').addClass('active');
                    icon.attr('class', 'bi bi-check-lg');
                } else {
                    card.removeClass('active').addClass('inactive');
                    icon.attr('class', 'bi bi-dot');
                }
            }

            // Handle SweetAlert Delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var regNo = $(this).data('name') || 'permohonan ini';
                var form = $('.form-delete-' + id);

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda akan menghapus data permohonan " + regNo + ".",
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
