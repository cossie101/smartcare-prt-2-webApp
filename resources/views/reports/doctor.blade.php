@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 3%;">#</th>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Mobile</th>
				<th>ID NO</th>
			</tr>
		</thead>

		<tbody>
			@if( count($doctors) != 0)
				<?php $i = 1; ?>
				@foreach( $doctors as $doctor)
					<tr>
						<td>{{ $i }}</td>
						<td style="width: 25%;">{{ $doctor->name }}</td>
						<td>{{ $doctor->username }}</td>
						<td>{{ $doctor->email }}</td>
						<td>{{ $doctor->phone }}</td>
						<td>{{ $doctor->idno }}</td>
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
</div>

@endsection