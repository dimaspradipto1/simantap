@extends('layouts.dashboard.template')

@section('title', 'Dashboard - SIMANTAP | BP Batam')

@section('content')
<div class="pagetitle">
    <h1>Dashboard SIMANTAP</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<!-- Welcome Banner -->
<div class="card mb-4 border-0 shadow-sm rounded-3" style="background: linear-gradient(135deg, #0b132a 0%, #1e3a8a 100%); color: white;">
    <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-white bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                    <i class="bi bi-person-badge fs-2 text-warning"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold text-white">Selamat Datang, {{ auth()->user()->name }}!</h4>
                    <p class="mb-0 text-white-50 fs-7">
                        Satu Pintu Berkas Pertanahan Badan Pengusahaan Batam &bull; 
                        Role: <span class="badge bg-warning text-dark text-uppercase px-2 py-1 fs-8 fw-bold">{{ auth()->user()->role }}</span>
                    </p>
                </div>
            </div>
            <div class="text-end">
                <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 fs-7">
                    <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}
                </span>
            </div>
        </div>
    </div>
</div>

<section class="section dashboard">
    @if($role === 'admin')
        <!-- ==================== ADMIN DASHBOARD ==================== -->
        <!-- Stat Cards Row -->
        <div class="row g-3 mb-4">
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card sales-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Total Permohonan</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-files fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($totalPermohonan) }}</h3>
                                <span class="text-muted small pt-1">Berkas terdaftar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Menunggu Verifikasi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 48px; height: 48px;">
                                <i class="bi bi-clock-history fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($menungguVerifikasi) }}</h3>
                                <span class="text-warning small pt-1 fw-semibold">Antrean perlu diperiksa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Terverifikasi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 48px; height: 48px;">
                                <i class="bi bi-check-circle-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($terverifikasi) }}</h3>
                                <span class="text-success small pt-1 fw-semibold">Dokumen lengkap</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Pengguna Sistem</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info" style="width: 48px; height: 48px;">
                                <i class="bi bi-people-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($totalUser) }}</h3>
                                <span class="text-info small pt-1 fw-semibold">{{ $totalPetugas }} Petugas Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Analytics Row -->
        <div class="row g-3 mb-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title p-0 m-0 fw-bold text-dark fs-6">Distribusi Jenis Permohonan</h5>
                            <span class="badge bg-light text-dark fs-8">Visualisasi Layanan</span>
                        </div>
                        <div id="jenisPermohonanChart" style="min-height: 280px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title p-0 m-0 mb-3 fw-bold text-dark fs-6">Kelengkapan Checklist Dokumen</h5>
                        <div class="vstack gap-3 mt-3">
                            @foreach($checklistStats as $label => $count)
                                @php
                                    $percentage = $totalPermohonan > 0 ? round(($count / $totalPermohonan) * 100) : 0;
                                @endphp
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="fs-7 fw-semibold text-secondary">{{ $label }}</span>
                                        <span class="fs-7 fw-bold text-dark">{{ $count }} / {{ $totalPermohonan }} ({{ $percentage }}%)</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Table & Staff Workload Row -->
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title p-0 m-0 fw-bold text-dark fs-6">Permohonan Terbaru Masuk</h5>
                            <a href="{{ route('permohonan.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light fs-7">
                                    <tr>
                                        <th>No. Registrasi</th>
                                        <th>Pemohon</th>
                                        <th>Jenis Layanan</th>
                                        <th>Petugas</th>
                                        <th>Status Verifikasi</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="fs-7">
                                    @forelse($latestPermohonan as $item)
                                    <tr>
                                        <td class="fw-bold text-primary">{{ $item->no_registrasi }}</td>
                                        <td>{{ $item->pemohon }}</td>
                                        <td><span class="text-truncate d-inline-block" style="max-width: 180px;">{{ $item->jenis_permohonan }}</span></td>
                                        <td>{{ $item->assignedUser->name ?? $item->ditugaskan ?? '-' }}</td>
                                        <td>
                                            @if($item->status_verifikasi === 'Terverifikasi')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Terverifikasi</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Menunggu</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">Belum ada data permohonan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <h5 class="card-title p-0 m-0 mb-3 fw-bold text-dark fs-6">Beban Verifikasi Petugas</h5>
                        <div class="list-group list-group-flush">
                            @forelse($petugasList as $petugas)
                            <div class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold fs-7">{{ $petugas->name }}</h6>
                                        <small class="text-muted fs-8">{{ $petugas->email }}</small>
                                    </div>
                                </div>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-8">
                                    {{ $petugas->permohonans_count }} Antrean
                                </span>
                            </div>
                            @empty
                            <div class="text-muted text-center py-4 fs-7">Belum ada petugas terdaftar</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($role === 'petugas')
        <!-- ==================== PETUGAS DASHBOARD ==================== -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Tugas Saya</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-journal-check fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($myTotalTugas) }}</h3>
                                <span class="text-muted small pt-1">Berkas ditugaskan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Menunggu Verifikasi Saya</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 48px; height: 48px;">
                                <i class="bi bi-exclamation-triangle-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold text-warning">{{ number_format($myMenungguVerifikasi) }}</h3>
                                <span class="text-warning small pt-1 fw-semibold">Perlu tindakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Tugas Saya Terverifikasi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 48px; height: 48px;">
                                <i class="bi bi-patch-check-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold text-success">{{ number_format($myTerverifikasi) }}</h3>
                                <span class="text-success small pt-1">Selesai diverifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Total Antrean Sistem</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info" style="width: 48px; height: 48px;">
                                <i class="bi bi-inbox-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold text-info">{{ number_format($systemAntreanCount) }}</h3>
                                <span class="text-info small pt-1">Seluruh petugas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task List Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title p-0 m-0 fw-bold text-dark fs-6">Daftar Tugas Permohonan Saya</h5>
                    <a href="{{ route('verifikasi.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="bi bi-card-checklist me-1"></i> Buka Halaman Verifikasi
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light fs-7">
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Pemohon</th>
                                <th>Jenis Layanan</th>
                                <th>Checklist Kelengkapan</th>
                                <th>Status Verifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7">
                            @forelse($myTugasList as $task)
                            <tr>
                                <td class="fw-bold text-primary">{{ $task->no_registrasi }}</td>
                                <td>{{ $task->pemohon }}</td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 200px;">{{ $task->jenis_permohonan }}</span></td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-dark border px-2 py-1">
                                        {{ $task->checklist_count }} / 6 Dokumen
                                    </span>
                                </td>
                                <td>
                                    @if($task->status_verifikasi === 'Terverifikasi')
                                        <span class="badge bg-success px-2 py-1">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('verifikasi.index', ['active_id' => $task->id]) }}" class="btn btn-sm btn-outline-primary rounded-2 px-2 py-1 fs-8">
                                        <i class="bi bi-check2-square"></i> Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Tidak ada permohonan yang ditugaskan kepada Anda saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else
        <!-- ==================== USER / PEMOHON DASHBOARD ==================== -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Permohonan Saya</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary" style="width: 48px; height: 48px;">
                                <i class="bi bi-folder-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold">{{ number_format($myTotalPermohonan) }}</h3>
                                <span class="text-muted small pt-1">Berkas yang Anda ajukan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Sedang Diproses</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning" style="width: 48px; height: 48px;">
                                <i class="bi bi-hourglass-split fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold text-warning">{{ number_format($myDiproses) }}</h3>
                                <span class="text-warning small pt-1 fw-semibold">Dalam tahapan verifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <h5 class="card-title text-muted fs-7 mb-2">Selesai & Terverifikasi</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success" style="width: 48px; height: 48px;">
                                <i class="bi bi-check-circle-fill fs-3"></i>
                            </div>
                            <div class="ps-3">
                                <h3 class="mb-0 fw-bold text-success">{{ number_format($mySelesai) }}</h3>
                                <span class="text-success small pt-1">Berkas rampung</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title p-0 m-0 fw-bold text-dark fs-6">Riwayat Status Berkas Saya</h5>
                    <a href="{{ route('permohonan.index') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="bi bi-eye me-1"></i> Data Permohonan Complete
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light fs-7">
                            <tr>
                                <th>No. Registrasi</th>
                                <th>Pemohon</th>
                                <th>Jenis Layanan</th>
                                <th>Status Verifikasi</th>
                                <th>Status Proses</th>
                                <th>Tanggal Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody class="fs-7">
                            @forelse($myPermohonanList as $item)
                            <tr>
                                <td class="fw-bold text-primary">{{ $item->no_registrasi }}</td>
                                <td>{{ $item->pemohon }}</td>
                                <td>{{ $item->jenis_permohonan }}</td>
                                <td>
                                    @if($item->status_verifikasi === 'Terverifikasi')
                                        <span class="badge bg-success px-2 py-1">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-2 py-1">Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_proses === 'Selesai')
                                        <span class="badge bg-success px-2 py-1">Selesai</span>
                                    @else
                                        <span class="badge bg-info text-dark px-2 py-1">Diproses</span>
                                    @endif
                                </td>
                                <td>{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat permohonan atas nama Anda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</section>

@push('scripts')
@if($role === 'admin' && !empty($jenisPermohonanStats))
<script>
document.addEventListener("DOMContentLoaded", function () {
    const categories = {!! json_encode(array_keys($jenisPermohonanStats)) !!};
    const totals = {!! json_encode(array_values($jenisPermohonanStats)) !!};

    const options = {
        series: totals,
        chart: {
            type: 'donut',
            height: 280
        },
        labels: categories,
        colors: ['#2563eb', '#f59e0b', '#10b981', '#6366f1', '#ec4899'],
        legend: {
            position: 'bottom'
        },
        dataLabels: {
            enabled: true
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " Berkas";
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#jenisPermohonanChart"), options);
    chart.render();
});
</script>
@endif
@endpush
@endsection