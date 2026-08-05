<div class="d-inline-flex justify-content-center gap-1 text-nowrap">
    <!-- Edit Button -->
    <a href="{{ route('users.edit', $row->id) }}" class="btn btn-sm btn-warning text-white" data-bs-toggle="tooltip" title="Edit">
        <i class="bi bi-pencil"></i>
    </a>

    <!-- Change Password Modal Trigger Button -->
    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#updatePasswordModal{{ $row->id }}" data-bs-toggle="tooltip" title="Ubah Password">
        <i class="bi bi-key"></i>
    </button>

    <!-- Delete Button Form -->
    @if(auth()->id() !== $row->id)
    <form action="{{ route('users.destroy', $row->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $row->name }}" data-bs-toggle="tooltip" title="Hapus User">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @endif
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="updatePasswordModal{{ $row->id }}" tabindex="-1" aria-labelledby="updatePasswordModalLabel{{ $row->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="updatePasswordModalLabel{{ $row->id }}">
                    <i class="bi bi-key-fill me-1"></i> Ubah Password - {{ $row->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.update-password', $row->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="password_{{ $row->id }}" class="form-label font-weight-bold">Password Baru</label>
                        <input type="password" class="form-control" id="password_{{ $row->id }}" name="password" placeholder="Masukkan password baru" required minlength="8">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation_{{ $row->id }}" class="form-label font-weight-bold">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="password_confirmation_{{ $row->id }}" name="password_confirmation" placeholder="Ulangi password baru" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
