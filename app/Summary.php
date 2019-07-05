<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $fillable = [

        'remarks','customer','project','official_strat_time',
        'official_end_time','official_bleak_time'];

    public function user(){

      return $this->belogsTo(User::class);
    }
}
