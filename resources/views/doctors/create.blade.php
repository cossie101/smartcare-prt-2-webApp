@extends('layouts.main')

@section('content')


<div class="p-2 mt-4 d-flex justify-content-center">
	
	<div class="col-sm-10 card">
		<div class="card-heading bg-info p-3 row d-flex justify-content-center">
			<h6 class="text-white">Add a New Doctor</h6>
		</div>

		<form method="POST" action="{{ URL::to('add/doctor') }}">
			{{ csrf_field() }}

			<div class="card-body px-5">

				@if( Session::get('message'))
					<div class="alert alert-danger col-sm-12">
						{{ Session::get('message') }}

						<a href="" class="close" data-dismiss="alert">&times;</a>
					</div>
				@endif

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Name</label>
					<input type="text" name="name" class="form-control col-sm-8" value="{{ old('name') }}" required>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Username</label>
					<input type="text" name="username" class="form-control col-sm-8" value="{{ old('username') }}" required>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Email</label>
					<input type="email" name="email" class="form-control col-sm-8" value="{{ old('email') }}">
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Phone</label>
					<input type="number" name="phone" class="form-control col-sm-8" value="{{ old('phone') }}">
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">ID NO</label>
					<input type="number" name="idno" class="form-control col-sm-8" value="{{ old('idno') }}">
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Password</label>
					<input type="password" name="password" class="form-control col-sm-8">
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Con. Password</label>
					<input type="password" name="confirm" class="form-control col-sm-8">
				</div>
			</div>



			<div class="card-footer d-flex justify-content-center mt-4 row">
				
				<button class="btn btn-md btn-info text-white px-5"> SAVE</button>
			</div>
		</form>
	</div>
</div>


@endsection