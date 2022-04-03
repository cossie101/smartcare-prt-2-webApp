@extends('layouts.main')

@section('content')

<div class="p-2">
	<div class="col-sm-12 mt-3">
		<div class="col-sm-12 mt-3">

			<h6 class="text-info">Diagnosis Management</h6>

			<a href="{{ URL::to('add/diagnosis') }}" class="btn btn-info text-white px-5 mb-4 float-right" style="margin-top: -35px;"> New Diagnosis</a>

			<a href="{{ URL::to('add/symptom') }}" class="btn btn-info text-white px-5 mb-4 float-right" style="margin-top: -35px; margin-right: 10px;"> New Symptom</a>

			<a href="{{ URL::to('add/disease') }}" class="btn btn-info text-white px-5 mb-4 float-right" style="margin-top: -35px; margin-right: 10px;"> New Disease</a>
		</div>

		<div class="col-sm-12 mt-2">
			@if( Session::get('message') )
				<div class="alert alert-success col-sm-11">
					{{ Session::get('message') }}
					<a href="" class="close" data-dismiss="alert">&times;</a>
				</div>
			@endif
		</div>
	</div>

	<hr>

	<div class="col-sm-12 d-flex justify-content-center">
		<input type="text" placeholder="Enter a symptom ... " onchange="searchSymptom(this.value);" value=""
onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" name="search" class="col-sm-9 form-control">
	</div>

	<div class="mt-3 col-sm-12" id="symptomDiv">
		
	</div>

	<div class="mt-5 p-3 col-sm-12 border border-info rounded flex-column ">
		<h6 class="text-info">Selected search symptoms</h6>
		<hr style="width:40%; margin-left: 0;">
		<form  class="col-sm-10" id="formS">
			<input type="hidden" name="counter" id="counter" value="0">
			<div class="mt-3 mx-2 col-sm-12" id="selectedDiv">

				
			</div>
			<a href="javascript:void()" class="btn btn-info btn-md text-white px-5 mt-3" id="searchDisease">SEARCH</a>
		</form>

	</div>

	<div class="col-sm-12 mt-5">
		
		<table class="table table-bordered table-striped table-hovered table-sm">
			<thead>
				<th>#</th>
				<th>Code</th>
				<th>Patient</th>
				<th>Doctor</th>
				<th>Date</th>
			</thead>

			<tbody>
				@if( count($diagnosis) != 0)

					<?php $i = 1; ?>
					@foreach( $diagnosis as $diag )
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $diag->code }}</td>
							<td>{{ $diag->patient() }}</td>
							<td>{{ $diag->doctor() }}</td>
							<td>{{ date('F d, Y', strtotime($diag->created_at)) }}</td>
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="5">You have 0 diagnosis</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$(document).ready( function(){

		$("#searchDisease").click( function(e){
			e.preventDefault();

			$.ajaxSetup({
			      headers: {
			          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      }
			  });

			$.ajax({
		        method: 'post',
		        url: "{{ url('search/disease') }}",
		        data: $('#formS').serialize(),
		        success: function(data){
		        	alert(data);
		        	
		        }
		    });
		});
	});

	function searchSymptom( text ){


		if( text != ""){

			$.get("{{ url('get/symptom') }}", {text: text}, function(data){

				if( Object.keys(data).length == 0 ){

					$("#symptomDiv").empty();
					$("#symptomDiv").append("<h6 class=\"text-danger ml3\">There is no such record in the database</h6>");
				}else{

					$.each(data, function(key, value){
						$("#symptomDiv").empty();
						$("#symptomDiv").append("<a href=\"javascript:void()\" class=\"px-3 ml-2 btn btn-light btn-md text-info\" onclick=\"selectSymptom(this.title, this.id)\" title="+value.symptom+" id="+value.id+">"+value.symptom+"</a>");
					});
				}
			});
		}
	}

	var counter = 1;

	function selectSymptom( symptom, symptomID ){

		$("#selectedDiv").append("<input readonly type=\"hidden\" name="+counter+" value="+symptomID+" class=\"btn btn-ligth text-info px-2 ml-2\"/>");

		$("#selectedDiv").append("<input readonly type=\"text\" name=\"f\" value="+symptom+" class=\"btn btn-ligth text-info px-2 ml-2\"/>");

		$("#counter").val(counter);

		counter++;
	}

	function getInputs(){

		
	}

</script>

@endsection