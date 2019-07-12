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
      <table id="management" class="table table-bordered ">
        <tr>
          <th class='month'>{{$month->month}}月</th>
          <th colspan="3" style="text-align:center">平日</th>
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
          @foreach($show_list as $show)
        <tr>
          <td>{{$show->calendar_id}}</td>
          <td>{{$show->opening_time}}</td>
          <td>{{$show->ending_time}}</td>
          <td>{{$show->break_time}}</td>
          <td>{{$show->holiday_time}}</td>
          <td>{{$show->holiday_night}}</td>
          <td>{{$show->holiday}}</td>
          <td>{{$show->adsence}}</td>
          <td>{{$show->late}}</td>
          <td>{{$show->leave_early}}</td>
          <td>{{$show->holiday_work}}</td>
          <td>{{$show->makeup_holiday}}</td>
        </tr>
          @endforeach
      </table>
      </div>
    </div>
  </div>
  <div class="container mt-2 offset-3">
    <div class="row">
      <div class="col-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">給与計算用欄</span>
            <div class="form-control">後程</div>
          </div>
        </div>
      </div>
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
              <span class="input-group-text">プロジェクト名</span>
              <span class="form-control text-nowrap">{{$summaries->project}}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mb-5">
      <div class="row">
        <div class="col col-3 offset-3">
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
			<div class="rou">
				<div class="col">
				<a href="/admin/{{$user->id}}/{{$year->year}}/{{$month->month}}/edit" class="btn btn-lg btn-outline-success">更新</a>
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