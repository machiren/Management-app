@extends('layouts.app')

@section('content')
		<div class="container mt-5 mb-4">
			<div class="row">
				<div class="col-8 offset-2">
					<div class="list-group">
						<ul>
							<li class="list-group-item list-group-item-success">
								社員一覧
							</li>
							@foreach($member_list as $member)
                        <li><a href="/admin/year_list/{{$member->id}}" class="list-group-item list-group-item-action" name="month[]">{{$member->name}}さん</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
@endsection