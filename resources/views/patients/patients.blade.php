@extends('layouts.main')

@section('content')

<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">Patients Data Management</h6>

		<div class="d-inline-flex float-right" style="margin-top: -35px;">
			<a href="{{ URL::to('add/patient') }}" class="btn btn-info text-white px-3  mr-2" > New Patient</a>
			<a href="{{ URL::to('subscribe/patient') }}" class="btn btn-info text-white px-3 " > Pay Subscription</a>

			<a href="{{ URL::to('medical/history') }}" class="btn btn-info text-white px-3 ml-2" >Medical History</a>
		</div>

		<hr>
	</div>

	
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a href="#subscribed" data-toggle="tab" role="tab" class="nav-link active">Subscribed</a>
			</li>

			<!-- <li class="nav-item">
				<a href="#unsubscribed" data-toggle="tab" role="tab" class="nav-link">Unsubscribed</a>
			</li> -->
		</ul>
	</div>


	<div class="tab-content">
		<div class="tab-pane col-sm-12 active fade active show" id="subscribed">
			<div class="col-sm-12 mt-2">
				<h6 class="text-info">Subscribed Patients</h6>
			</div>

			<div class="mt-2 col-sm-12">
				<table class="table table-sm table-bordered table-striped table-hover">
					<thead>
						<th style="width: 3%;">#</th>
						<th>Account</th>
						<th>Name</th>
						<th>Phone</th>
						<th>ID NO</th>
						<th>Email</th>
						<th>Date Created</th>
						<th></th>
					</thead>

					<tbody>
						@if( count($patients) != 0)
							<?php $i = 1; ?>
							@foreach( $patients as $patient )
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $patient->account }}</td>
									<td>{{ $patient->name }}</td>
									<td>{{ $patient->phone }}</td>
									<td>{{ $patient->idno }}</td>
									<td>{{ $patient->email }}</td>
									<td>{{ date('F j, Y, H:i:s', strtotime( $patient->created_at )) }}</td>
									<td></td>
								</tr>
								<?php $i++ ?>
							@endforeach
						@else
							<tr><td colspan="9">You have 0 subscriptions</td></tr>
						@endif
					</tbody>
				</table>
				{{ $patients->onEachSide(5)->links() }}
			</div>
		</div>


		<!-- <div class="tab-pane fade col-sm-12" id="unsubscribed">
			<div class="col-sm-12 mt-2">
				<h6 class="text-info">Unsubscrined Patients</h6>
			</div>

			<div class="mt-2 col-sm-12">
				<table class="table table-sm table-bordered table-striped table-hover">
					<thead>
						<th style="width: 3%;">#</th>
						<th>Name</th>
						<th>Phone</th>
						<th>ID NO</th>
						<th>Email</th>
						<th>Date Created</th>
						<th></th>
					</thead>

					<tbody>
						@if( count($unsubscribed) != 0)
							<?php $i //= 1; ?>
							@foreach( $unsubscribed as $patient )
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $patient->name }}</td>
									<td>{{ $patient->phone }}</td>
									<td>{{ $patient->idno }}</td>
									<td>{{ $patient->email }}</td>
									<td>{{ date('F j, Y, H:i:s', strtotime( $patient->created_at )) }}</td>
									<td></td>
								</tr>
								<?php $i++ ?>
							@endforeach
						@else
							<tr><td colspan="7">You have 0 registered patients</td></tr>
						@endif
					</tbody>
				</table>
				{{ $unsubscribed->onEachSide(5)->links() }}
			</div>
		</div> -->
	</div>



</div>
	



@endsection