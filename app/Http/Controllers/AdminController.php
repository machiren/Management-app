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

      //総労働時間を求める//
      $sum_time = 0;
      $sum_time1 = 0;
      $fixed = date('Y-m-d'." ".'00:00:00');
      $string_2 = strtotime($fixed);
      //8h超を求める//
      $over_work = 0;
      $over_work1 = 0;
      $over_work_hour = date('Y-m-d'." ".'08:00:00');
      $over_work_hour_seconds = strtotime($over_work_hour);
      //10時以降を求める//
      $night_work = 0;
      $night_work1 = 0;
      $night_work_hour = date('Y-m-d'." ".'22:00:00');
      $night_work_hour_seconds = strtotime($night_work_hour);

      foreach($get_total_time as $total_time){

      //時間の代入
      $end_time = new DateTime(date(date('Y-m-d')." ". $total_time->ending_time));
      $start_time = new DateTime(date(date('Y-m-d')." ". $total_time->opening_time));
      $break_time = new DateTime(date(date('Y-m-d')." ". $total_time->break_time));

      //一日の総労働時間の合計
      $difference = $end_time->diff($start_time)->format(date('Y-m-d')." ".'%H:%I:%S');
      $string = new DateTime(date(" ".$difference));
      $difference_1 = $string->diff($break_time)->format(date('Y-m-d')." ".'%H:%I:%S');

      //終業時間を秒にする
      $end_time_seconds = $end_time->format(date('Y-m-d')." ".'H:i:s');
      $get_end_seconds = strtotime($end_time_seconds);

      //UNIX_TIMEを基準に秒に直す
      $string_1 = strtotime($difference_1);
      $time_total = $string_1 - $string_2;
      $sum_time += $time_total;
      $sum_time1 += $time_total;

      //8h超えを求める//
      $eight_over_seconds = $string_1 - $over_work_hour_seconds;
      if($eight_over_seconds > 0){
      $over_work += $eight_over_seconds;
      $over_work1 += $eight_over_seconds;
      }

      //10時以降を求める//
      $night_over_seconds = $get_end_seconds - $night_work_hour_seconds;
      if($night_over_seconds > 0){
      $night_work += $night_over_seconds;
      $night_work1 += $night_over_seconds;
      }
    }
      //時間を秒にしたやつを割って戻す
      $sum_time = $sum_time / 3600;
      //小数点をを出す
      $sum_time1 = floor($sum_time1 / 3600);
      //出した小数点との差分を計算する(分を求めるため)
      $dot = number_format($sum_time - $sum_time1,2);
      //分を60進法で戻して切り上げる
      $minutes = round($dot * 60);
      //文字列として連結させて分が0だと0埋めするように記述する
      $total_work_time = sprintf("$sum_time1".':'.'%02d',"$minutes");

      //8h超を求める//
      $over_work = $over_work / 3600;
      //小数点をだす
      $over_work1 = floor($over_work1 / 3600);
      //出した小数点との差分を計算する(分を求めるため)
      $dot_1 = number_format($over_work - $over_work1,2);
      //分を60進法で戻して切り上げる
      $minutes_1 = round($dot_1 * 60);
      //文字列として連結させて分が0だと0埋めするように記述する
      $eight_over_time = sprintf("$over_work1".':'.'%02d',"$minutes_1");

      //深夜時間を求める(10時以降)//
      $night_work = $night_work / 3600;
      //小数点をだす
      $night_work1 = floor($night_work1 / 3600);
      //出した小数点との差分を計算する(分を求めるため)
      $dot_2 = number_format($night_work - $night_work1,2);
      //分を60進法で戻して切り上げる
      $minutes_2 = round($dot_2 * 60);
      //文字列として連結させて分が0だと0埋めするように記述する
      $night_work_time = sprintf("$night_work1".':'.'%02d',"$minutes_2");

      return view('admin.show',[

        'show_list'=>$show_list,'summary'=>$summary,'year'=>$get_year,'month'=>$get_month,
        'user'=>$get_user,'total'=>$total,'total_work_time'=>$total_work_time,'eight_over_time'=>$eight_over_time,
        'night_work_time'=>$night_work_time]);
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