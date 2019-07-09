{{-- @extends('layaouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class='col-3'>
				社員ナンバー {{Auth::user()->employee_number}}
			</div>
  		<div class="col-3">
				{{Auth::user()->name}}
			</div>
		</div>
	</div>
	<div class="container">
      <div class="row">    
        <table id="management" class="table table-bordered ">
          <tr>
            <th class='none'></th>
            <th colspan="5" style="text-align:center">平日</th>
            <th colspan="2" style="text-align:center">休日</th>
            <th colspan="4" style="text-align:center">勤怠</th>
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
          @foreach($confirm as $confirms)
          <tr>
            <td>{{$confirms->calendar_id}}</td>
            <td>{{$confirms->opening_time}}</td>
            <td>{{$confirms->ending_time}}</td>
            <td>{{$confirms->break_time}}</td>
            <td>{{$confirms->holiday_time}}</td>
            <td>{{$confirms->holiday_night}}</td>
            <td>{{$confirms->holiday}}</td>
            <td>{{$confirms->adsence}}</td>
            <td>{{$confirms->late}}</td>
            <td>{{$confirms->leave_early}}</td>
            <td>{{$confirms->holiday_work}}</td>
            <td>{{$confirms->makeup_holiday}}</td>
          </tr>
          @endforeach
       	 </table>
						<div class="container mt-4 mb-4">
							<div class="row">
								<table class="management table table-bordered">
									<div class="col-6">                
										<tr>
											<td>
											@foreach($confirm as $confirms)
												{{$confirms->official_start_time}}
												{{$confirms->official_end_time}}
												{{$confirms->official_bleak_time}}
											</td>
									</div>
									<div class="col-6">
										<td>
											{{$confirms->customer}}
											{{$confirms->project}}
											{{$confirms->remarks}}
												@endforeach
										</td>
									</tr>
								</div>
							</div>
						</table>
					</div>
				</div> 
@endsection --}}