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

      return view('admin.show',['show_list'=>$show_list,'summary'=>$summary,'year'=>$get_year,'month'=>$get_month,'user'=>$get_user]);
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
        return redirect('/');
    }


    public function delete($id,$year,$month){

      $get_delete_id = Management::with('user')->where('user_id', $id)->where('year', $year)->where('month_id', $month)->get();

      foreach($get_delete_id as $derete){

      $derete->delete();

      }
      return redirect('/');
  }
}