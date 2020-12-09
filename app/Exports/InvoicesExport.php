<?php

namespace App\Exports;

use App\invoices;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       // return invoices::all();
        return invoices::select('id','invoice_number',
            'invoice_date',
            'due_date',
            'product',
            'section_id',
            'Amount_collection',
            'Amount_commission',
            'discount',
            'rate_vat',
            'value_vat',
            'total')->get();
    }
}
