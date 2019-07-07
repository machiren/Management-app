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
		<div class="container">
			<div class="row">
				<div class="col-8 offset-4">
					<ul>
						@foreach($month as $months)
							<li><a href="/managements/{{$months->month}}/create" name="month[]">{{$months->month}}月の勤務表</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
@endsection