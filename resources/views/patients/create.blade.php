@extends('layouts.main')


@section('content')


<div class="p-2 mt-3">
	<div class="card col-sm-12">
		<div class="card-heading row bg-info p-2  d-flex justify-content-center">
			<h6 class="text-white">Patient Registration</h6>
		</div>

		<form method="POST" action="{{ URL::to('save/patient') }}">
			{{ csrf_field() }}

			<div class="card-body p-5">
				
				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Name</label>
					<input type="text" name="name" class="col-sm-8 form-control" required>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">IDNO</label>
					<input type="number" name="idno" class="col-sm-8 form-control" required>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Phone</label>
					<input type="number" name="phone" class="col-sm-8 form-control" required>
				</div>

				

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Username</label>
					<input type="text" name="username" class="col-sm-8 form-control" value="{{ old('username') }}" required>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Password</label>
					<input type="password" name="password" class="col-sm-8 form-control" required>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Con. Password</label>
					<input type="password" name="confirm" class="col-sm-8 form-control" required>
				</div>


			</div>



			<div class="card-footer d-flex justify-content-center row">
				<button class="btn btn-md btn-info px-5 text-white">SAVE</button>
			</div>
		</form>
	</div>
</div>



@endsection