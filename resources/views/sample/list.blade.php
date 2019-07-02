@extends('layouts.app')

@section('content')


<div class='name'>{{Auth::user()->name}}</div>
<div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

  <ul>
    @foreach($list as $lists)
     <li><a href="{{ url('/managements/{management}/edit')}}" name="list[]">{{$lists}}月の勤務表</a></li>
    @endforeach
  </ul>

@endsection