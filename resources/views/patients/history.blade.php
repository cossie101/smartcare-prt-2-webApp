@extends('layouts.main')


@section('content')


<div class="p-2 px-5 mt-3">
	<div class="card col-sm-12">
		<div class="card-heading row bg-info p-2 d-flex justify-content-center">
			<h6 class="text-white">Medical History</h6>
		</div>

		<form method="POST" action="{{ URL::to('medical/history') }}">
			{{ csrf_field() }}

			<div class="card-body p-5">
					<div class="col-sm-12 d-inline-flex">
						
						<div class="form-grouo row col-sm-8 ">
							<label class="text-md-right col-form-label col-sm-3">IDNO</label>
							<input type="number" name="idno" id="idno" class="col-sm-8 form-control" >
						</div>

						<a class="btn btn-md btn-info px-5 text-white ml-3" href="javascript:void()" id="search">SEARCH</a>
					</div>
				
				<div class="col-sm-12 d-inline-flex">
					

						<div class="col-sm-12 d-inline-flex">
							<div class="col-sm-3 flex-column">
								<label class="text-md-left col-form-label col-sm-12">Name</label>
								<label id="name" class="col-sm-12 ">
							</div>

							<div class="col-sm-3 flex-column">
								<label class="text-md-left col-form-label col-sm-12">Phone</label>
								<label id="phone" class="col-sm-12 ">
							</div>

							<div class="col-sm-6 flex-column">
								<label class="text-md-left col-form-label col-sm-12">Registration Date</label>
								<label id="reg" class="col-sm-12 ">
							</div>
					</div>
				</div>

				<div class="col-sm-12 d-inline-flex mt-4">
					<div class="col-sm-6 border border-info rounded p-2">
						
						<h6 class="text-warning">Medical Diagnosis</h6>

						<hr>
						<div class="col-sm-12 mt-2" id="history">
							
						</div>
					</div>
					<div class="col-sm-6 ml-2 p-2  border border-info rounded">
						<h6 class="text-warning">Enquiries</h6>

						<hr>

						<div class="col-sm-12" id="enquiries">
							
						</div>
					</div>
				</div>


				<div class="col-sm-12 d-inline-flex mt-4">
					<div class="col-sm-6 border border-info rounded p-2">
						
						<h6 class="text-warning">Payment Statements</h6>

						<hr>
						<div class="col-sm-12 mt-2" id="payments">
							
						</div>
					</div>
					<div class="col-sm-6 ml-2 p-2  border border-info rounded">
						<h6 class="text-warning"> ... </h6>

						<hr>

						<div class="col-sm-12" id="appointments">
							
						</div>
					</div>
				</div>




			</div>



			<div class="card-footer d-flex justify-content-center row">
				
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready( function(){

		$("#search").click( function(){

			var id = $("#idno").val();

			if( id == '' ){

				alert("Please enter patient's ID Number");
			}else{

				$.get("{{ url('get/patient') }}", { idno: id }, function(data){

					//alert(data);

					if(data == null || data == ''){

						alert("There isn't any patient under that ID number");
					}else{

						$("#name").text(data.name);
						$("#phone").text(data.phone);
						$("#reg").text(data.created_at);

						$.get("{{ url('get/enquiries') }}", { id: data.id }, function(data2){

							$.each(data2, function(key, value){

								//alert(value);

								$("#enquiries").empty();
								$("#enquiries").append("<h5 class=\"text-success\">"+value.type+",</h5><h6>"+value.bf+"</h6>"+value.created_at+"<hr class=\"mx-4\">");

								
							});
						});

						$.get("{{ url('get/statements') }}", { id: data.id }, function(data5){

								$("#payments").empty();
							$.each(data5, function(key, value){

								//alert(value);

								$("#payments").append("<div class=\"d-inline-flex\"><h6 class=\"text-success\">"+value.description+"</h6><h6>, "+value.type+", </h6></div><div class=\"d-inline-flex\"><span class=\"text-info\">"+value.amount+"</span><span class=\"ml-4\">"+value.date+"</span></div><hr class=\"mx-4\">");

								
							});
						});




						$.get("{{ url('get/history') }}", { id: data.id }, function(data3){

							//alert(data3);

							if( Object.keys(data3).length == 0 ){

								alert("The patient doesn't have any medical history in this hospital");
							}else{

								//alert(data3[0]);

								$("#history").empty();
								$.each(data3, function(key, value){

									//alert(value);

									$("#history").append("<div class=\"d-inline-flex\"><h6 class=\"text-primary\">"+value.disease+", </h6><h6> < "+value.date+" ></h6></div><h6 class=\"text-secondary\">"+value.symptom+", </h6>");

								});
							}
						});
					}
				});
			}
		});
	});
</script>



@endsection