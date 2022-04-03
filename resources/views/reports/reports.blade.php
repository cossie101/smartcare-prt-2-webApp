@extends('layouts.main')

@section('content')


<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">Reports</h6>

		<hr>
	</div>

	<form method="POST" action="{{ URL::to('reports') }}">
		@csrf
		<div class="col-sm-12">
			<div class="form-group row">
					<label class="col-sm-1 ml-5 col-form-label text-md-right">Report</label>
					<select class="col-sm-7 form-control" name="report">
						<option value="">Select a report</option>
						<option value="payment">Payment</option>
						<!-- <option value="subscription">Subscription</option> -->
						<option value="patient">Patient</option>
						<option value="doctor">Doctor</option>
						<option value="enquiry">Enquiry</option>
						<option value="history">Medical History</option>
					</select>
				</div>
		</div>

		<div class="mt-2 col-sm-12 d-inline-flex">
			<div class="col-sm-4">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label text-md-right">User Type</label>
					<select class="col-sm-8 form-control" name="userType" id="userType">
						<option value="">Select a User type</option>
						<option value="doctor">Doctor</option>
						<option value="patient">Patient</option>
						<option value="admin">Admin</option>
					</select>
				</div>
			</div>

			

			<div class="col-sm-4" >
				<div class="form-group row" id="date">
					<label class="col-sm-4 col-form-label text-md-right">Date</label>
					<input type="date" name="date" class="col-sm-8 form-control">
				</div>
			</div>
		</div>

		<div class="col-sm-12 d-inline-flex">
			
			<div class="col-sm-4">
				<div class="form-group row" id="doctor">
					<label class="col-sm-4 col-form-label text-md-right">Doctor</label>
					<select class="col-sm-8 form-control" name="doctor" id="doctor">
						<option value="">Select a Doctor</option>
						@foreach( $doctors as $doctor )
							<option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-4" id="patient">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label text-md-right">Patient</label>
					<select class="col-sm-8 form-control" name="patient" id="patient">
						<option value="">Select a Patient</option>
						@foreach( $patients as $patient )
							<option value="{{ $patient->id}}">{{ $patient->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="col-sm-4" id="admin">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label text-md-right">Admin</label>
					<select class="col-sm-8 form-control" name="admin" id="admin">
						<option value="">Select a Admin</option>
						@foreach( $admin as $a )
							<option value="{{ $a->id}}">{{ $a->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>


		<div class="col-sm-8 mt-5 d-flex justify-content-center">
			<button class="btn btn-md btn-info px-5">GENERATE</button>
		</div>
	</form>
</div>



<script type="text/javascript">
	
	$(document).ready( function(){

		$("#patient").hide();
		$("#doctor").hide();
		$("#admin").hide();

		$("#userType").change( function(){

			var type = $(this).val();

			if( type == '' ){

				$("#doctor").hide();
				$("#patient").hide();
				$("#admin").hide();

			}else if( type == 'patient' ){

				$("#patient").show();
				$("#doctor").hide();
				$("#admin").hide();

			}else if( type == 'doctor' ){

				$("#patient").hide();
				$("#doctor").show();
				$("#admin").hide();

			}else if( type == 'admin' ){

				$("#patient").hide();
				$("#doctor").hide();
				$("#admin").show();

			}
		});
	});
</script>


@endsection