<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $fillable = [

        'opening_time','ending_time','break_time',
        'holiday_start_time','holiday_end_time','holiday_break_time',
        'holiday','adsence','late','leave_early','holiday_work',
        'makeup_holiday','project','memo','user_id','month_id',
        'calendar_id','created_at','updated_at','year'];


    public function user(){

      return $this->belongsTo(User::class);
    }

    public function month(){

      return $this->belongsTo(Month::class);
    }
}
