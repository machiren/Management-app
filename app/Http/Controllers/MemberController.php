<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;
use App\User;
use Auth;
use App\Management;
use App\Summary;
use App\Month;
use App\Calendar;

class MemberController extends Controller
{
    public function index(){

      $member = Auth::user();

      return view('member.index',['member'=>$member]);
    }


    public function list(){

      $month = Month::select()->get();

      return view('member.month_list',['month'=>$month]);
    }


    public function create($id){

      $day = Calendar::with('month')->where('month_id',$id)->get();
      $month = Month::where('month',$id)->get();

      return view('member.create',['day'=>$day,'month'=>$month]);
    }

    public function confirm(Request $request){

      $request->session()->regenerate();
      $get = $request->session()->put([

        'calendar_id' => $request->calendar_id,
        'opening_time' => $request->opening_time,
        'ending_time' => $request->ending_time,
        'break_time' => $request->break_time,
        'holiday_time' => $request->holiday_time,
        'holiday_night' => $request->holiday_night,
        'holiday' => $request->holiday,
        'adsence' => $request->adsence,
        'late' => $request->late,
        'leave_early' => $request->leave_early,
        'holiday_work' => $request->holiday_work,
        'makeup_holiday' => $request->makeup_holiday,
        'official_start_time' => $request->official_start_time,
        'official_end_time' => $request->official_end_time,
        'offcial_break_time' => $request->official_break_time,
        'customer' => $request->customer,
        'project' => $request->project,
        'remarks' => $request->remarks,
        'year' => $request->year,
        'month_id' => $request->month_id,
        'user_id' => $request->user_id]);

      $confirm = $request->session()->all();dd($confirm);

      return view('member.confirm',['confirm'=>$confirm]);
    }


    public function store(Request $request){

      $a = $request->validate([

        'month_id' => [Rule::unique('managements','month_id')->where('year',$request->year)]]);

      Summary::create([

        'user_id' => $request->input('user_id'),
        'year' => $request->input('year'),
        'month_id' => $request->input('month_id'),
        'remarks' => $request->input('remarks'),
        'customer' => $request->input('customer'),
        'project' => $request->input('project'),
        'official_start_time' => $request->input('official_start_time'),
        'official_end_time' => $request->input('official_end_time'),
        'official_break_time' => $request->input('official_break_time')]);


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
        'user_id' => $request->input('user_id'),
        'month_id' => $request->input('month_id'),
        'year' => $request->input('year')]);}

        return redirect('/managements/created');
      }


    public function year_list(){

      $get_user = Auth::user()->id;
      $year_list = Management::groupBy('year')->get('year');

      return view('member.year_List', ['user'=>$get_user,'year_list'=>$year_list]);
    }


    public function month_list($year){

      $get_auth = Auth::user()->id;
      $get_year = Management::where('year',$year)->first();
      $list = Management::where('year',$year)->groupBy('month_id')->orderBy('month_id','ASC')->get('month_id');

      return view('member.list',['auth'=>$get_auth,'year'=>$get_year,'list'=>$list]);
    }


    public function show($auth,$year,$month){

      $get_month = Month::where('month',$month)->get();
      $management = Management::where('year',$year)->where('month_id',$month)->whereBetween('calendar_id',[1,31])->get();
      $summary = Summary::where('user_id',$auth)->where('year',$year)->where('month_id',$month)->get();

      return view('member.show',['month'=>$get_month,'management'=>$management,'summary'=>$summary]);
    }
}