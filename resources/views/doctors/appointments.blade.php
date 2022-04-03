@extends('layouts.main')

@section('content')

	<div class="p-2">
		<div class="col-sm-12 mt-3">

			<h6 class="text-info">Appointment Management</h6>
			<!-- <a href="{{ URL::to('add/doctor') }}" class="btn btn-info text-white px-5 mb-4 float-right" style="margin-top: -35px;"> New Doctor</a> -->
		</div>

		<div class="col-sm-12 mt-2">
			@if( Session::get('message') )
				<div class="alert alert-success col-sm-11">
					{{ Session::get('message') }}
					<a href="" class="close" data-dismiss="alert">&times;</a>
				</div>
			@endif
		</div>

		<hr class="mx-5">


		<div class="col-sm-12">
			<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="#assigned" data-toggle="tab" role="tab" class="nav-link active">New</a>
					</li>
					<li class="nav-item">
						<a href="#unassigned" data-toggle="tab" role="tab" class="nav-link">Unassigned</a>
					</li>
					<li class="nav-item">
						<a href="#solved" data-toggle="tab" role="tab" class="nav-link">Complete</a>
					</li>
				</ul>
		</div>

		<div class="col-sm-12">
			<div class="tab-content">
				<div class="tab-pane active show fade d-inline-flex col-sm-12" id="assigned">
					
					<div class="col-sm-4 border border-silver rounded mt-2" style="height: 68vh;">
						@foreach( $appointments as $appointment )
						<a href="javascript:void(0)" id="{{ $appointment->id }}" onclick="loadAppointment(this.id)" style="text-decoration: none;">
							<div class="col-sm-12 p-2 mt-3">
								<div class="col-sm-12">
									<h6 class="text-warning">{{ $appointment->name() }},</h6>
								</div>
								<div class="col-sm-12">
									<h5 class="text-secondary">{{ $appointment->title }}</h5>
								</div>
								<div class="col-sm-12">
									<h6 style="text-overflow: ellipsis; overflow-x: hidden; white-space: nowrap; height: 4vh;">{{ $appointment->description }}</h6>
								</div>
							</div>
						</a>
						<hr class="mx-5 my-2">
						@endforeach
					</div>

					<div class="col-sm-8 border card border-silver rounded ml-2 mt-2">

						<div class="card-heading bg-light row d-flex justify-content-center p-2">
							<h6 class="text-primary">Appointment  Manager</h6>
						</div>

						<div  class="card-body p-2">
								<h6 id="divaddress" class="text-secondary" style="margin-top: 100px; margin-left: 30%;">Select an appointment to address it</h6>
							


							<div class="card border border-light" id="divappointment"><!-- Start of enquiry card view -->
								
								<div class="card-heading bg-light d-inline-flex p-2">
									<div class="col-md-8">
										<h6 class="text-warning"><span id="name"></span><span class="text-secondary">,</span></h6>
									</div>
									<div class="col-sm-4 d-inline-flex">
										<a href="javascript:void(0)" id="updatestatus" title="Update appointment status" ><i class="fa fa-edit text-info"></i></a> &nbsp;&nbsp;
										<a href="javascript:void(0)" data-toggle="modal" data-target="#completeappointment" title="Complete appointment" onclick="completeAppointment(this.namess)" id="completelink" namess="" ><i class="fa fa-check text-info"></i></a>
									</div>
								</div>

								<div class=" card-body">
									<div class="col-sm-12 d-flex justify-content-center">
										<h4 id="title" class="text-secondary"></h4>
									</div>
									<h6 class="text-dark" id="appointment"> </h6>

									<form method="POST" class="mt-2" action="{{ URL::to('save/status') }}">
										{{ csrf_field() }}
											<input type="hidden" name="id" id="appointment_id" value="">
									
										<div class="input-group" id="status">
											<input type="text" class="form-control col-md-10 ml-3" placeholder="Update status ... " aria-label="status update" name="status" >
											<div class="input-group-append">
												<div class="input-group-text">
													<button type="submit" title="Save appointment status..." style="border:none; fill: transparent;"><i class="text-secondary material-icons" style="font-size: 0.8em;">Send</i></button>
												</div>
											</div>
										  
										</div>
									</form>
								</div>

								<div class="card-footer d-inline-flex">
									
									<div class="col-md-4">
										<h6 class="text-secondary" style="font-size: 0.8em" id="datee"></h6>
									</div>
								</div>
							</div><!-- End of appointment card view -->

							<div class="col-sm-12 mt-5" id="appointment_status_div">
								<div class="col-sm-12 d-flex justify-content-center">
									<h6 class="text-info">Appointment Status</h6>
								</div>
								<div class="col-sm-12" >
									<table class="table table-sm table-bordered table-striped table-hovered">
										<thead>
											<th style="width: 5%;">#</th>
											<th>Status</th>
											<th>Author</th>
											<th>Date</th>
										</thead>
										<tbody id="table_status">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
					</div>
				</div>



				<div class="tab-pane fade" id="unassigned">
					fg
				</div>


				<div class="tab-pane fade" id="solved">
					vsdvs
				</div>
			</div>
		</div>
	</div>








	<script type="text/javascript">

	$(document).ready( function(){


		$("#divappointment").hide();
		$("#status").hide();
		$("#appointment_status_div").hide();

		$("#updatestatus").click( function(){
			$("#status").toggle('slow');
		});
	
	});


		function loadAppointment(appointment){
			$("#divaddress").hide();
			$("#status").hide();
			$("#divappointment").show();

			$.get("{{ url('get/appointment') }}", { id: appointment }, function(data){
				$("#name").text(data.name);
				$("#appointment").text(data.description);
				$("#datee").text(data.date);
				$("#title").text(data.title);
				$("#enquiry_id").val(appointment);
			});

			$("#appointment_status_div").show();

			$.get("{{ url('get/appointment/status') }}", { id: appointment }, function(data2){

				var i = 1;

				//alert("Timo");
				$.each(data2, function(key, value){
					//alert(value.status);
					$("#table_status").append("<tr><td>"+i+"</td><td>"+value.status+"</td><td>"+value.user+"</td><td>"+value.date+"</td></tr>");
					i++;
				});
			});
		}
</script>


@endsection