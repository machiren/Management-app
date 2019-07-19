<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Datetime;
use App\User;
use App\Management;
use App\Month;
use App\Calendar;
use App\Summary;


class AdminController extends Controller
{
    public function member_list(){

      $member_list = User::where('admin','<>','0')->get();

      return view('admin.memberList', ['member_list'=>$member_list]);
    }

    public function year_list($id){

      $get_user = User::where('id', $id)->first();
      $year_list = Management::with('user')->where('user_id', $id)->groupBy('year')->orderBy('year','DESC')->get('year');

      return view('admin.yearList', ['year_list'=>$year_list,'user'=>$get_user]);
    }

    public function month_list($id, $year){

      $get_year = Management::with('user')->where('year',$year)->first();
      $get_user = User::where('id',$id)->first();
      $month_list = Management::with('user')->where('user_id', $id)->where('year', $year)->groupBy('month_id')->orderBy('month_id','ASC')->get('month_id');

      return view('admin.monthList', ['month_list'=>$month_list,'user'=>$get_user,'year'=>$get_year]);
    }

    public function show_list($id, $year, $month){

      $show_list = Management::with('user')->where('user_id', $id)->where('year', $year)->where('month_id', $month)->get();
      foreach($show_list as $show_lists){

      $get_datetime = [

        'opening_time' => date('Y-m-d'.$show_lists->opening_time),
        'ending_time' => date('Y-m-d'.$show_lists->ending_time),
        'break_time' => date('Y-m-d'.$show_lists->break_time)];

      $get_start_time = date('g:i',strtotime($get_datetime['opening_time']));
      $get_end_time = date('g:i',strtotime($get_datetime['ending_time']));
      $get_break_time = date('g:i',strtotime($get_datetime['break_time']));
      }

      $summary = Summary::with('user')->where('user_id',$id)->where('year',$year)->where('month_id',$month)->get();
      $get_year = Management::with('user')->where('year',$year)->first();
      $get_month = Month::where('month',$month)->first();
      $get_user = User::where('id',$id)->first();
      $total = [

        'holiday' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('holiday'),
        'adsence' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('adsence'),
        'late' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('late'),
        'leave_early' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('leave_early'),
        'holiday_work' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('holiday_work'),
        'makeup_holiday' => Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->sum('makeup_holiday')];

      $get_total_time = Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->get();

      $sum_time = 0;                                              $over_work = 0;
      $sum_time1 = 0;                                             $over_work1 = 0;
      $fixed = date('Y-m-d'." ".'00:00:00');                      $over_work_hour = date('Y-m-d'." ".'08:00:00');
      $string_2 = strtotime($fixed);                              $over_work_hour_seconds = strtotime($over_work_hour);

      $night_work = 0;                                            $holiday_work = 0;                                     $holiday_night_work = 0;
      $night_work1 = 0;                                           $holiday_work1 = 0;                                    $holiday_night_work1 = 0;
      $night_work_hour = date('Y-m-d'." ".'22:00:00');            $fixed1 = date('Y-m-d'." ".'00:00:00');
      $night_work_hour_seconds = strtotime($night_work_hour);     $string_5 = strtotime($fixed1);

      foreach($get_total_time as $total_time){

      $end_time = new DateTime(date(date('Y-m-d')." ". $total_time->ending_time));
      $start_time = new DateTime(date(date('Y-m-d')." ". $total_time->opening_time));
      $break_time = new DateTime(date(date('Y-m-d')." ". $total_time->break_time));
      $holiday_start_time = new DateTime(date(date('Y-m-d')." ". $total_time->holiday_start_time));
      $holiday_end_time = new DateTime(date(date('Y-m-d')." ". $total_time->holiday_end_time));
      $holiday_break_time = new DateTime(date(date('Y-m-d')." ". $total_time->holiday_break_time));

      $difference = $end_time->diff($start_time)->format(date('Y-m-d')." ".'%H:%I:%S');
      $string = new DateTime(date(" ".$difference));
      $difference_1 = $string->diff($break_time)->format(date('Y-m-d')." ".'%H:%I:%S');

      $string_1 = strtotime($difference_1);
      $time_total = $string_1 - $string_2;
      $sum_time += $time_total;
      $sum_time1 += $time_total;

      $difference_2 = $holiday_end_time->diff($holiday_start_time)->format(date('Y-m-d')." ".'%H:%I:%S');
      $string_3 = new DateTime(date(" ".$difference_2));
      $difference_3 = $string_3->diff($holiday_break_time)->format(date('Y-m-d')." ".'%H:%I:%S');

      $string_4 = strtotime($difference_3);
      $time_total_1 = $string_4 - $string_5;
      $holiday_work += $time_total_1;
      $holiday_work1 += $time_total_1;

      $end_time_seconds = $end_time->format(date('Y-m-d')." ".'H:i:s');
      $get_end_seconds = strtotime($end_time_seconds);

      $holiday_end_time_seconds = $holiday_end_time->format(date('Y-m-d')." ".'H:i:s');
      $get_holiday_end_seconds = strtotime($holiday_end_time_seconds);

      $eight_over_seconds = $string_1 - $over_work_hour_seconds;
      if($eight_over_seconds > 0){
      $over_work += $eight_over_seconds;
      $over_work1 += $eight_over_seconds;
      }

      $night_over_seconds = $get_end_seconds - $night_work_hour_seconds;
      if($night_over_seconds > 0){
      $night_work += $night_over_seconds;
      $night_work1 += $night_over_seconds;
      }

      $holiday_over_seconds = $get_holiday_end_seconds - $night_work_hour_seconds;
      if($holiday_over_seconds > 0){
      $holiday_night_work += $holiday_over_seconds;
      $holiday_night_work1 += $holiday_over_seconds;
      }
    }

      $sum_time = $sum_time / 3600;
      $sum_time1 = sprintf('%02d',floor($sum_time1 / 3600));
      $dot = number_format($sum_time - $sum_time1,2);
      $minutes = round($dot * 60);
      $total_work_time = sprintf("$sum_time1".':'.'%02d',"$minutes");

      $over_work = $over_work / 3600;
      $over_work1 = sprintf('%02d',floor($over_work1 / 3600));
      $dot_1 = number_format($over_work - $over_work1,2);
      $minutes_1 = round($dot_1 * 60);
      $eight_over_time = sprintf("$over_work1".':'.'%02d',"$minutes_1");

      $night_work = $night_work / 3600;
      $night_work1 = sprintf('%02d',floor($night_work1 / 3600));
      $dot_2 = number_format($night_work - $night_work1,2);
      $minutes_2 = round($dot_2 * 60);
      $night_work_time = sprintf("$night_work1".':'.'%02d',"$minutes_2");

      $holiday_work = $holiday_work / 3600;
      $holiday_work1 = sprintf('%02d',floor($holiday_work1 / 3600));
      $dot_3 = number_format($holiday_work - $holiday_work1,2);
      $minutes_3 = round($dot_3 * 60);
      $holiday_work_time = sprintf("$holiday_work1".':'.'%02d',"$minutes_3");

      $holiday_night_work = $holiday_night_work / 3600;
      $holiday_night_work1 = sprintf('%02d',floor($holiday_night_work1 / 3600));
      $dot_4 = number_format($holiday_night_work - $holiday_night_work1,2);
      $minutes_4 = round($dot_4 * 60);
      $holiday_night_work_time = sprintf("$holiday_night_work1".':'.'%02d',"$minutes_4");

      return view('admin.show',[

        'show_list'=>$show_list,'summary'=>$summary,'year'=>$get_year,'month'=>$get_month,
        'user'=>$get_user,'total'=>$total,'total_work_time'=>$total_work_time,'eight_over_time'=>$eight_over_time,
        'night_work_time'=>$night_work_time,'holiday_work_time'=>$holiday_work_time,'holiday_night_work_time'=>$holiday_night_work_time]);
    }

