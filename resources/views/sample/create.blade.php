@extends('layouts.app')

@section('content')

<div>{{date('Y')}}年</div>


  <select>
    @foreach($month1 as $months)
      <option value="">{{$months->month}}</option> 
    @endforeach
  </select>



<div class='name'>{{Auth::user()->name}}</div>
<div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

<table class="management">

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

    @foreach($day1 as $days)
      <tr>
        <form action="/create/post" method="POST">
          <td>{{$days->day}}</td>
          <td><input type="text" size="5" name="opening_time"></td>
          <td><input type="text" size="5" name="ending_time"></td>
          <td><input type="text" size="5" name="break_time"></td>
          <td><input type="text" size="5" name="total_time"></td>
          <td><input type="text" size="5" name="over_time"></td>
          <td><input type="text" size="5" name="night_time"></td>
          <td><input type="text" size="5" name="holiday_time"></td>
          <td><input type="text" size="5" name="holiday_night"></td>
          <td><input type="checkbox" name="holiday"></td>
          <td><input type="checkbox" name="adsence"></td>
          <td><input type="checkbox" name="late"></td>
          <td><input type="checkbox" name="leave_early"></td>
          <td><input type="checkbox" name="holiday_work"></td>
          <td><input type="checkbox" name="makeup_holiday"></td>
      </tr>
    @endforeach
    <td><input type="submit" value="送信"></td>
    <td><input type="reset" value="リセット"></td>
  </form>
</table>

@endsection