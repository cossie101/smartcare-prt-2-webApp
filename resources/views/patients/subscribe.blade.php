@extends('layouts.main')

@section('content')

<div class="p-2 mt-3">

	<div class="card col-sm-12">
		<div class="card-heading row bg-info d-flex justify-content-center p-2">
			<h6 class="text-white">Patient Subscription</h6>
			@if(Session::get('message') != null)
				<h6 class="text-white">{{Session::get('message')}}</h6>
			@endif
		</div>

		<form action="{{ URL::to('subscribe/patient') }}" method="POST">
			{{ csrf_field() }}

			<div class="card-body px-5">
				
				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">ID NO</label>
					<input type="number" name="idno" class="col-sm-8 form-control" id="idno" value="{{ old('idno') }}" required>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Name</label>
					<input type="text" name="name" class="col-sm-8 form-control" id="name" value="{{ old('name') }}" required readonly>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Phone</label>
					<input type="number" name="phone" class="col-sm-8 form-control" id="phone" value="{{ old('phone') }}" required readonly>
				</div>

				<div class="form-group row">
					<label class="text-md-right col-form-label col-sm-3">Amount</label>
					<input type="number" name="amount" class="col-sm-8 form-control" value="{{ old('amount') }}" required>
				</div>

			</div>


			<div class="card-footer justify-content-center d-flex row">
				<div class="d-inline-flex">
					<a href="javascript:void(0)" id="searchPatient" class="btn btn-md btn-info px-5 mr-3 text-white">Search </a>
					<button class="btn btn-md btn-info px-5 mr-3 text-white">Save</button>
				</div>
			</div>
		</form>
	</div>
	
</div>



<script type="text/javascript">
	
	$(document).ready( function(){


		$("#searchPatient").click( function(){

			var patient = $("#idno").val();

			if( patient == ""){
				alert("Please enter the Patient ID Number");
			}else{

				$.get("{{ url('get/patient') }}", { idno: patient}, function(data){
					if( data == ""){
						alert("You entered an unregistered Patient ID Number");
					}else{
						$("#name").val(data.name);
						$("#phone").val(data.phone);
					}
				});
			}
		});

	});
</script>


@endsection