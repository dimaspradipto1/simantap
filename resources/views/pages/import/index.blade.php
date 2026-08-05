@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Data Permohonan Impor</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Manajemen Data</li>
            <li class="breadcrumb-item active">Data Permohonan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-octagon me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 mt-3">
                        <h5 class="card-title m-0">Daftar Data Permohonan Impor</h5>
                        <a href="{{ route('import-data.create') }}" class="btn btn-primary">
                            <i class="bi bi-cloud-arrow-up me-1"></i> Import Data Baru
                        </a>
                    </div>

                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-striped table-hover align-middle w-100']) !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');
            let regNo = $(this).data('name') || 'data ini';

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Anda akan menghapus permohonan " + regNo + ".",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
