<?php

namespace App\Models;

use App\Models\post_ride;
use Illuminate\Database\Eloquent\Model;

class stopover extends Model
{
    //
    protected $casts = [
        'created_at'=>'datetime:Y-m-d h:i:s A',
        'updated_at'=>'datetime:Y-m-d h:i:s A',
    ];

    public function post_ride(){
        return $this->belongsTo(post_ride::class);
    }
}
