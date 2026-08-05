<div class="d-inline-flex justify-content-center gap-1 text-nowrap">
    <form action="{{ route('import-data.destroy', $row->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-danger btn-delete" data-name="{{ $row->no_registrasi }}" title="Hapus Data">
            <i class="bi bi-trash"></i>
        </button>
    </form>
</div>
