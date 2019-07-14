@extends('layouts.app')

@section('content')
  <div class="container mt-6">
    <div class="row">
      <div class="col-6">
        社員ナンバー {{Auth::user()->employee_number}}
      </div>
      <div class="col-6">
        {{Auth::user()->name}}
      </div>
    </div>
  </div>
    <div class="container mt-5 mb-4">
      <div class="row">
        <div class="col-8 offset-2">
          <div class="list-group">
            <ul>
                <li class="list-group-item list-group-item-success">
                {{$year->year}}年の月一覧
                </li>
              @foreach($list as $month)
              <li><a href="/managements/show/{{$auth}}/{{$year->year}}/{{$month->month->id}}" class="list-group-item list-group-item-action" name="list[]">{{$month->month->id}}月の勤務表</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>

@endsection