@extends('layouts.main')

@section('content')


<div class="p-2 mt-4 d-flex justify-content-center">
	
	<div class="col-sm-10 card">
		<div class="card-heading bg-info p-3 row d-flex justify-content-center">
			<h6 class="text-white">New Disease</h6>
		</div>

		<form method="POST" action="{{ URL::to('add/disease') }}">
			{{ csrf_field() }}

			<div class="card-body px-5">

				@if( Session::get('message'))
					<div class="alert alert-danger col-sm-12">
						{{ Session::get('message') }}

						<a href="" class="close" data-dismiss="alert">&times;</a>
					</div>
				@endif

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Code</label>
					<input type="text" name="code" class="form-control col-sm-8" value="{{ old('code') }}" required>
				</div>

				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Disease</label>
					<input type="text" name="disease" class="form-control col-sm-8" value="{{ old('disease') }}" required>
				</div>


				<div class="form-group row">
					<label class="col-sm-3 col-form-label text-md-right">Symptoms</label>
					@foreach( $symptoms as $symptom )
						<div class="col-sm-8">
							<input type="checkbox" class="col-form-label" name="check{{$symptom->id}}" value="{{ $symptom->id }}">
						   <label class="col-form-label">{{ $symptom->symptom }}</label>
						</div>
					@endforeach
				</div>
			</div>



			<div class="card-footer d-flex justify-content-center mt-4 row">
				
				<button class="btn btn-md btn-info text-white px-5"> SAVE</button>
			</div>
		</form>
	</div>
</div>


<div class="col-sm-12 mt-5">
		<table class="table table-sm table-hovered table-striped table-bordered">
			<thead>
				<th>#</th>
				<th>Code</th>
				<th>Disease</th>
			</thead>

			@if( count($diseases) != 0)
				<?php $i = 1; ?>
				@foreach( $diseases as $disease )
					<tr>
						<td>{{ $i }}</td>
						<td>{{ $disease->code }}</td>
						<td>{{ $disease->disease }}</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr>
					<td colspan="3">0 diseases have been registered</td>
				</tr>
			@endif
		</table>
	</div>



@endsection