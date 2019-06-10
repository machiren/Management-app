<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $fillable = [
        'date',
        'day',
        'weekday',
        'name',
        'employee_number',
        'opening_time',
        'ending_time',
        'break_time',
        'totle_time',
        'over_time',
        'paid_leave',
        'adsence',
        'late',
        'leave_early',
        'holiday_work',
        'makeup_holiday',
        'project',
        'memo'
    ];

    //アソシエーションの定義
    public function user(){
      return $this->belongsTo(User::class);
    }
}
