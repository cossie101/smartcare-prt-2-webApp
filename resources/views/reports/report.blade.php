@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table  style="width: 100%;">
		<thead style="width: 100%;">
			<tr style="width: 100%;">
				<th style="width: 5%;">#</th>
				<th style="width: 20%;">Name</th>
				<th style="width: 10%;">Amount</th>
				<th style="width: 40%;">Reference</th>
				<th style="width: 20%;">Date</th>
			</tr>
		</thead>
		<tbody style="width: 100%;">
			@if( count($payments) != 0)
				<?php $i = 1; ?>
				@foreach( $payments as $payment )
					<tr style="width: 100%;">
						<td style="width: 5%;">{{ $i }}</td>
						<td style="width: 20%;">{{ $payment->patient() }}</td>
						<td style="width: 10%;">{{ $payment->amount }}</td>
						<td style="width: 40%;">{{ $payment->reference }}</td>
						<td style="width: 20%;">{{ date('d/m/y', strtotime($payment->created_at)) }}</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr><td colspan="5">You have 0 posted payments</td></tr>
			@endif
		</tbody>
	</table>
</div>

@endsection