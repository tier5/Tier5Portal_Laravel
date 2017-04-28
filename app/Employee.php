<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  	public function user()
  	{
  		return $this->belongsTo(User::class);
  	}

  	public function events()
  	{
  		return $this->hasMany(Event::class);
  	}

  	public function eoms()
  	{
  		return $this->hasMany(EmployeeOfTheMonth::class);
  	}
    public function holidays()
    {
      return $this->hasMany(Holiday::class);
    }
}
