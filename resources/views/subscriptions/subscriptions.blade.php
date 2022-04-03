@extends('layouts.main')

@section('content')


<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">Subscriptions Manager</h6>

		<hr>
	</div>

	<div class="col-sm-12 mt-3">
		<table class="table table-sm table-hover table-striped table-bordered ">
			<thead>
				<th style="width: 3%;">#</th>
				<th>Account</th>
				<th>Name</th>
				<th>Amount</th>
				<th>Subscription Date</th>
				<th>Expiry Date</th>
				<th>Remaining Days</th>
			</thead>
			<tbody>
				@if( count($subscriptions) != 0 )
					<?php $i = 1; ?>
					@foreach( $subscriptions as $subscription)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $subscription->patient()->account }}</td>
							<td>{{ $subscription->patient()->name }}</td>
							<td>{{ $subscription->payment()->amount }}</td>
							<td>{{ date('j F, Y', strtotime($subscription->created_at)) }}</td>
							<td>{{ date('j F, Y', strtotime($subscription->expiryTime)) }}</td>
							<td>{{ round((strtotime($subscription->expiryTime) - strtotime(now()))/(60 * 60 * 24)) }} days</td>						
						</tr>
						<?php $i++; ?>
					@endforeach
				@else
					<tr>
						<td colspan="7">You have 0 subscribers! </td>
					</tr>
				@endif
			</tbody>
		</table>
		{{ $subscriptions->onEachSide(5)->links() }}
	</div>
</div>

@endsection