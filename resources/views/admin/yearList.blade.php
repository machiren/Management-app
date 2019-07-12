@extends('layouts.app')

@section('content')
		<div class="container mt-5 mb-4">
			<div class="row">
				<div class="col-8 offset-2">
					<div class="list-group">
						<ul>
							<li class="list-group-item list-group-item-success">
								年一覧
							</li>
							@foreach($year_list as $year)
                        <li><a href="/admin/month_list/{{$user->id}}/{{$year->year}}" class="list-group-item list-group-item-action" name="year[]">{{$year->year}}年</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
@endsection