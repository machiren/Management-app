<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DateTime;
use App\User;
use Auth;
use App\Management;
use App\Summary;
use App\Month;
use App\Calendar;

class MemberController extends Controller
{
    public function index(){
      return view('member.index');
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

      $confirm = $request->session()->all();

      return view('member.confirm',['confirm'=>$confirm]);
    }

    public function store(Request $request){

      $a = $request->validate([

        'month_id' => [Rule::unique('managements','month_id')->where('year',$request->year)->where('user_id',$request->user_id)]]);

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
        'holiday_start_time' => $request->input('holiday_start_time')[$key],
        'holiday_end_time' => $request->input('holiday_end_time')[$key],
        'holiday_break_time' => $request->input('holiday_break_time')[$key],
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
      $year_list = Management::groupBy('year')->where('user_id',Auth::user()->id)->get('year');

      return view('member.year_List', ['user'=>$get_user,'year_list'=>$year_list]);
    }

    public function month_list($year){

      $get_auth = Auth::user()->id;
      $get_year = Management::where('user_id',Auth::user()->id)->where('year',$year)->first();
      $list = Management::where('user_id',Auth::user()->id)->where('year',$year)->groupBy('month_id')->orderBy('month_id','ASC')->get('month_id');

      return view('member.list',['auth'=>$get_auth,'year'=>$get_year,'list'=>$list]);
    }

    public function show($year,$month){

      $get_month = Month::where('month',$month)->first();
      $management = Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->whereBetween('calendar_id',[1,31])->get();
      $summary = Summary::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->get();
      $total = [

        'holiday' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('holiday'),
        'adsence' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('adsence'),
        'late' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('late'),
        'leave_early' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('leave_early'),
        'holiday_work' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('holiday_work'),
        'makeup_holiday' => Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->sum('makeup_holiday')];

        $get_total_time = Management::where('user_id',Auth::user()->id)->where('year',$year)->where('month_id',$month)->get();

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

        $difference_2 = $holiday_end_time->diff($holiday_start_time)->format(date('Y-m-d')." ".'%H:%I:%S');
        $string_3 = new DateTime(date(" ".$difference_2));
        $difference_3 = $string_3->diff($holiday_break_time)->format(date('Y-m-d')." ".'%H:%I:%S');

        $string_4 = strtotime($difference_3);          $string_1 = strtotime($difference_1);
        $time_total_1 = $string_4 - $string_5;         $time_total = $string_1 - $string_2;
        $holiday_work += $time_total_1;                $sum_time += $time_total;
        $holiday_work1 += $time_total_1;               $sum_time1 += $time_total;

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
        $sum_time1 = floor($sum_time1 / 3600);
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

      return view('member.show',[

      'month'=>$get_month,'management'=>$management,'summary'=>$summary,'total'=>$total,
      'total_work_time'=>$total_work_time,'eight_over_time'=>$eight_over_time,
      'night_work_time'=>$night_work_time,'holiday_work_time'=>$holiday_work_time,
      'holiday_night_work_time'=>$holiday_night_work_time]);
    }
}