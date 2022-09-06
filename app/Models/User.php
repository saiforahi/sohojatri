<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    use HasApiTokens;
    //
    protected $table="users";
    protected $guarded=[];
    protected $casts = [
        'email_verified_at' => 'datetime:Y-m-d h:i:s A',
        'created_at'=>'datetime:Y-m-d h:i:s A',
        'updated_at'=>'datetime:Y-m-d h:i:s A',
        'deleted_at'=>'datetime:Y-m-d h:i:s A'
    ];
}
