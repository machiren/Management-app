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

      //storeされたデータのテーブルの情報を取ってきて勤務表にforeachで表示する
      $month = Month::all();
      $day = Calendar::all();
      $management = Management::all();

      return view('sample.list')->with(['month'=>$month,'day'=>$day,'management'=>$management]);
    }

    public function store(Request $request){
      
      $post = Month::create([$request->month]);
      $post1 = $post->save();

      return $post1->redirect("/");
    }
}
