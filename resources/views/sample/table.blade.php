@extends('layouts.app')

@section('content')

  <div class='name'>{{Auth::user()->name}}</div>
  <div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

<table id="management">

  <tr>
    <th class='none'></th>
    <th colspan="5" style="text-align:center">平日</th>
    <th colspan="2" style="text-align:center">休日</th>
    <th colspan="4" style="text-align:center">勤怠</th>
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

@endsection