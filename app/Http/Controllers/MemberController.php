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

      return view('sample.index',['member',$member]);
    }


    public function create(){

      $month = Month::all();
      $day = Calendar::all();
      $management = Management::all();

      return view('sample.create',['month'=>$month,'day'=>$day,'management'=>$management]);
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


    public function list(){

      $list = Management::groupBy('user_id','month_id')->orderBy('month_id','ASC')->get('month_id');


      return view('sample.list',['list'=>$list]);
    }


    public function edit($id){

      $month = Month::all();
      $day = Calendar::all();
      $management = Management::all();

      return view('sample.edit',['month'=>$month,'day'=>$day,'management'=>$management]);
    }


    // public function update(Request $request){

    //   $list = Management::where('month_id',$request->month_id)
    //             ->whereBetween('calendar_id',[1,31]);


    //   foreach($request->input(

    //     'opening_time','ending_time',
    //     'break_time','total_time','over_time',
    //     'night_time','holiday_time','holiday_night',
    //     'holiday','adsence','late','leave_early',
    //     'holiday_work','makeup_holiday') as $calendar_id => $value){

    //    $list->update([

    //     'opening_time' => $request->input('opening_time')[$calendar_id],
    //     'ending_time' => $request->input('ending_time')[$calendar_id],
    //     'break_time' => $request->input('break_time')[$calendar_id],
    //     'total_time' => $request->input('total_time')[$calendar_id],
    //     'over_time' => $request->input('over_time')[$calendar_id],
    //     'night_time' => $request->input('night_time')[$calendar_id],
    //     'holiday_time' => $request->input('holiday_time')[$calendar_id],
    //     'holiday_night' => $request->input('holiday_night')[$calendar_id],
    //     'holiday' => $request->input('holiday')[$calendar_id],
    //     'adsence' => $request->input('adsence')[$calendar_id],
    //     'late' => $request->input('late')[$calendar_id],
    //     'leave_early' => $request->input('leave_early')[$calendar_id],
    //     'holiday_work' => $request->input('holiday_work')[$calendar_id],
    //     'makeup_holiday' => $request->input('makeup_holiday')[$calendar_id]]);}

    //    return redirect('/');

    //    }

       public function update(Request $request){

        $list = Management::where('month_id',$request->month_id)
                ->whereBetween('calendar_id',[1,31]);
        
        $management = Management::where('calendar_id');
  
        foreach($management as $managements){
  
         $list->update([
  
           'opening_time' => $request->input('opening_time[$managements]'),
           'ending_time' => $request->input('ending_time[$managements]'),
          'break_time' => $request->input('break_time[$managements]'),
          'total_time' => $request->input('total_time[$managements]'),
          'over_time' => $request->input('over_time[$managements]'),
          'night_time' => $request->input('night_time[$managements]'),
          'holiday_time' => $request->input('holiday_time[$managements]'),
          'holiday_night' => $request->input('holiday_night[$managements]'),
          'holiday' => $request->input('holiday[$managements]'),
          'adsence' => $request->input('adsence[$managements]'),
          'late' => $request->input('late[$managements]'),
          'leave_early' => $request->input('leave_early[$managements]'),
          'holiday_work' => $request->input('holiday_work[$managements]'),
          'makeup_holiday' => $request->input('makeup_holiday[$managements]')]);
        
            }
         return redirect('/');
        }
}
          //hiddenで配列にして1~31日分のIDを渡しておく
          //1日に対して更新をかけるinputに配列を入れる！
