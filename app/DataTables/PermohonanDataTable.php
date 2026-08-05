<?php

namespace App\DataTables;

use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermohonanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Permohonan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('no_registrasi', function ($row) {
                $tgl = $row->tanggal_surat ? $row->tanggal_surat->format('j M Y') : '-';
                return '<div>
                            <div class="fw-bold text-dark">' . e($row->no_registrasi) . '</div>
                            <div class="text-muted small" style="font-size: 0.775rem;">' . e($tgl) . '</div>
                        </div>';
            })
            ->editColumn('pemohon', function ($row) {
                return '<span class="fw-semibold text-dark">' . e($row->pemohon) . '</span>';
            })
            ->editColumn('jenis_permohonan', function ($row) {
                return '<span class="text-secondary small">' . e($row->jenis_permohonan) . '</span>';
            })
            ->editColumn('status_proses', function ($row) {
                return match (strtolower($row->status_proses)) {
                    'selesai' => '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">Selesai</span>',
                    'diproses' => '<span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">Diproses</span>',
                    'ditolak' => '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2">Ditolak</span>',
                    default => '<span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">' . e($row->status_proses) . '</span>',
                };
            })
            ->addColumn('checklist', function ($row) {
                $checks = [
                    $row->check_sppt,
                    $row->check_sp,
                    $row->check_skpt,
                    $row->check_skpl_sppl_lama,
                    $row->check_pl,
                    $row->check_pl_lama,
                ];

                $completed = $row->checklist_count;
                $iconsHtml = '<div class="d-flex align-items-center gap-1 mb-1">';
                foreach ($checks as $isCheck) {
                    if ($isCheck) {
                        $iconsHtml .= '<span class="badge bg-success-subtle text-success p-1 px-2 rounded-2" style="font-size: 0.7rem;"><i class="bi bi-check-lg"></i></span>';
                    } else {
                        $iconsHtml .= '<span class="badge bg-light text-muted p-1 px-2 rounded-2" style="font-size: 0.7rem;">·</span>';
                    }
                }
                $iconsHtml .= '</div>';
                $iconsHtml .= '<div class="text-muted small" style="font-size: 0.75rem;">' . $completed . '/6 lengkap</div>';

                return $iconsHtml;
            })
            ->editColumn('status_verifikasi', function ($row) {
                if (strtolower($row->status_verifikasi) === 'terverifikasi') {
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2"><i class="bi bi-check-lg me-1"></i>Terverifikasi</span>';
                } elseif (str_contains(strtolower($row->status_verifikasi), 'menunggu')) {
                    $waktu = $row->waktu_menunggu ? '(' . $row->waktu_menunggu . ')' : '';
                    return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3 py-2">Menunggu ' . e($waktu) . '</span>';
                }
                return '<span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">' . e($row->status_verifikasi) . '</span>';
            })
            ->editColumn('ditugaskan', function ($row) {
                return '<span class="text-dark small fw-medium">' . e($row->ditugaskan ?? '-') . '</span>';
            })
            ->addColumn('action', function ($row) {
                return view('pages.permohonan.action', compact('row'))->render();
            })
            ->rawColumns(['no_registrasi', 'pemohon', 'jenis_permohonan', 'status_proses', 'checklist', 'status_verifikasi', 'ditugaskan', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Permohonan>
     */
    public function query(Permohonan $model): QueryBuilder
    {
        $query = $model->newQuery()->latest();

        // Custom Filter status_proses
        if (request()->has('status_proses') && request('status_proses') != '') {
            $query->where('status_proses', request('status_proses'));
        }

        // Custom Filter status_verifikasi
        if (request()->has('status_verifikasi') && request('status_verifikasi') != '') {
            if (request('status_verifikasi') === 'Menunggu') {
                $query->where('status_verifikasi', 'LIKE', '%Menunggu%');
            } else {
                $query->where('status_verifikasi', request('status_verifikasi'));
            }
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('permohonan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'desc')
                    ->selectStyleSingle()
                    ->parameters([
                        'dom' => 'rtip', // Clean custom layout control
                        'pageLength' => 10,
                        'language' => [
                            'emptyTable' => 'Tidak ada data permohonan tersedia',
                            'zeroRecords' => 'Data permohonan tidak ditemukan',
                            'info' => 'Menampilkan _START_ sampai _END_ dari _TOTAL_ total data',
                        ],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('no_registrasi')->title('NO. REGISTRASI'),
            Column::make('pemohon')->title('PEMOHON'),
            Column::make('jenis_permohonan')->title('JENIS PERMOHONAN'),
            Column::make('status_proses')->title('STATUS PROSES')->addClass('text-center'),
            Column::computed('checklist')->title('CHECKLIST'),
            Column::make('status_verifikasi')->title('STATUS VERIFIKASI')->addClass('text-center'),
            Column::make('ditugaskan')->title('DITUGASKAN'),
            Column::computed('action')
                  ->title('')
                  ->exportable(false)
                  ->printable(false)
                  ->width(110)
                  ->addClass('text-end'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Permohonan_' . date('YmdHis');
    }
}
