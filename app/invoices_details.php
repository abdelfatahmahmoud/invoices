<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $fillable = [

        'id_Invoice',
        'invoices_number',
         'products',
        'Section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'payment_date',

    ];

}
