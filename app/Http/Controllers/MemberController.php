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
      
      $month = Month::create([

            'month' => $request->input('add')]);

      // $month->create([$request->input->add->month]);

      return redirect('/');
    }
}
