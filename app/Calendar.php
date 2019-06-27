<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public function managements(){

      return $this->hasMany(Management::class);
    }
}
