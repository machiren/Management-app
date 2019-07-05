@extends('layouts.app')

@section('content')

<div class='name'>{{Auth::user()->name}}</div>
<div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

    <ul>
        @foreach($month as $months)
    <li><a href="/managements/{{$months->id}}/create" name="month[]">{{$months->id}}月の勤務表</a></li>
        @endforeach
    </ul>
@endsection