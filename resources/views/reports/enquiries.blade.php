@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 3%;">#</th>
				<th>Patient</th>
				<th>Title</th>
				<th>Description</th>
				<th>Date</th>
			</tr>
		</thead>

		<tbody>
			@if( count($enquiries) != 0)
				<?php $i = 1; ?>
				@foreach( $enquiries as $enquiry)
					<tr>
						<td>{{ $i }}</td>
						<td style="width: 25%;">{{ $enquiry->patient()->name }}</td>
						<td>{{ $enquiry->title }}</td>
						<td>{{ $enquiry->description }}</td>
						<td>{{ date('d-m-Y H:i', strtotime($enquiry->created_at)) }}</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr>
					<td colspan="7">You have 0 registered enquiries</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

@endsection