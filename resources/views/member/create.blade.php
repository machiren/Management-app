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
@csrf
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
        <th colspan="3" style="text-align:center">休日</th>
        <th colspan="6" style="text-align:center">チェックボックス</th>
      </tr>
      <tr>
        <th>日付</th>
        <!-- <th>曜日</th> -->
        <th>始業時刻</th>
        <th>終業時刻</th>
        <th>休憩時間</th>
        <th>始業時刻</th>
        <th>終業時刻</th>
        <th>休憩時間</th>
        <th>休暇</th>
        <th>欠勤</th>
        <th>遅刻</th>
        <th>早退</th>
        <th>休出</th>
        <th>振休</th>
      </tr>
      @foreach($day as $days)
      <tr>
        <td>{{$days->day}}</td>
        <td><input class="form-control" type="time" name="opening_time[{{$days->day}}]" min="05:00" value="09:00"></td>
        <td><input class="form-control" type="time" name="ending_time[{{$days->day}}]" min="05:00" value="18:00"></td>
        <td><input class="form-control" type="time" name="break_time[{{$days->day}}]" value="01:00"></td>
        <td><input class="form-control" type="time" name="holiday_start_time[{{$days->day}}]" value="00:00"></td>
        <td><input class="form-control" type="time" name="holiday_end_time[{{$days->day}}]" value="00:00"></td>
        <td><input class="form-control" type="time" name="holiday_break_time[{{$days->day}}]" value="00:00"></td>
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
  </div>
</div>
<div class="container mt-6">
  <div class="row">
    <div class="col offset-3">
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
</div>
<div class="container">
  <div class="row">
    <div class="offset-2 col-4">
      <input type="text" class="form-control" name="customer" autocomplete="off" required placeholder="顧客名">
    </div>
    <div class="col-4">
      <input type="text" class="form-control" name="project" autocomplete="off" required placeholder="プロジェクト名">
    </div>
  </div>
</div>
<div class="container mt-4">
  <div class="row">
    <div class="offset-2 col-8">
      <textarea class="form-control" name="remarks" autocomplete="off" placeholder="備考欄"></textarea>
    </div>
  </div>
</div>
<div class="container mt-4 mb-5">
  <div class="row">
    <div class="col-4 offset-5">
      <button type="button" class="btn btn-lg btn-outline-success" data-toggle="modal" data-target="#bd-example-modal-xl">登録</button>
      <!-- Modal -->
      <div class="modal fade bd-example-modal-xl" id="bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="bd-example-modal-xl" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="bd-example-modal-xl">この内容で登録しますか？</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              登録する内容を確認した後、登録ボタンを押してください。
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
              <button type="submit" class="btn btn-outline-success">送信</button>
            </form>
            </div>
          </div>
        </div>
      </div>
      <button type="reset" class="btn btn-lg btn-outline-warning">リセット</button>
    </div>
  </div>
</div>
</body>
@endsection

