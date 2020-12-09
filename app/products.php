<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{

    /*
    protected $fillable = [
        'product_name',
        'description',
        'section_id',
    ];
    */

    protected $guarded =[];


    public function sections(){
        return $this->belongsTo('App\sections','section_id','id');
    }
}
