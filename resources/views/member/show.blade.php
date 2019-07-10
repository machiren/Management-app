@extends('layouts.app')

@section('content')

  <div class="container mt-3 mb-4">
    <div class="row">
      <div class="employee_number col-4">
        社員ナンバー {{Auth::user()->employee_number}}
      </div>
      <div class="name col-4">
        {{Auth::user()->name}}
      </div>
      <div class="month col4">
        @foreach($month as $months)
          {{$months->month}}月
        @endforeach
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">    
      <table id="management" class="table table-bordered ">
        <tr>
          <th class='none'></th>
          <th colspan="3" style="text-align:center">平日</th>
          <th colspan="2" style="text-align:center">休日</th>
          <th colspan="6" style="text-align:center">勤怠</th>
        </tr>
        <tr>
          <th>日付</th>
          <!-- <th>曜日</th> -->
          <th>始業時刻</th>
          <th>終業時刻</th>
          <th>休憩時間</th>
          <th>休日</th>
          <th>休日深夜</th>
          <th>休暇</th>
          <th>欠勤</th>
          <th>遅刻</th>
          <th>早退</th>
          <th>休出</th>
          <th>振休</th>
        </tr>
          @foreach($management as $managements)
        <tr>
          <td>{{$managements->calendar_id}}</td>
          <td>{{$managements->opening_time}}</td>
          <td>{{$managements->ending_time}}</td>
          <td>{{$managements->break_time}}</td>
          <td>{{$managements->holiday_time}}</td>
          <td>{{$managements->holiday_night}}</td>
          <td>{{($managements->holiday)}}</td>
          <td>{{($managements->adsence)}}</td>
          <td>{{($managements->late)}}</td>
          <td>{{($managements->leave_early)}}</td>
          <td>{{($managements->holiday_work)}}</td>
          <td>{{($managements->makeup_holiday)}}</td>
        </tr>
          @endforeach
      </table>
      </div>
    </div>
  </div>
  <div class="container mt-2 offset-3">
    <div class="row">
      <div class="col-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">給与計算用欄</span>
            <div class="form-control">後程</div>
          </div>
        </div>
      </div>
      <div class="col-3">
        <div class="input-group">
          <div class="input-group-prepend">
            @foreach($summary as $summaries)
            <span class="input-group-text">始業時間</span>
            <div class="form-control">{{$summaries->official_start_time}}</div>
            <span class="input-group-text">終業時間</span>
            <div class="form-control">{{$summaries->official_end_time}}</div>
            <span class="input-group-text">休憩時間</span>    
            <div class="form-control">{{$summaries->official_break_time}}</div> 
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="container mt-5 mb-4">
      <div class="row">
        <div class="col-3 offset-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">顧客名</span>
              <span class="form-control text-nowrap">{{$summaries->customer}}</span>
              <span class="input-group-text">プロジェクト名</span>
              <span class="form-control text-nowrap">{{$summaries->project}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row">
        <div class="col col-3 offset-3">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">備考欄</span>
              <span class="form-control text-nowrap">{{$summaries->remarks}}</span>
              @endforeach 
@endsection