@extends('layaouts.app')

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
@endsection