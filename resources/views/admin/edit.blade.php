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
<form action="/admin/update" method="POST" name="update">
	@method('PUT')
	@csrf
<div class="container mt-4">
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
					<td><input class="form-control" type="time" name="opening_time[{{$edit->id}}]" value="{{$edit->opening_time}}"></td>
					<td><input class="form-control" type="time" name="ending_time[{{$edit->id}}]" value="{{$edit->ending_time}}"></td>
					<td><input class="form-control" type="time" name="break_time[{{$edit->id}}]" value="{{$edit->break_time}}"></td>
					<td><input class="form-control" type="time" name="holiday_start_time[{{$edit->id}}]" value="{{$edit->holiday_start_time}}"></td>
					<td><input class="form-control" type="time" name="holiday_end_time[{{$edit->id}}]" value="{{$edit->holiday_end_time}}"></td>
					<td><input class="form-control" type="time" name="holiday_break_time[{{$edit->id}}]" value="{{$edit->holiday_break_time}}"></td>
					<td>
						<input type="hidden" name="holiday[{{$edit->id}}]" value="0">
						<input type="checkbox" name="holiday[{{$edit->id}}]" value="1" {{$edit->holiday ? 'checked' : ''}}>
					</td>
					<td>
						<input type="hidden" name="adsence[{{$edit->id}}]" value="0">
						<input type="checkbox" name="adsence[{{$edit->id}}]" value="1" {{$edit->adsence ? 'checked' : ''}}>
					</td>
					<td>
						<input type="hidden" name="late[{{$edit->id}}]" value="0">
						<input type="checkbox" name="late[{{$edit->id}}]" value="1" {{$edit->late ? 'checked' : ''}}>
					</td>
					<td>
						<input type="hidden" name="leave_early[{{$edit->id}}]" value="0">
						<input type="checkbox" name="leave_early[{{$edit->id}}]" value="1" {{$edit->leave_early ? 'checked' : ''}}>
					</td>
					<td>
						<input type="hidden" name="holiday_work[{{$edit->id}}]" value="0">
						<input type="checkbox" name="holiday_work[{{$edit->id}}]" value="1" {{$edit->holiday_work ? 'checked' : ''}}>
					</td>
					<td>
						<input type="hidden" name="makeup_holiday[{{$edit->id}}]" value="0">
						<input type="checkbox" name="makeup_holiday[{{$edit->id}}]" value="1" {{$edit->makeup_holiday ? 'checked' : ''}}>
					</td>
				</tr>
				<input type="hidden" name="id[{{$edit->id}}]" value="{{$edit->id}}">
				<input type="hidden" name="user_id" value="{{$user->id}}">
				@endforeach
			</table>
		</div>
	</div>
</div>
<div class="container mt-6 offset-4">
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
		<div class="col-3 offset-5">
			<button type="button" class="btn btn-lg btn-outline-success" data-toggle="modal" data-target="#bd-example-modal-xl">更新</button>
			<div class="modal fade bd-example-modal-xl" id="bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="bd-example-modal-xl" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="bd-example-modal-xl">本当に更新しますか？</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">更新する内容を確認した後、更新ボタンを押してください。</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-outline-secondary" data-dismiss="modal">閉じる</button>
							<button type="submit" class="btn btn-outline-success">更新</button>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

