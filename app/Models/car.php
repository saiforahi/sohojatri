<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class car extends Model
{
    //
    protected $casts = [
        'created_at'=>'datetime:Y-m-d h:i:s A',
        'updated_at'=>'datetime:Y-m-d h:i:s A',
    ];
    public function brand(){
        return $this->hasOne(car_brand::class,'id','brand_id');
    }
}
