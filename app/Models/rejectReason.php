<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rejectReason extends Model
{
 protected $table = "reject_reasons";
     protected $fillable = ['reject_message'];
}
