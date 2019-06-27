@extends('layouts.app')

@section('content')


<script>

$(function()){
  $('#month').change(function() {
    $('option:selected').var();

});}

</script>

  <select id="month">
    @foreach($month as $months)
      <option value="">{{$months->id}}</option> 
    @endforeach
  </select>

  <div class='name'>{{Auth::user()->name}}</div>
  <div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

<form action="/create/update" method="POST" name="update">

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
      <th>実働時間</th>
      <th>うち8h越え</th>
      <th>うち深夜</th>
      <th>休日</th>
      <th>休日深夜</th>
      <th>休暇</th>
      <th>欠勤</th>
      <th>遅刻</th>
      <th>早退</th>
      <th>休出</th>
      <th>振休</th>
    </tr>

    @foreach($day as $days)
    @foreach($management as $managements)
      <tr>
        <td>{{$days->day}}</td>
        <td><input type="time" name="opening_time[{{$days->day}}]" value="{{$managements->opening_time}}"></td>
        <td><input type="time" name="ending_time[{{$days->day}}]" value="{{$managements->ending_time}}"></td>
        <td><input type="time" name="break_time[{{$days->day}}]" value="{{$managements->break_time}}"></td>
        <td><input type="time" name="total_time[{{$days->day}}]" value="{{$managements->total_time}}"></td>
        <td><input type="time" name="over_time[{{$days->day}}]" value="{{$managements->over_time}}"></td>
        <td><input type="time" name="night_time[{{$days->day}}]" value="{{$managements->night_time}}"></td>
        <td><input type="time" name="holiday_time[{{$days->day}}]" value="{{$managements->holiday_time}}"></td>
        <td><input type="time" name="holiday_night[{{$days->day}}]" value="{{$managements->holiday_night}}"></td>

          <td>
            <input type="hidden" name="holiday[{{$days->day}}]" value="0">
            <input type="checkbox" name="holiday[{{$days->day}}]" value="{{isset($managements->holiday)}}">
          </td>
          <td>
            <input type="hidden" name="adsence[{{$days->day}}]" value="0">
            <input type="checkbox" name="adsence[{{$days->day}}]" value="{{isset($managements->adsence)}}">
          </td>
          <td>
            <input type="hidden" name="late[{{$days->day}}]" value="0">
            <input type="checkbox" name="late[{{$days->day}}]" value="{{isset($managements->late)}}">
          </td>
          <td>
            <input type="hidden" name="leave_early[{{$days->day}}]" value="0">
            <input type="checkbox" name="leave_early[{{$days->day}}]" value="{{isset($managements->leave_early)}}">
          </td>
          <td>
            <input type="hidden" name="holiday_work[{{$days->day}}]" value="0">
            <input type="checkbox" name="holiday_work[{{$days->day}}]" value="{{isset($managements->holiday_work)}}">
          </td>
          <td>
            <input type="hidden" name="makeup_holiday[{{$days->day}}]" value="0">
            <input type="checkbox" name="makeup_holiday[{{$days->day}}]" value="{{isset($managements->makeup_holiday)}}">
          </td>
        </tr>
        @endforeach
        @endforeach

    <input type="submit" name="update" value="更新">
  </table>
</form>


@endsection