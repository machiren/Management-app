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

      $get_total_time = Management::where('user_id',$id)->where('year',$year)->where('month_id',$month)->select('opening_time','ending_time','break_time')->get();

      $sum_time = 0;
      $sum_time1 = 0;
      foreach($get_total_time as $total_time){

      $end_time = new DateTime(date(date('Y-m-d')." ". $total_time->ending_time));
      $start_time = new DateTime(date(date('Y-m-d')." ". $total_time->opening_time));
      $break_time = new DateTime(date(date('Y-m-d')." ". $total_time->break_time));

      $difference = $end_time->diff($start_time)->format(date('Y-m-d')." ".'%H:%I:%S');
      $string = new DateTime(date(" ".$difference));
      $difference_1 = $string->diff($break_time)->format(date('Y-m-d')." ".'%H:%I:%S');
      $string_1 = strtotime($difference_1);
      $fixed = date('Y-m-d'." ".'00:00:00');
      $string_2 = strtotime($fixed);
      $time_total = $string_1 - $string_2;
      $sum_time += $time_total;
      $sum_time1 += $time_total;
    }

      $sum_time = $sum_time / 3600;
      $sum_time1 = floor($sum_time1 / 3600);
      $dot = number_format($sum_time - $sum_time1,2);

      $minutes = round($dot * 60);
      $total_work_time = sprintf("$sum_time1".':'.'%02d',"$minutes");

      return view('admin.show',['show_list'=>$show_list,'summary'=>$summary,'year'=>$get_year,'month'=>$get_month,'user'=>$get_user,'total'=>$total,'total_work_time'=>$total_work_time]);
    }

    //8h越え = 実働時間 - 08:00
    //深夜時間 = 就業時間 - 22:00
    //実働時間 = 就業時間 - 始業時間 - 休憩時間


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
        'holiday_time' => $request->input('holiday_time')[$id],
        'holiday_night' => $request->input('holiday_night')[$id],
        'holiday' => $request->input('holiday')[$id],
        'adsence' => $request->input('adsence')[$id],
        'late' => $request->input('late')[$id],
        'leave_early' => $request->input('leave_early')[$id],
        'holiday_work' => $request->input('holiday_work')[$id],
        'makeup_holiday' => $request->input('makeup_holiday')[$id]];

      Management::where('id',$id)->update($update_culumn);

      }
        return redirect('/managements/updated');
    }


    public function delete($id,$year,$month){

      $get_delete_id1 = Summary::with('user')->where('user_id',$id)->where('year',$year)->where('month_id',$month)->delete();
      $get_delete_id2 = Management::with('user')->where('user_id', $id)->where('year', $year)->where('month_id', $month)->get();

      foreach($get_delete_id2 as $derete)
      {
        $derete->delete();
      }

      return redirect('managements/deleted');
  }
}