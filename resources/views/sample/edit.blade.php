@extends('layouts.app')

@section('content')

  <div class='name'>{{Auth::user()->name}}</div>
  <div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

<form action="/managements/{management}" method="POST" name="update">

  @csrf
  @method('PUT')

<table id="management">

  <tr>
    <th class='none'></th>
    <th colspan="6" style="text-align:center">平日</th>
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

    @csrf

      @foreach($management as $managements)

        <tr>
          <td>{{$managements->calendar_id}}</td>
          <td><input type="time" step="900" name="opening_time[{{$managements->calendar_id}}]" value="{{$managements->opening_time}}"></td>
          <td><input type="time" step="900" name="ending_time[{{$managements->calendar_id}}]" value="{{$managements->ending_time}}"></td>
          <td><input type="time" step="900" name="break_time[{{$managements->calendar_id}}]" value="{{$managements->break_time}}"></td>
          <td><input type="time" step="900" name="holiday_time[{{$managements->calendar_id}}]" value="{{$managements->holiday_time}}"></td>
          <td><input type="time" step="900" name="holiday_night[{{$managements->calendar_id}}]" value="{{$managements->holiday_night}}"></td>

            <td>
              <input type="hidden" name="holiday[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="holiday[{{$managements->calendar_id}}]" value="{{($managements->holiday)}}">
            </td>
            <td>
              <input type="hidden" name="adsence[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="adsence[{{$managements->calendar_id}}]" value="{{($managements->adsence)}}">
            </td>
            <td>
              <input type="hidden" name="late[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="late[{{$managements->calendar_id}}]" value="{{($managements->late)}}">
            </td>
            <td>
              <input type="hidden" name="leave_early[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="leave_early[{{$managements->calendar_id}}]" value="{{($managements->leave_early)}}">
            </td>
            <td>
              <input type="hidden" name="holiday_work[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="holiday_work[{{$managements->calendar_id}}]" value="{{($managements->holiday_work)}}">
            </td>
            <td>
              <input type="hidden" name="makeup_holiday[{{$managements->calendar_id}}]" value="0">
              <input type="checkbox" name="makeup_holiday[{{$managements->calendar_id}}]" value="{{($managements->makeup_holiday)}}">
            </td>
          </tr>

      @endforeach

    </table>

  <input type="submit" value="更新">

</form>


@endsection