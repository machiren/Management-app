@extends('layouts.app')

@section('content')
  <div class="container mt-6">
    <div class="row">
      <div class="col-6">
        {{Auth::user()->name}}
      </div>
      <div class="col-6">
        社員ナンバー {{Auth::user()->employee_number}}
      </div>
    </div>
  </div>
    <div class="container">
      <div class="row">
        <div class="col-8 offset-4">
          <ul>
            @foreach($list as $lists)
              <li><a href="/managements/show/{{$auth}}/{{$lists->month->id}}" name="list[]">{{$lists->month->id}}月の勤務表</a></li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

@endsection