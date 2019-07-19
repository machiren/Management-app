@extends('layouts.app')

@section('content')

<div class="container mt-3 mb-4">
  <div class="row">
    <div class="col-6">
        社員ナンバー {{$user->employee_number}}
    </div>
    <div class="name col-6">
        {{$user->name}}
    </div>
  </div>
</div>
  <div class="container">
    <div class="row">
      <div class="col">
        <table id="management" class="table table-bordered ">
          <tr>
            <th class='month'>{{$month->month}}月</th>
            <th colspan="3" style="text-align:center">平日</th>
            <th colspan="3" style="text-align:center">休日</th>
            <th colspan="6" style="text-align:center">勤怠</th>
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
            @foreach($show_list as $show)
          <tr>
            <td>{{$show->calendar_id}}</td>
            <td class="text-center">{{rtrim(rtrim($show->opening_time,00),":")}}</td>
            <td class="text-center">{{rtrim(rtrim($show->ending_time,00),":")}}</td>
            <td class="text-center">{{rtrim(rtrim($show->break_time,00),":")}}</td>
            <td class="text-center">{{rtrim(rtrim($show->holiday_start_time,00),":")}}</td>
            <td class="text-center">{{rtrim(rtrim($show->holiday_end_time,00),":")}}</td>
            <td class="text-center">{{rtrim(rtrim($show->holiday_break_time,00),":")}}</td>
            <td class="text-center">{{$show->holiday}}</td>
            <td class="text-center">{{$show->adsence}}</td>
            <td class="text-center">{{$show->late}}</td>
            <td class="text-center">{{$show->leave_early}}</td>
            <td class="text-center">{{$show->holiday_work}}</td>
            <td class="text-center">{{$show->makeup_holiday}}</td>
          </tr>
            @endforeach
        </table>
        <table class="table table-bordered mt-4 mb-4"><tr>
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
            <td>実働合計</td>
            <td>深夜合計</td>
            <td>休暇合計</td>
            <td>欠勤合計</td>
            <td>遅刻合計</td>
            <td>早退合計</td>
            <td>休出合計</td>
            <td>振休合計</td>
          </tr>
          <tr>
            <td>{{$month->month}}月</td>
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
    <div class="container mt-2 offset-3">
      <div class="row">
        <div class="col-3 offset-1">
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
              </div>
            </div>
          </div>
          <div class="col-1">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">プロジェクト名</span>
                <span class="form-control text-nowrap">{{$summaries->project}}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
        <div class="container mt-2 mb-5">
          <div class="row">
            <div class="col col-3 offset-5 mt-2">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">備考欄</span>
                  <span class="form-control text-nowrap">{{$summaries->remarks}}</span>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
          <div class="container mb-5">
            <div class="row">
              <div class="col-1.5 offset-5">
              <a href="/admin/{{$user->id}}/{{$year->year}}/{{$month->month}}/edit" class="btn btn-lg btn-outline-success">更新画面</a>
              </div>
              <div class="col">
                <form action="/admin/{{$user->id}}/{{$year->year}}/{{$month->month}}/delete" method="POST">
                  @csrf
                  <input type="submit" class="btn btn-lg btn-outline-danger" value="削除">
                </form>
              </div>
            </div>
          </div>
@endsection