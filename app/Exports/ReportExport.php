<?php

namespace App\Exports;

use App\Models\Schedule;
use App\Models\InventoryReport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $date;

    public function __construct($date) {
        $this->date = $date;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $scheduleId = Schedule::whereDate('from', $this->date)->pluck('id')->toArray();
        $rows = InventoryReport::with('schedule.shift', 'product')->whereIn('schedule_id', $scheduleId)->get();
       
        return $rows;
    }

    public function map($row): array
    {
        return [
            $row->created_at->format('d-m-Y'),
            $row->schedule->shift->name,
            $row->product->line,
            $row->product->gtin,
            $row->product->name,
            $row->qty
        ];
    }

    public function headings(): array
    {
        return [
            'DATE',
            'SHIFT',
            'LINE',
            'BARCODE',
            'SKU',
            'QTY'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
