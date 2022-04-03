@extends('layouts.main')

@section('content')


<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">System Logs</h6>

		<hr>
	</div>

	<form method="POST" action="{{ url('system/log') }}">
		@csrf

		<div class="col-sm-12 flex-column mt-5">
			<div class="form-group row col-sm-6">
				<label class="col-sm-3 col-form-label text-md-right">User</label>
				<select name="user" class="col-sm-7 required form-control">
					<option value="">Select a user</option>
					<option value="all">All</option>
					@foreach( $users as $user)
						<option value="{{ $user->id }}">{{ $user->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group row col-sm-6">
				<label class="col-sm-3 col-form-label text-md-right">Period</label>
				<input type="date" name="date" class="col-sm-7 form-control">
			</div>
		</div>

		<div class="d-flex justify-content-center col-sm-6 mt-5">
			<button class="px-5 btn-md btn text-white btn-info">GENERATE</button>
		</div>
	</form>
</div>


@endsection