<?php

namespace App\DataTables;

use App\Models\ImportData;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ImportDataDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ImportData> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('status', function ($row) {
                return match (strtolower($row->status)) {
                    'selesai' => '<span class="badge bg-success">Selesai</span>',
                    'diproses' => '<span class="badge bg-info text-dark">Diproses</span>',
                    default => '<span class="badge bg-secondary">' . e($row->status) . '</span>',
                };
            })
            ->editColumn('tgl_surat', function ($row) {
                return $row->tgl_surat ? $row->tgl_surat->format('d M Y') : '-';
            })
            ->editColumn('status_verifikasi', function ($row) {
                return '<span class="badge bg-warning text-dark">' . e($row->status_verifikasi) . '</span>';
            })
            ->addColumn('action', function ($row) {
                return view('pages.import.action', compact('row'))->render();
            })
            ->rawColumns(['status', 'status_verifikasi', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ImportData>
     */
    public function query(ImportData $model): QueryBuilder
    {
        return $model->newQuery()->latest();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('importdata-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(0, 'asc')
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex')
                  ->title('No')
                  ->exportable(false)
                  ->printable(false)
                  ->width(40)
                  ->addClass('text-center'),
            Column::make('no_registrasi')->title('NO. REGISTRASI'),
            Column::make('pemohon')->title('PEMOHON'),
            Column::make('jenis')->title('JENIS'),
            Column::make('status')->title('STATUS')->addClass('text-center'),
            Column::make('tgl_surat')->title('TGL SURAT')->addClass('text-center'),
            Column::make('status_verifikasi')->title('VALIDASI / VERIFIKASI')->addClass('text-center'),
            Column::computed('action')
                  ->title('AKSI')
                  ->exportable(false)
                  ->printable(false)
                  ->width(80)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ImportData_' . date('YmdHis');
    }
}
