<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\InventoryReport;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $from;
    protected $to;

    public function __construct($from, $to) {
        $this->from = $from;
        $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $scheduleId = Schedule::whereBetween(DB::raw('DATE(`from`)'), [$this->from->format('Y-m-d'), $this->to->format('Y-m-d')])->pluck('id')->toArray();
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId)->get();
       
        return $rows;
    }

    public function map($row): array
    {
        return [
            $row->schedule->from->format('d-m-Y'),
            $row->schedule->shift->name,
            $row->product->line,
            $row->product->gtin,
            $row->product->name,
            $row->product->varian_pack,
            $row->qty,
            $row->pallet_qty,
            $row->total,
            $row->return_qty
        ];
    }

    public function headings(): array
    {
        return [
            'DATE',
            'SHIFT',
            'LINE',
            'BARCODE',
            'PRODUCT NAME',
            'PACKING VARIAN',
            'QTY',
            'PALLET',
            'ACCEPTED',
            'REJECTED'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
