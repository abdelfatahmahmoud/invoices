<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class invoices extends Model
{

    use softDeletes;

protected $guarded =[];


    protected $dates = ['deleted_at'];

    public function section()
    {
        return $this->belongsTo('App\sections','section_id','id');
    }
/*
    protected $fillable=[

        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_commission',
        'discount',
        'rate_vat',
        'value_vat',
        'total',
        'status',
        'value_status',
        'note',

    ];
*/


}
