@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 3%;">#</th>
				<th style="width: 15%;">Name</th>
				<th style="width: 70%">Description</th>
				<th style="width: 10%">Time</th>
			</tr>
		</thead>

		<tbody>
			@if( count($logs) != 0)
				<?php $i = 1; ?>
				@foreach( $logs as $log)
					<tr>
						<td style="width: 3%;">{{ $i }}</td>
						<td style="width: 15%;">{{ $log->user()->name }}</td>
						<td style="width: 70%;">{{ $log->description }}</td>
						<td style="width: 10%">{{ date('H:i:s', strtotime($log->created_at)) }}</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr>
					<td colspan="7">There are 0 system logs for the selected period/user</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

@endsection