@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table  style="width: 100%;">
		<thead style="width: 100%;">
			<tr style="width: 100%;">
				<th style="width: 5%;">#</th>
				<th style="width: 20%;">Name</th>
				<th style="width: 10%;">Account</th>
				<th style="width: 10%;">Amount</th>
				<th style="width: 10%">Subscription Date</th>
				<th style="width: 10%;">Expiry Date</th>
				<th style="width: 20%;">Remaining Days</th>
			</tr>
		</thead>
		<tbody style="width: 100%;">
			@if( count($subscriptions) != 0)
				<?php $i = 1; ?>
				@foreach( $subscriptions as $sb )
					<tr style="width: 100%;">
						<td style="width: 5%;">{{ $i }}</td>
						<td style="width: 20%;">{{ $sb->patient()->name }}</td>
						<td style="width: 15%;">{{ $sb->patient()->account }}</td>
						<td style="width: 10%;">{{ $sb->payment()->amount }}</td>
						<td style="width: 20%;">{{ date('d/m/Y', strtotime($sb->created_at)) }}</td>
						<td style="width: 15%;">{{ date('d/m/Y', strtotime($sb->expiryTime)) }}</td>
						<td style="width: 5%;">{{ round((strtotime($sb->expiryTime) - strtotime(now()))/(60 * 60 * 24)) }} days</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr><td colspan="5">You have 0 posted subscription</td></tr>
			@endif
		</tbody>
	</table>
</div>

@endsection