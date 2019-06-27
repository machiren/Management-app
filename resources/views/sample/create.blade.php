@extends('layouts.app')

@section('content')

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

  <div>{{date('Y')}}年</div>


<div class='name'>{{Auth::user()->name}}</div>
<div class='employee_number'>社員ナンバー {{Auth::user()->employee_number}}</div>

<form action="{{ url('/create/store')}}" method="POST">

  <table id="management">

     <select name="month_id">
      @foreach($month as $months)
        <option value="{{$months->id}}">{{$months->month}}</option> 
      @endforeach
    </select>

    <tr>
      <th class='none'></th>
      <th colspan="6" style="text-align:center">平日</th>
      <th colspan="2" style="text-align:center">休日</th>
      <th colspan="6" style="text-align:center">チェックボックス</th>
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

  @csrf
    @foreach($day as $days)
        <tr>
          <td>{{$days->day}}</td>
          <td><input type="time" step="900" name="opening_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="ending_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="break_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="total_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="over_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="night_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="holiday_time[{{$days->day}}]" value="00:00"></td>
          <td><input type="time" step="900" name="holiday_night[{{$days->day}}]" value="00:00"></td>
          
          <td>
            <input type="hidden" name="holiday[{{$days->day}}]" value="0">
            <input type="checkbox" name="holiday[{{$days->day}}]" value="1">
          </td>
          <td>
            <input type="hidden" name="adsence[{{$days->day}}]" value="0">
            <input type="checkbox" name="adsence[{{$days->day}}]" value="1">
          </td>
          <td>
            <input type="hidden" name="late[{{$days->day}}]" value="0">
            <input type="checkbox" name="late[{{$days->day}}]" value="1">
          </td>
          <td>
            <input type="hidden" name="leave_early[{{$days->day}}]" value="0">
            <input type="checkbox" name="leave_early[{{$days->day}}]" value="1">
          </td>
          <td>
            <input type="hidden" name="holiday_work[{{$days->day}}]" value="0">
            <input type="checkbox" name="holiday_work[{{$days->day}}]" value="1">
          </td>
          <td>
            <input type="hidden" name="makeup_holiday[{{$days->day}}]" value="0">
            <input type="checkbox" name="makeup_holiday[{{$days->day}}]" value="1">
          </td>
        </tr>

      <input type="hidden" name="calendar_id[{{$days->day}}]" value="{{$days->day}}">

    @endforeach

      <input type="hidden" name="auth_name" value="{{Auth::user()->name}}">
      <input type="hidden" name="auth_number" value="{{Auth::user()->employee_number}}">
      <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
      <input type="hidden" name="year" value="{{date('Y')}}">
      

    </table>

    <input type="text" name="project">
    <textarea name="memo"></textarea>

    <td><input type="submit" value="送信"></td>
    <td><input type="reset" value="リセット"></td>

  </form>

</body>

@endsection