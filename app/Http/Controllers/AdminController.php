<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Management;
use App\Month;
use App\Calendar;
use App\Summary;


class AdminController extends Controller
{
    public function member_list(){
      $member_list = User::all();
      
      return view('admin.memberList', ['member_list'=>$member_list]);
    }

    public function year_list($id){
      $year_list = Management::with('user')->where('user_id', $id)->groupBy('year')
                   ->orderBy('year','DESC')->get('year');

      $user = User::where('id', $id)->first();

      return view('admin.yearList', ['year_list'=>$year_list, 'user'=>$user]);
    }

    public function month_list($id, $year){
      $month_list = Management::with('user')->where('user_id', $id)
                    ->where('year', $year)
                    ->groupBy('month_id')->orderBy('month_id','ASC')->get('month_id');
  
      return view('admin.monthList', ['month_list'=>$month_list]);
    }

    public function master_show($id, $year, $month){
      $month_list = Management::with('user')->where('user_id', $id)
                    ->where('year', $year)->where('month_id', $month)
                    ->groupBy('_id')->orderBy('month_id','ASC')->get('month_id');
  // 未完成だよ
      return view('admin.monthList', ['month_list'=>$month_list]);
    }


    public function update(Request $request){
        
        $management = Management::where('month_id',$request->month_id)
                      ->select('calendar_id');

        $list = Management::groupBy('calendar_id')->get('calendar_id');
  
        foreach($management as $managements){
  
         $managements->id->update([
  
           'opening_time' => $request->input('opening_time[$list->calendar_id]'),
           'ending_time' => $request->input('ending_time[$list->calendar_id]'),
          'break_time' => $request->input('break_time[$list->calendar_id]'),
          'total_time' => $request->input('total_time[$list->calendar_id]'),
          'over_time' => $request->input('over_time[$list->calendar_id]'),
          'night_time' => $request->input('night_time[$list->calendar_id]'),
          'holiday_time' => $request->input('holiday_time[$list->calendar_id]'),
          'holiday_night' => $request->input('holiday_night[$list->calendar_id]'),
          'holiday' => $request->input('holiday[$list->calendar_id]'),
          'adsence' => $request->input('adsence[$list->calendar_id]'),
          'late' => $request->input('late[$list->calendar_id]'),
          'leave_early' => $request->input('leave_early[$list->calendar_id]'),
          'holiday_work' => $request->input('holiday_work[$list->calendar_id]'),
          'makeup_holiday' => $request->input('makeup_holiday[$list->calendar_id]')]);
        
            }
          return redirect('/');
        }

}