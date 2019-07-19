@extends('layouts.app')

@section('content')

  <div class="container mt-3 mb-6">
    <div class="row">
      <div class="employee_number col-6">
        社員ナンバー {{Auth::user()->employee_number}}
      </div>
      <div class="name col-4">
        {{Auth::user()->name}}
      </div>
    </div>
  </div>
  <div class="container mt-4">
    <div class="row">
      <table id="management" class="table table-bordered ">
        <tr>
          <th class='none'>{{$month->month}}月</th>
          <th class="text-center" colspan="3">平日</th>
          <th class="text-center" colspan="3">休日</th>
          <th class="text-center" colspan="6">勤怠</th>
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
          <th class="text-center">休暇</th>
          <th class="text-center">欠勤</th>
          <th class="text-center">遅刻</th>
          <th class="text-center">早退</th>
          <th class="text-center">休出</th>
          <th class="text-center">振休</th>
        </tr>
          @foreach($management as $managements)
        <tr>
          <td>{{$managements->calendar_id}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->opening_time,00),":")}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->ending_time,00),":")}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->break_time,00),":")}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->holiday_start_time,00),":")}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->holiday_end_time,00),":")}}</td>
          <td class="text-center">{{rtrim(rtrim($managements->holiday_break_time,00),":")}}</td>
          <td class="text-center">{{$managements->holiday}}</td>
          <td class="text-center">{{$managements->adsence}}</td>
          <td class="text-center">{{$managements->late}}</td>
          <td class="text-center">{{$managements->leave_early}}</td>
          <td class="text-center">{{$managements->holiday_work}}</td>
          <td class="text-center">{{$managements->makeup_holiday}}</td>
        </tr>
        @endforeach
      </table>
      <table class="table table-bordered mt-4 mb-4">
        <tr>
          <th>{{$month->month}}月</th>
          <th class="text-center" colspan="3">平日</th>
          <th class="text-center" colspan="2">休日</th>
          <th class="text-center" colspan="6">勤怠</th>
        </tr>
        <tr>
          <td>計算</td>
          <td>実働合計</td>
          <td>8h超合計</td>
          <td>深夜合計</td>
          <td>休日合計</td>
          <td>深夜合計</td>
          <td>休暇合計</td>
          <td>欠勤合計</td>
          <td>遅刻合計</td>
          <td>早退合計</td>
          <td>休出合計</td>
          <td>振休合計</td>
        </tr>
        <tr>
          <td>合計</td>
          <td class="text-center">{{$total_work_time}}</td>
          <td class="text-center">{{$eight_over_time}}</td>
          <td class="text-center">{{$night_work_time}}</td>
          <td class="text-center">{{$holiday_work_time}}</td>
          <td class="text-center">{{$holiday_night_work_time}}</td>
          <td class="text-center">{{$total['holiday']}}</td>
          <td class="text-center">{{$total['adsence']}}</td>
          <td class="text-center">{{$total['late']}}</td>
          <td class="text-center">{{$total['leave_early']}}</td>
          <td class="text-center">{{$total['holiday_work']}}</td>
          <td class="text-center">{{$total['makeup_holiday']}}</td>
        </tr>
      </table>
      </div>
    </div>
  </div>
  <div class="container mt-2 offset-4">
      <div class="row">
        <div class="col-3">
            <div class="input-group">
              <div class="input-group-prepend">
                @foreach($summary as $summaries)
                <span class="input-group-text">始業時間</span>
                <div class="form-control">{{rtrim(rtrim($summaries->official_start_time,00),":")}}</div>
                <span class="input-group-text">終業時間</span>
                <div class="form-control">{{rtrim(rtrim($summaries->official_end_time,00),":")}}</div>
                <span class="input-group-text">休憩時間</span>
                <div class="form-control">{{rtrim(rtrim($summaries->official_break_time,00),":")}}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container mt-5 mb-4">
          <div class="row">
            <div class="col-3 offset-4">
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
            <div class="col col-3 offset-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">備考欄</span>
                  <span class="form-control text-nowrap">{{$summaries->remarks}}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
    @endforeach
    @endsection