@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-3">
				社員ナンバー {{Auth::user()->employee_number}}				
			</div>
			<div class="col-3">
				{{Auth::user()->name}}
			</div>
		</div>
	</div>
		<div class="container mt-5 mb-4">
			<div class="row">
				<div class="col-8 offset-2">
					<div class="list-group">
						<ul>
							<li class="list-group-item list-group-item-success">
								勤務表作成
							</li>
							@foreach($month as $months)
								<li><a href="/managements/{{$months->month}}/create" class="list-group-item list-group-item-action" name="month[]">{{$months->month}}月の勤務表</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
@endsection