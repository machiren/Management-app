<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Management;
use App\Month;
use App\Calendar;

class MemberController extends Controller
{
    public function index()
    {
      $member = Auth::user();

      return view('sample.index')->with('member',$member);
    }


    public function create(){

      $month = Month::all();
      $day = Calendar::all();
      $management = Management::all();

      return view('sample.create')->with(['month'=>$month,'day'=>$day,'management'=>$management]);
    }


    public function list(){


      $month = Month::all();
      $day = Calendar::all();
      $management = Management::all();

      return view('sample.list')->with(['month'=>$month,'day'=>$day,'management'=>$management]);
    }


    public function store(Request $request){

      foreach($request->input(
        'opening_time','ending_time',
        'break_time','total_time','over_time',
        'night_time','holiday_time','holiday_night',
        'holiday','adsence','late','leave_early',
        'holiday_work','makeup_holiday','calendar_id') as $key => $value){

        Management::create([

        'opening_time' => $request->input('opening_time')[$key],
        'ending_time' => $request->input('ending_time')[$key],
        'break_time' => $request->input('break_time')[$key],
        'total_time' => $request->input('total_time')[$key],
        'over_time' => $request->input('over_time')[$key],
        'night_time' => $request->input('night_time')[$key],
        'holiday_time' => $request->input('holiday_time')[$key],
        'holiday_night' => $request->input('holiday_night')[$key],
        'holiday' => $request->input('holiday')[$key],
        'adsence' => $request->input('adsence')[$key],
        'late' => $request->input('late')[$key],
        'leave_early' => $request->input('leave_early')[$key],
        'holiday_work' => $request->input('holiday_work')[$key],
        'makeup_holiday' => $request->input('makeup_holiday')[$key],
        'calendar_id' => $request->input('calendar_id')[$key],
        'auth_name' => $request->input('auth_name'),
        'auth_number' => $request->input('auth_number'),
        'user_id' => $request->input('user_id'),
        'month_id' => $request->input('month_id'),
        'year' => $request->input('year')]);}

        return redirect('/');
      }

    public function update(Request $request){

        $list = Management::where('month_id',$request->month_id)
                ->whereBetween('calendar_id',[1,31])->get();

      foreach($request->input(

        'opening_time','ending_time',
        'break_time','total_time','over_time',
        'night_time','holiday_time','holiday_night',
        'holiday','adsence','late','leave_early',
        'holiday_work','makeup_holiday') as $key => $value){

      foreach($list as $lists){dd($lists);

       $lists->update([

        'opening_time' => $request->input('opening_time')[$key],
        'ending_time' => $request->input('ending_time')[$key],
        'break_time' => $request->input('break_time')[$key],
        'total_time' => $request->input('total_time')[$key],
        'over_time' => $request->input('over_time')[$key],
        'night_time' => $request->input('night_time')[$key],
        'holiday_time' => $request->input('holiday_time')[$key],
        'holiday_night' => $request->input('holiday_night')[$key],
        'holiday' => $request->input('holiday')[$key],
        'adsence' => $request->input('adsence')[$key],
        'late' => $request->input('late')[$key],
        'leave_early' => $request->input('leave_early')[$key],
        'holiday_work' => $request->input('holiday_work')[$key],
        'makeup_holiday' => $request->input('makeup_holiday')[$key]]);}}

        return redirect('/');
      }

}

