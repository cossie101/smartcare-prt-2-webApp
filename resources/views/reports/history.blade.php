@extends('layouts.pdf')

@section('content')

<div style="width: 100%;">
	
	<table style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 3%;">#</th>
				<th>Doctor</th>
				<th>Disease</th>
				<th>Symptoms</th>
				<th>Date</th>
			</tr>
		</thead>

		<tbody>
			@if( count($d) != 0)
				<?php $i = 1; ?>
				@foreach( $d as $key => $diagnosis)
					<tr>
						<td>{{ $i }}</td>
						<td style="width: 25%;">{{ App\Diagnosis::doctor2($key) }}</td>
						<td>{{ App\Diagnosis::disease($key) }}</td>
						<td>
							@foreach( $diagnosis as $symptom )
								{{ $symptom->symptom()->symptom }},
							@endforeach
						</td>
						<td>{{ App\Diagnosis::date($key) }}</td>
					</tr>
					<?php $i++; ?>
				@endforeach
			@else
				<tr>
					<td colspan="7">You have 0 medical disgnosis</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

@endsection