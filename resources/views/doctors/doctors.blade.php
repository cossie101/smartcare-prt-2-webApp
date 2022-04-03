@extends('layouts.main')

@section('content')

<div class="p-2">
	<div class="col-sm-12 mt-3">

		<h6 class="text-info">Doctor's Dashboard</h6>
		<a href="{{ URL::to('add/doctor') }}" class="btn btn-info text-white px-5 mb-4 float-right" style="margin-top: -35px;"> New Doctor</a>
	</div>

	<div class="col-sm-12 mt-2">
		@if( Session::get('message') )
			<div class="alert alert-success col-sm-11">
				{{ Session::get('message') }}
				<a href="" class="close" data-dismiss="alert">&times;</a>
			</div>
		@endif
	</div>


	<div class="col-sm-12 mt-2 px-4">
		<table class="table table-sm table-striped table-bordered table-hover">
		
			<thead>
				<th style="width: 3%;">#</th>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>ID NO</th>
				<th></th>
			</thead>

			<tbody>
				@if( count($doctors) != 0)
					<?php $i = 1; ?>
					@foreach( $doctors as $doctor)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $doctor->name }}</td>
							<td>{{ $doctor->username }}</td>
							<td>{{ $doctor->email }}</td>
							<td>{{ $doctor->phone }}</td>
							<td>{{ $doctor->idno }}</td>
							<td></td>
						</tr>
						<?php $i++; ?>
					@endforeach
				@else
					<tr>
						<td colspan="7">You have 0 registered doctors</td>
					</tr>
				@endif
			</tbody>
		</table>
		{{ $doctors->onEachSide(5)->links() }}
	</div>


</div>

@endsection