<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $fillable = [

        'remarks','customer','project','year','month_id','user_id',
        'official_start_time','official_end_time','official_break_time'];

    public function user(){

      return $this->belongsTo(User::class);
    }
}