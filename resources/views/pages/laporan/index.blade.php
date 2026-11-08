@extends('layouts.dashboard.template')

@section('content')
<style>
  .laporan-header {
    margin-bottom: 1.5rem;
  }
  .laporan-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.2rem;
  }
  .laporan-subtitle {
    font-size: 0.875rem;
    color: #64748b;
  }
  .laporan-card {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
    padding: 1.5rem;
    height: 100%;
  }
  .laporan-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 1.25rem;
  }
  .filter-panel {
    background: #ffffff;
    border-radius: 18px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
  }
  .badge-count-pill {
    background-color: #f1f5f9;
    color: #0284c7;
    font-weight: 700;
    border-radius: 50px;
    padding: 4px 12px;
    font-size: 0.85rem;
  }
  .badge-status-aktif {
    background-color: #dcfce7;
    color: #15803d;
    font-weight: 600;
    border-radius: 50px;
    padding: 4px 14px;
    font-size: 0.775rem;
  }
  .badge-status-nonaktif {
    background-color: #f1f5f9;
    color: #64748b;
    font-weight: 600;
    border-radius: 50px;
    padding: 4px 14px;
    font-size: 0.775rem;
  }
  .table-laporan thead th {
    font-size: 0.725rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    color: #64748b;
    text-transform: uppercase;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
  }
  .table-laporan tbody td {
    padding: 16px;
    vertical-align: middle;
    font-size: 0.875rem;
    color: #334155;
    border-bottom: 1px solid #f1f5f9;
  }
  .btn-preset {
    border-radius: 50px;
    font-size: 0.8rem;
    padding: 4px 12px;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .btn-preset:hover, .btn-preset.active {
    background: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
  }
  .sort-header-link {
    color: #64748b;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .sort-header-link:hover {
    color: #0284c7;
  }
</style>

<div class="container-fluid py-3">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center laporan-header">
        <div>
            <h1 class="laporan-title">Laporan</h1>
            <p class="laporan-subtitle">Rekap status proses, verifikasi, dan produktivitas petugas</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light rounded-circle shadow-sm border p-2" title="Notifikasi">
                <i class="bi bi-bell text-secondary"></i>
            </button>
            <button class="btn btn-light rounded-circle shadow-sm border p-2" title="Pengaturan Laporan">
                <i class="bi bi-pencil-square text-primary"></i>
            </button>
        </div>
    </div>

    <!-- Filter & Sorting by Date Section -->
    <div class="filter-panel">
        <form method="GET" action="{{ route('laporan.index') }}" id="filter-laporan-form">
            <div class="row g-3 align-items-end">
                <!-- Tanggal Mulai -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold text-secondary mb-1">
                        <i class="bi bi-calendar-event me-1 text-primary"></i> Tanggal Mulai
                    </label>
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm rounded-3" value="{{ $startDate ?? '' }}">
                </div>

                <!-- Tanggal Selesai -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold text-secondary mb-1">
                        <i class="bi bi-calendar-check me-1 text-primary"></i> Tanggal Selesai
                    </label>
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm rounded-3" value="{{ $endDate ?? '' }}">
                </div>

                <!-- Sorting Option -->
                <div class="col-md-3 col-sm-6">
                    <label class="form-label small fw-semibold text-secondary mb-1">
                        <i class="bi bi-sort-down me-1 text-primary"></i> Urutkan Laporan Berdasarkan
                    </label>
                    <select name="sort_by" id="sort_by" class="form-select form-select-sm rounded-3">
                        <option value="diverifikasi_desc" {{ ($sortBy ?? '') === 'diverifikasi_desc' ? 'selected' : '' }}>Total Diverifikasi Terbanyak</option>
                        <option value="date_desc" {{ ($sortBy ?? '') === 'date_desc' ? 'selected' : '' }}>Tanggal Terbaru (Terakhir)</option>
                        <option value="date_asc" {{ ($sortBy ?? '') === 'date_asc' ? 'selected' : '' }}>Tanggal Terlama (Awal)</option>
                        <option value="name_asc" {{ ($sortBy ?? '') === 'name_asc' ? 'selected' : '' }}>Nama Petugas (A-Z)</option>
                        <option value="checklist_desc" {{ ($sortBy ?? '') === 'checklist_desc' ? 'selected' : '' }}>Kelengkapan Checklist Tertinggi</option>
                    </select>
                </div>

                <!-- Tombol Action -->
                <div class="col-md-3 col-sm-6 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3 flex-grow-1">
                        <i class="bi bi-funnel me-1"></i> Terapkan
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-light border rounded-pill px-3" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>

            <!-- Quick Presets -->
            <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-2 border-top">
                <span class="small text-muted me-1"><i class="bi bi-clock-history me-1"></i>Periode Cepat:</span>
                <button type="button" class="btn-preset" onclick="setPresetDate('all')">Semua Waktu</button>
                <button type="button" class="btn-preset" onclick="setPresetDate('today')">Hari Ini</button>
                <button type="button" class="btn-preset" onclick="setPresetDate('7days')">7 Hari Terakhir</button>
                <button type="button" class="btn-preset" onclick="setPresetDate('this_month')">Bulan Ini</button>
                <button type="button" class="btn-preset" onclick="setPresetDate('this_year')">Tahun Ini</button>

                @if($startDate || $endDate || ($sortBy && $sortBy !== 'diverifikasi_desc'))
                <div class="ms-auto">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 small">
                        <i class="bi bi-check-circle me-1"></i>
                        Filter Aktif: 
                        {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('d M Y') : 'Awal' }} s/d {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('d M Y') : 'Sekarang' }}
                        @if($sortBy === 'date_desc') • Urut Tanggal Terbaru @elseif($sortBy === 'date_asc') • Urut Tanggal Terlama @endif
                    </span>
                </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Top Charts Row -->
    <div class="row g-4 mb-4">
        
        <!-- Widget 1: Rekap Status Proses Permohonan -->
        <div class="col-lg-8">
            <div class="laporan-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="laporan-card-title m-0">Rekap status proses permohonan</h5>
                    <span class="text-muted small">Total: <strong>{{ $totalPermohonan }}</strong> berkas</span>
                </div>
                <div id="chart-status-proses" style="min-height: 280px;"></div>
            </div>
        </div>

        <!-- Widget 2: Rekap Status Verifikasi -->
        <div class="col-lg-4">
            <div class="laporan-card">
                <h5 class="laporan-card-title">Rekap status verifikasi</h5>
                <div class="d-flex align-items-center justify-content-center h-100 pb-3">
                    <div id="chart-status-verifikasi" style="width: 100%; min-height: 240px;"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Widget 3: Rekap Produktivitas Petugas Table -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="laporan-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="laporan-card-title m-0">Rekap produktivitas petugas</h5>
                        <span class="text-muted small">Berdasarkan jumlah checklist yang diverifikasi dalam periode terpilih</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted small d-none d-md-inline">Urutkan:</span>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('laporan.index', array_merge(request()->query(), ['sort_by' => 'diverifikasi_desc'])) }}" 
                               class="btn {{ ($sortBy ?? 'diverifikasi_desc') === 'diverifikasi_desc' ? 'btn-primary' : 'btn-light border' }}" 
                               title="Urutkan Jumlah Diverifikasi">
                                <i class="bi bi-bar-chart-fill me-1"></i> Terbanyak
                            </a>
                            <a href="{{ route('laporan.index', array_merge(request()->query(), ['sort_by' => 'date_desc'])) }}" 
                               class="btn {{ ($sortBy ?? '') === 'date_desc' ? 'btn-primary' : 'btn-light border' }}" 
                               title="Urutkan Tanggal Aktivitas Terbaru">
                                <i class="bi bi-calendar-arrow-down me-1"></i> Tanggal Terbaru
                            </a>
                            <a href="{{ route('laporan.index', array_merge(request()->query(), ['sort_by' => 'date_asc'])) }}" 
                               class="btn {{ ($sortBy ?? '') === 'date_asc' ? 'btn-primary' : 'btn-light border' }}" 
                               title="Urutkan Tanggal Aktivitas Terlama">
                                <i class="bi bi-calendar-arrow-up me-1"></i> Tanggal Terlama
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-laporan align-middle">
                        <thead>
                            <tr>
                                <th>PETUGAS</th>
                                <th>JABATAN</th>
                                <th class="text-center">
                                    <a href="{{ route('laporan.index', array_merge(request()->query(), ['sort_by' => ($sortBy === 'diverifikasi_desc' ? 'diverifikasi_asc' : 'diverifikasi_desc')])) }}" class="sort-header-link">
                                        TOTAL DIVERIFIKASI
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    </a>
                                </th>
                                <th class="text-center">RATA-RATA KELENGKAPAN CHECKLIST</th>
                                <th class="text-center">
                                    <a href="{{ route('laporan.index', array_merge(request()->query(), ['sort_by' => ($sortBy === 'date_desc' ? 'date_asc' : 'date_desc')])) }}" class="sort-header-link">
                                        TANGGAL AKTIVITAS TERAKHIR
                                        <i class="bi bi-arrow-down-up text-muted"></i>
                                    </a>
                                </th>
                                <th class="text-center">STATUS AKUN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($petugasList as $petugas)
                            <tr>
                                <td class="fw-bold text-dark">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                            {{ strtoupper(substr($petugas['name'], 0, 1)) }}
                                        </div>
                                        <span>{{ $petugas['name'] }}</span>
                                    </div>
                                </td>
                                <td class="text-secondary small" style="max-width: 300px;">{{ $petugas['jabatan'] }}</td>
                                <td class="text-center">
                                    <span class="badge-count-pill">{{ $petugas['total_diverifikasi'] }}</span>
                                </td>
                                <td class="text-center fw-semibold text-dark">{{ $petugas['avg_checklist'] }}</td>
                                <td class="text-center">
                                    @if($petugas['latest_date'] !== '-')
                                        <span class="badge bg-light text-dark border px-2 py-1 small">
                                            <i class="bi bi-calendar2-check me-1 text-primary"></i>{{ $petugas['latest_date'] }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($petugas['is_active'])
                                        <span class="badge-status-aktif">Aktif</span>
                                    @else
                                        <span class="badge-status-nonaktif">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada data petugas pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Widget 4: Rincian Data Laporan Permohonan (Sorting by Date) -->
    <div class="row">
        <div class="col-12">
            <div class="laporan-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="laporan-card-title m-0">Rincian Data Laporan Permohonan</h5>
                        <span class="text-muted small">Daftar transaksi permohonan dalam periode terpilih, dapat diurutkan berdasarkan tanggal secara interaktif</span>
                    </div>
                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-1">
                        {{ $permohonanList->count() }} Data Ditemukan
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-laporan align-middle" id="table-rincian-laporan">
                        <thead>
                            <tr>
                                <th>NO. REGISTRASI</th>
                                <th>PEMOHON</th>
                                <th>JENIS PERMOHONAN</th>
                                <th class="text-center">TANGGAL SURAT</th>
                                <th class="text-center">STATUS PROSES</th>
                                <th class="text-center">STATUS VERIFIKASI</th>
                                <th>PETUGAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permohonanList as $item)
                            <tr>
                                <td class="fw-bold text-dark">{{ $item->no_registrasi }}</td>
                                <td class="text-dark fw-medium">{{ $item->pemohon }}</td>
                                <td class="text-secondary small">{{ $item->jenis_permohonan }}</td>
                                <td class="text-center" data-order="{{ $item->tanggal_surat ? $item->tanggal_surat->timestamp : ($item->created_at ? $item->created_at->timestamp : 0) }}">
                                    @if($item->tanggal_surat)
                                        <span class="badge bg-light text-dark border px-2 py-1 small">
                                            <i class="bi bi-calendar3 me-1 text-primary"></i>{{ $item->tanggal_surat->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(strtolower($item->status_proses) === 'selesai')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">Selesai</span>
                                    @elseif(strtolower($item->status_proses) === 'diproses')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">Diproses</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1">{{ $item->status_proses }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(strtolower($item->status_verifikasi) === 'terverifikasi')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1"><i class="bi bi-check-lg me-1"></i>Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-1">Menunggu</span>
                                    @endif
                                </td>
                                <td class="text-secondary small">{{ $item->ditugaskan ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Tidak ada data permohonan yang sesuai dengan filter tanggal.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Quick Preset Date Helper
    function setPresetDate(type) {
        var startInput = document.getElementById('start_date');
        var endInput = document.getElementById('end_date');
        var form = document.getElementById('filter-laporan-form');
        var now = new Date();

        function formatDate(d) {
            var month = '' + (d.getMonth() + 1);
            var day = '' + d.getDate();
            var year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        if (type === 'all') {
            startInput.value = '';
            endInput.value = '';
        } else if (type === 'today') {
            var todayStr = formatDate(now);
            startInput.value = todayStr;
            endInput.value = todayStr;
        } else if (type === '7days') {
            var pastDate = new Date();
            pastDate.setDate(now.getDate() - 7);
            startInput.value = formatDate(pastDate);
            endInput.value = formatDate(now);
        } else if (type === 'this_month') {
            var firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            var lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            startInput.value = formatDate(firstDay);
            endInput.value = formatDate(lastDay);
        } else if (type === 'this_year') {
            var firstDayYear = new Date(now.getFullYear(), 0, 1);
            var lastDayYear = new Date(now.getFullYear(), 11, 31);
            startInput.value = formatDate(firstDayYear);
            endInput.value = formatDate(lastDayYear);
        }

        form.submit();
    }

    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Render Bar Chart - Rekap Status Proses Permohonan
        var optionsProses = {
            series: [{
                name: 'Jumlah Permohonan',
                data: [{{ $selesaiCount }}, {{ $diprosesCount }}, {{ $pendingCount }}]
            }],
            chart: {
                type: 'bar',
                height: 250,
                toolbar: { show: false }
            },
            colors: ['#10b981', '#2563eb', '#d97706'],
            plotOptions: {
                bar: {
                    columnWidth: '22%',
                    borderRadius: 6,
                    distributed: true,
                    dataLabels: { position: 'top' }
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -22,
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold',
                    colors: ['#0f172a']
                }
            },
            legend: { show: false },
            xaxis: {
                categories: ['Selesai', 'Diproses', 'Pending'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '13px',
                        fontWeight: 600
                    }
                }
            },
            yaxis: { show: false },
            grid: { show: false }
        };

        var chartProses = new ApexCharts(document.querySelector("#chart-status-proses"), optionsProses);
        chartProses.render();


        // 2. Render Donut Chart - Rekap Status Verifikasi
        var optionsVerifikasi = {
            series: [{{ $terverifikasiCount }}, {{ $belumVerifikasiCount }}],
            chart: {
                type: 'donut',
                height: 240
            },
            labels: ['Sudah Diverifikasi', 'Belum Diverifikasi'],
            colors: ['#10b981', '#3b82f6'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'total',
                                fontSize: '12px',
                                color: '#94a3b8',
                                formatter: function () {
                                    return '{{ $totalPermohonan }}';
                                }
                            },
                            value: {
                                fontSize: '22px',
                                fontWeight: 'bold',
                                color: '#0f172a'
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'right',
                fontSize: '13px',
                markers: { radius: 12 },
                itemMargin: { vertical: 6 }
            },
            dataLabels: { enabled: false }
        };

        var chartVerifikasi = new ApexCharts(document.querySelector("#chart-status-verifikasi"), optionsVerifikasi);
        chartVerifikasi.render();

        // 3. Initialize DataTables for Rincian Laporan Table with default sorting by Date (Column Index 3, Descending)
        if ($('#table-rincian-laporan').length && $.fn.DataTable) {
            $('#table-rincian-laporan').DataTable({
                order: [[3, 'desc']], // Default sorting by Tanggal Surat descending
                pageLength: 10,
                language: {
                    search: "Cari data permohonan:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data permohonan",
                    infoEmpty: "Menampilkan 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data permohonan yang sesuai",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        }

    });
</script>
@endpush