    public function edit($id,$year,$month){

      $edit_list = Management::with('user')->where('user_id', $id)->where('year', $year)->where('month_id', $month)->get();
      $summary = Summary::with('user')->where('user_id',$id)->where('year',$year)->where('month_id',$month)->get();
      $get_year = Management::with('user')->where('year',$year)->first();
      $get_month = Month::where('month',$month)->first();
      $get_user = User::where('id',$id)->first();

      return view('admin.edit',['edit_list'=>$edit_list,'edit_summary'=>$summary,'year'=>$get_year,'month'=>$get_month,'user'=>$get_user]);
    }

    public function update(Request $request){

      foreach($request->input('id') as $id){

      $update_culumn = [

        'opening_time' => $request->input('opening_time')[$id],
        'ending_time' => $request->input('ending_time')[$id],
        'break_time' => $request->input('break_time')[$id],
        'holiday_start_time' => $request->input('holiday_start_time')[$id],
        'holiday_end_time' => $request->input('holiday_end_time')[$id],
        'holiday_break_time' => $request->input('holiday_break_time')[$id],
        'holiday' => $request->input('holiday')[$id],
        'adsence' => $request->input('adsence')[$id],
        'late' => $request->input('late')[$id],
        'leave_early' => $request->input('leave_early')[$id],
        'holiday_work' => $request->input('holiday_work')[$id],
        'makeup_holiday' => $request->input('makeup_holiday')[$id]];

      Management::where('id',$id)->update($update_culumn);

      }

      $summary_culumn = [

        'official_start_time' => $request->input('official_start_time'),
        'official_end_time' => $request->input('official_end_time'),
        'official_break_time' => $request->input('official_break_time'),
        'customer' => $request->input('customer'),
        'project' => $request->input('project'),
        'remarks' => $request->input('remarks')];

      Summary::where('user_id',$request->input('user_id'))->update($summary_culumn);

      return redirect('/managements/updated');
    }

    public function delete($id,$year,$month){

      $get_delete_id1 = Summary::with('user')->where('user_id',$id)->where('year',$year)->where('month_id',$month)->delete();
      $get_delete_id2 = Management::with('user')->where('user_id', $id)->where('year', $year)->where('month_id', $month)->get();

      foreach($get_delete_id2 as $delete)
      {
        $delete->delete();
      }

      return redirect('managements/deleted');
  }
}