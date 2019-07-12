@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-6">
			{{$user->name}}
		</div>
		<div class="col-6">
			社員ナンバー {{$user->employee_number}}
		</div>
	</div>
</div>
<div class="container mt-4">
	<div class="row">
		<div class="col">
		<form action="/admin/update" method="POST" name="update">
		@method('PUT')
		@csrf
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
				@foreach($edit_list as $edit)
				<tr>
					<td>{{$edit->calendar_id}}</td>
					<td><input class="form-control" type="time" name="opening_time[{{$edit->id}}]" step="900" value="{{$edit->opening_time}}"></td>
					<td><input class="form-control" type="time" name="ending_time[{{$edit->id}}]" step="900" value="{{$edit->ending_time}}"></td>
					<td><input class="form-control" type="time" name="break_time[{{$edit->id}}]" step="900" value="{{$edit->break_time}}"></td>
					<td><input class="form-control" type="time" name="holiday_time[{{$edit->id}}]" step="900" value="{{$edit->holiday_time}}"></td>
					<td><input class="form-control" type="time" name="holiday_night[{{$edit->id}}]" step="900" value="{{$edit->holiday_night}}"></td>
					<td>
						<input type="hidden" name="holiday[{{$edit->id}}]" value="0">
						<input type="checkbox" name="holiday[{{$edit->id}}]" value="1">
					</td>
					<td>
						<input type="hidden" name="adsence[{{$edit->id}}]" value="0">
						<input type="checkbox" name="adsence[{{$edit->id}}]" value="1">
					</td>
					<td>
						<input type="hidden" name="late[{{$edit->id}}]" value="0">
						<input type="checkbox" name="late[{{$edit->id}}]" value="1">
					</td>
					<td>
						<input type="hidden" name="leave_early[{{$edit->id}}]" value="0">
						<input type="checkbox" name="leave_early[{{$edit->id}}]" value="1">
					</td>
					<td>
						<input type="hidden" name="holiday_work[{{$edit->id}}]" value="0">
						<input type="checkbox" name="holiday_work[{{$edit->id}}]" value="1">
					</td>
					<td>
						<input type="hidden" name="makeup_holiday[{{$edit->id}}]" value="0">
						<input type="checkbox" name="makeup_holiday[{{$edit->id}}]" value="1">
					</td>
				</tr>
				<input type="hidden" name="id[{{$edit->id}}]" value="{{$edit->id}}">
				@endforeach
			</table>
				<div class="container mt-4 mb-5">
					<div class="row">
						<div class="col-3 offset-5">
							<button type="submit" class="btn btn-lg btn-outline-success">更新</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection