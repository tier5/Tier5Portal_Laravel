<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttendenceLog extends Model
{
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
