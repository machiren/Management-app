@extends('layouts.app')

@section('content')
  <body>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
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
      </div>
    </div>
      <form action="/managements" method="POST">
        <div class="container">
          <div class="row">
            <table id="management" class="table table-bordered">
              <tr>
                <th class='none'>
                  @foreach($month as $months)
                    {{$months->month}}月
                  @endforeach
                </th>
                <th colspan="3" style="text-align:center">平日</th>
                <th colspan="2" style="text-align:center">休日</th>
                <th colspan="6" style="text-align:center">チェックボックス</th>
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
                <td><input class="form-control" type="time" name="opening_time[{{$days->day}}]" min="05:00" value="09:00"></td>
                <td><input class="form-control" type="time" name="ending_time[{{$days->day}}]" min="05:00" value="18:00"></td>
                <td><input class="form-control" type="time" name="break_time[{{$days->day}}]" value="01:00"></td>
                <td><input class="form-control" type="time" name="holiday_time[{{$days->day}}]"   value="00:00"></td>
                <td><input class="form-control" type="time" name="holiday_night[{{$days->day}}]" min="00:00" max="07:00" value="00:00"></td>
                <td>
                  <input type="hidden" name="holiday[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="holiday[{{$days->day}}]" value="1">
                    </div>
                </td>
                <td>
                  <input type="hidden" name="adsence[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="adsence[{{$days->day}}]" value="1">
                    </div>
                </td>
                <td>
                  <input type="hidden" name="late[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="late[{{$days->day}}]" value="1">
                    </div>
                </td>
                <td>
                  <input type="hidden" name="leave_early[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="leave_early[{{$days->day}}]" value="1">
                    </div>
                </td>
                <td>
                  <input type="hidden" name="holiday_work[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="holiday_work[{{$days->day}}]" value="1">
                    </div>
                </td>
                <td>
                  <input type="hidden" name="makeup_holiday[{{$days->day}}]" value="0">
                    <div class="form-check">
                  <input class="form-check-input position-static" type="checkbox" name="makeup_holiday[{{$days->day}}]" value="1">
                    </div>
                </td>
              </tr>
                <input type="hidden" name="calendar_id[{{$days->day}}]" value="{{$days->day}}">
                  @endforeach
                    <input type="hidden" name="year" value="{{date('Y')}}">
                    <input type="hidden" name="month_id" value="{{$months->month}}">
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
            </table>
              <div class="container mt-6 offset-3">
                <div class="row">
                  <div class="col">
                    <div class="input-group mt-3 mb-4">
                      <div class="input-group-prepend">
                        <span class="input-group-text">始業時間</span>
                        <input type="time" class="form-control" name="official_start_time" step="900" min="05:00" required value="09:00">
                        <span class="input-group-text">終業時間</span>
                        <input type="time" class="form-control" name="official_end_time" step="900" min="05:00" required value="18:00">
                        <span class="input-group-text">休憩時間</span>
                        <input type="time" class="form-control" name="official_break_time" step="900" required value="01:00">
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="container">
                    <div class="row">
                      <div class="col-4">
                        <input type="text" class="form-control" name="customer" autocomplete="off" required placeholder="顧客名">
                      </div>
                      <div class="col-4">
                        <input type="text" class="form-control" name="project" autocomplete="off" required placeholder="プロジェクト名">
                      </div>
                    </div>
                  </div>
                    <div class="container mt-4">
                      <div class="row">
                        <div class="col-8">
                        <textarea class="form-control" name="remarks" autocomplete="off" placeholder="備考欄"></textarea>
                      </div>
                    </div>
                  </div>
                <div class="container mt-4 mb-5">
                  <div class="row">
                    <div class="col-4 offset-3">
                      <button type="submit" class="btn btn-lg btn-outline-success">送信</button>
                        <button type="reset" class="btn btn-lg btn-outline-warning">リセット</button>
                      </div>
                    </div>
                  </div>
              </form>
          </body>
@endsection