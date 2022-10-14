<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class popular_ride extends Model
{
    //
    protected $casts = [
        'created_at'=>'datetime:Y-m-d h:i:s A',
        'updated_at'=>'datetime:Y-m-d h:i:s A',
    ];
}
