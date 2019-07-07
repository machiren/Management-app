@extends('layouts.app')

@section('content')

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-4">
          {{date('Y')}}年
        </div>
        <div class='col-4'>
          {{Auth::user()->name}}
        </div>
        <div class='col-4'>
          社員ナンバー {{Auth::user()->employee_number}}
        </div>
        <div class="col-2">
          @foreach($month as $months)
            {{$months->month}}月の勤務表入力する
          @endforeach
        </div>
      </div>
    </div>
      <form action="/managements" method="POST">
        <div class="container">
          <div class="row">
            <table id="management" class="table table-bordered">
              <tr>
                <th class='none'></th>
                <th colspan="5" style="text-align:center">平日</th>
                <th colspan="2" style="text-align:center">休日</th>
                <th colspan="4" style="text-align:center">チェックボックス</th>
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
                @foreach($day as $days)
              <tr>
                <td>{{$days->day}}</td>
                <td><input type="time" step="900" name="opening_time[{{$days->day}}]" value="00:00"></td>
                <td><input type="time" step="900" name="ending_time[{{$days->day}}]" value="00:00"></td>
                <td><input type="time" step="900" name="break_time[{{$days->day}}]" value="00:00"></td>
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
                    <input type="hidden" name="year" value="{{date('Y')}}">
                    <input type="hidden" name="month_id" value="{{$days->month_id}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            </table>
              <div class="container mt-6">
                <div class="row">
                  <div class="col-4">
                    <input type="time" name="official_strat_time" step="900" required value="00:00">
                    <input type="time" name="official_end_time" step="900" required value="00:00">
                    <input type="time" name="official_bleak_time" step="900" required value="00:00">
                  </div>
                  <div class="col-4">
                    <input type="text" name="customer" autocomplete="off" required placeholder="顧客名">
                    <input type="text" name="project" autocomplete="off" required placeholder="プロジェクト名">
                    <textarea name="remarks" autocomplete="off" placeholder="備考欄"></textarea>
                  </div>
                  <div class="col-4">
                      <input type="submit" value="確認(今は送信される)">
                      <input type="reset" value="リセット">
                  </div>
                </div>
              </div>
      </form>
  </body>
@endsection