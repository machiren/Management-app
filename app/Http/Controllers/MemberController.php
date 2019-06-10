<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class MemberController extends Controller
{
    public function index()
    {
      $member = Auth::user();

      return view('index')->with('member',$member);
    }

    public function create(){

      return view('create');
    }

    public function sample(){

      return view('sample');
    }
}
