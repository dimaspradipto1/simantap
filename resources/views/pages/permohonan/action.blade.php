<div class="d-flex align-items-center justify-content-end gap-1">
    <!-- Tombol Detail / View Modal -->
    <button type="button" class="btn btn-sm btn-light border text-secondary rounded-circle shadow-sm btn-detail" data-id="{{ $row->id }}" title="Lihat Detail Permohonan" style="width: 32px; height: 32px; padding: 0;">
        <i class="bi bi-eye"></i>
    </button>

    <!-- Tombol Edit -->
    <a href="{{ route('permohonan.edit', $row->id) }}" class="btn btn-sm btn-light border text-primary rounded-circle shadow-sm" title="Edit Permohonan" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center;">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Tombol Hapus -->
    <form action="{{ route('permohonan.destroy', $row->id) }}" method="POST" class="d-inline form-delete-{{ $row->id }}">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-light border text-danger rounded-circle shadow-sm btn-delete" data-id="{{ $row->id }}" data-name="{{ $row->no_registrasi }}" title="Hapus Permohonan" style="width: 32px; height: 32px; padding: 0;">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
