<div class="d-flex align-items-center justify-content-end gap-1">
    <!-- Tombol Pilih & Verifikasi Berkas -->
    <a href="{{ route('verifikasi.index', ['active_id' => $row->id]) }}" class="btn btn-sm btn-light border text-primary rounded-circle shadow-sm" title="Proses Verifikasi Berkas" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
        <i class="bi bi-check2-square"></i>
    </a>

    <!-- Tombol Edit Data Verifikasi -->
    <a href="{{ route('verifikasi.edit', $row->id) }}" class="btn btn-sm btn-light border text-secondary rounded-circle shadow-sm" title="Edit Verifikasi" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Tombol Hapus -->
    <form action="{{ route('verifikasi.destroy', $row->id) }}" method="POST" class="d-inline form-delete-verif-{{ $row->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-light border text-danger rounded-circle shadow-sm btn-delete-verif" data-id="{{ $row->id }}" data-name="{{ $row->no_registrasi }}" title="Hapus Data Verifikasi" style="width: 32px; height: 32px; padding: 0;">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
