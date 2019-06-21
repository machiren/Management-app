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

    public function store1(Request $request){
      
      $month = Month::create([

      'month' => $request->input('add')]);

      return redirect('/');
    }

    public function store(){

      $management = Management::create([

        'opening_time' => $request->input('opening_time'),
        'ending_time' => $request->input('ending_time'),
        'break_time' => $request->input('break_time'),
        'total_time' => $request->input('total_time'),
        'over_time' => $request->input('over_time'),
        'night_time' => $request->input('night_time'),
        'holiday_time' => $request->input('holiday_time'),
        'holiday_night' => $request->input('holiday_night'),
        'holiday' => $request->input('holiday'),
        'adsence' => $request->input('adsence'),
        'late' => $request->input('late'),
        'leave_early' => $request->input('leave_early'),
        'holiday_work' => $request->input('holiday_work'),
        'makeup_holiday' => $request->input('makeup_holiday')]);

      return redirect('/'); 
    }
}
