@extends('layouts.main')

@section('content')


<div class="p-2">
	<div class="col-sm-12 mt-3">
		<h6 class="text-info">Patients Data Management</h6>

		<hr>
	</div>

	<div class="col-sm-12">
		@if( count($enquiries) != 0 )
			<div  class="col-sm-12">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="#unclosed" class="nav-link active">Unclosed</a>
					</li>
					<li class="nav-item">
						<a href="#solved" class="nav-link">Solved</a>
					</li>
				</ul>
			</div>

			<div class="tab-content">
				<div class="tab-pane fade active show col-sm-12 d-inline-flex" id="unclosed">
					<div class="col-sm-4 border border-silver rounded mt-2" style="height: 68vh;">
						@foreach( $enquiries as $enquiry )
						<a href="javascript:void(0)" id="{{ $enquiry->id }}" onclick="loadEnquiry(this.id)" style="text-decoration: none;">
							<div class="col-sm-12 p-2 mt-3">
								<div class="col-sm-12">
									<h5 class="text-secondary">{{ $enquiry->title }}</h5>
								</div>
								<div class="col-sm-12">
									<h6 style="text-overflow: ellipsis; overflow-x: hidden; white-space: nowrap; height: 4vh;">{{ $enquiry->enquiry }}</h6>
								</div>
							</div>
						</a>
						<hr class="mx-5 my-2">
						@endforeach
					</div>

					<div class="col-sm-8 border card border-silver rounded ml-2 mt-2" style="height: 68vh; overflow-y: scroll;">

						<div class="card-heading bg-light row d-flex justify-content-center p-2">
							<h6 class="text-primary">Enquiry Management</h6>
						</div>

						<div  class="card-body p-2">
								<h6 id="divaddress" class="text-secondary" style="margin-top: 100px; margin-left: 30%;">Select an enquiry to address it</h6>
							


							<div class="card border border-light" id="divenquiry"><!-- Start of enquiry card view -->
								
								<div class="card-heading bg-light d-inline-flex p-2">
									<div class="col-md-8">
										<h6 class="text-warning"><span id="name"></span><span class="text-secondary">,</span></h6>
									</div>
									<div class="col-sm-4 d-inline-flex">
										<!-- <a href="javascript:void(0)" id="assessfee" title="Assess enquiry fee"><i class="fa fa-calculator text-primary"></i></a> &nbsp;&nbsp; -->
										<a href="javascript:void(0)" id="updatestatus" title="Update enquiry status" ><i class="fa fa-edit text-info"></i></a> &nbsp;&nbsp;
										<a href="javascript:void(0)" data-toggle="modal" data-target="#completecomplain" title="Complete enquiry" onclick="completeComplain(this.namess)" id="completelink" namess="" ><i class="fa fa-check text-info"></i></a>
									</div>
								</div>

								<div class=" card-body">
									<div class="col-sm-12 d-flex justify-content-center">
										<h4 id="title" class="text-secondary"></h4>
									</div>
									<h6 class="text-dark" id="enquiry"> </h6>

									<form method="POST" class="mt-2" action="{{ URL::to('save/status') }}">
										{{ csrf_field() }}
											<input type="hidden" name="enquiry_id" id="enquiry_id" value="">
									
										<div class="input-group" id="status">
											<input type="text" class="form-control col-md-10 ml-3" placeholder="Update status ... " aria-label="status update" name="status" >
											<div class="input-group-append">
												<div class="input-group-text">
													<button type="submit" title="Save enquiry status..." style="border:none; fill: transparent;"><i class="text-secondary material-icons" style="font-size: 0.8em;">send</i></button>
												</div>
											</div>
										  
										</div>
									</form>
								</div>

								<div class="card-footer d-inline-flex">
									<div class="col-md-8">
										<h6 class="text-secondary" style="font-size: 0.8em">Acc: <span id="meter_number"></span> <span class="ml-3">Account: <span id="account"></span></span></h6>
									</div>
									<div class="col-md-4">
										<h6 class="text-secondary" style="font-size: 0.8em" id="datee"></h6>
									</div>
								</div>
							</div><!-- End of enquiry card view -->
							<div class="col-sm-12 mt-5 mb-5" id="enquiry_status_div">
								<div class="col-sm-12 d-flex justify-content-center">
									<h6 class="text-info">Enquiry Status</h6>
								</div>
								<div class="col-sm-12" >
									<table class="table table-sm table-bordered table-striped table-hovered mb-5">
										<thead>
											<th style="width: 5%;">#</th>
											<th>Status</th>
											<th>Author</th>
											<th style="width: 25%;">Date</th>
										</thead>
										<tbody id="table_status">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		@else
			<h6 >You have 0 enquiries</h6>
		@endif
	</div>
</div>


<script type="text/javascript">

	$(document).ready( function(){


		$("#divenquiry").hide();
		$("#status").hide();
		$("#enquiry_status_div").hide();

		$("#updatestatus").click( function(){
			$("#status").toggle('slow');
		});
	
	});


		function loadEnquiry(enquiry){
			$("#divaddress").hide();
			$("#status").hide();
			$("#divenquiry").show();

			$.get("{{ url('get/enquiry') }}", { id: enquiry }, function(data){
				$("#name").text(data.name);
				$("#enquiry").text(data.enquiry);
				$("#datee").text(data.date);
				$("#title").text(data.title);
				$("#enquiry_id").val(enquiry);
			});

			$("#enquiry_status_div").show();

			$("#table_status").empty();

			$.get("{{ url('get/enquiry/status') }}", { id: enquiry }, function(data2){

				var i = 1;

				//alert("Timo");
				//alert(data2);
				$.each(data2, function(key, value){
					//alert(value.status);
					$("#table_status").append("<tr><td>"+i+"</td><td>"+value.status+"</td><td>"+value.user+"</td><td>"+value.date+"</td></tr>");
					i++;
				});
			});
		}
</script>
@endsection