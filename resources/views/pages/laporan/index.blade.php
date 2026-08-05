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

    <!-- Top Charts Row -->
    <div class="row g-4 mb-4">
        
        <!-- Widget 1: Rekap Status Proses Permohonan -->
        <div class="col-lg-8">
            <div class="laporan-card">
                <h5 class="laporan-card-title">Rekap status proses permohonan</h5>
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
    <div class="row">
        <div class="col-12">
            <div class="laporan-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="laporan-card-title m-0">Rekap produktivitas petugas</h5>
                    <span class="text-muted small">Berdasarkan jumlah checklist yang diverifikasi</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-laporan align-middle">
                        <thead>
                            <tr>
                                <th>PETUGAS</th>
                                <th>JABATAN</th>
                                <th class="text-center">TOTAL DIVERIFIKASI</th>
                                <th class="text-center">RATA-RATA KELENGKAPAN CHECKLIST</th>
                                <th class="text-center">STATUS AKUN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugasList as $petugas)
                            <tr>
                                <td class="fw-bold text-dark">{{ $petugas['name'] }}</td>
                                <td class="text-secondary small" style="max-width: 320px;">{{ $petugas['jabatan'] }}</td>
                                <td class="text-center">
                                    <span class="badge-count-pill">{{ $petugas['total_diverifikasi'] }}</span>
                                </td>
                                <td class="text-center fw-semibold text-dark">{{ $petugas['avg_checklist'] }}</td>
                                <td class="text-center">
                                    @if($petugas['is_active'])
                                        <span class="badge-status-aktif">Aktif</span>
                                    @else
                                        <span class="badge-status-nonaktif">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
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

    });
</script>
@endpush
