<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    public function calendars(){

      return $this->hasMany(Calendar::class);
    }
}
