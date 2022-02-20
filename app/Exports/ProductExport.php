<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select(['id', 'gtin', 'name', 'created_at'])->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'SKU',
            'NAME',
            'DATE ADDED'
        ];
    }
}
