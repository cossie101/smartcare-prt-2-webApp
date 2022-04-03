@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table style="width: 100%;">
					<thead style="width: 100%;">
						<tr style="width: 100%;">
							<th style="width: 3%;">#</th>
							<th>Account</th>
							<th>Name</th>
							<th>Phone</th>
							<th>ID NO</th>
							<th>Email</th>
							<th>Date Created</th>
							<th>Expiry Date</th>
							<th></th>
						</tr>
					</thead>

					<tbody style="width: 100%;">
						@if( count($patients) != 0)
							<?php $i = 1; ?>
							@foreach( $patients as $patient )
								<tr style="width: 100%;">
									<td>{{ $i }}</td>
									<td>{{ $patient->account }}</td>
									<td>{{ $patient->name }}</td>
									<td>{{ $patient->phone }}</td>
									<td>{{ $patient->idno }}</td>
									<td>{{ $patient->email }}</td>
									<td>{{ date('d/m/Y', strtotime( $patient->created_at )) }}</td>
									<td>{{ date('d/m/Y', strtotime( $patient->subscription()->expiryTime )) }}</td>
									<td></td>
								</tr>
								<?php $i++ ?>
							@endforeach
						@else
							<tr><td colspan="6">You have 0 subscriptions</td></tr>
						@endif
					</tbody>
				</table>
</div>

@endsection