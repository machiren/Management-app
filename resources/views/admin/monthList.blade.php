@extends('layouts.app')

@section('content')
		<div class="container mt-5 mb-4">
			<div class="row">
				<div class="col-8 offset-2">
					<div class="list-group">
						<ul>
							<li class="list-group-item list-group-item-success">
							{{$year->year}}年の月一覧
							</li>
							@foreach($month_list as $month)
						<li><a href="/admin/show_list/{{$user->id}}/{{$year->year}}/{{$month->month_id}}" class="list-group-item list-group-item-action" name="month[]">{{$month->month_id}}月の勤務表</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
@endsection