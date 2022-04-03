@extends('layouts.main')

@section('content')


<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">Payments</h6>

		<hr>
	</div>

	<div class="mt-2 col-sm-12">
		<table class="table table-sm table-bordered table-striped table-hover">
			<thead>
				<th>#</th>
				<th>Patient</th>
				<th>Amount</th>
				<th>Reference</th>
				<th></th>
			</thead>
			<tbody>
				@if( count($payments) != 0)
					<?php $i = 1; ?>
					@foreach( $payments as $payment )
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $payment->patient() }}</td>
							<td>{{ $payment->amount }}</td>
							<td>{{ $payment->reference }}</td>
							<td></td>
						</tr>
						<?php $i++; ?>
					@endforeach
				@else
					<tr><td colspan="5">You have 0 posted payments</td></tr>
				@endif
			</tbody>
		</table>
	</div>
</div>


@endsection