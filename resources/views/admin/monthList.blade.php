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
								月一覧
							</li>
							@foreach($month_list as $month)
								<li><a href="" class="list-group-item list-group-item-action" name="month[]">{{$month->month_id}}月</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
@endsection