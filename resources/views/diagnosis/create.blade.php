@extends('layouts.main')

@section('content')


<div class="p-2 mt-4 d-flex justify-content-center">
	
	<div class="col-sm-10 card">
		<div class="card-heading bg-info p-3 row d-flex justify-content-center">
			<h6 class="text-white">New Diagnosis</h6>
		</div>

		<form method="POST" action="{{ URL::to('add/diagnosis') }}">
			{{ csrf_field() }}

			<div class="card-body px-5">

				@if( Session::get('message'))
					<div class="alert alert-danger col-sm-12">
						{{ Session::get('message') }}

						<a href="" class="close" data-dismiss="alert">&times;</a>
					</div>
				@endif

				<div class="col-sm-8 form-group row">
					<label class="text-md-right col-form-label col-sm-3">IDNO</label>
					<input type="number" name="idno" id="idno" class="col-sm-8 form-control" required>
				</div>
				<div class="col-sm-12 d-inline-flex">
					<div class="col-sm-3 flex-column">
						<label class="text-md-left col-form-label col-sm-12">Name</label>
						<label id="name" class="col-sm-12 ">
					</div>

					<div class="col-sm-3 flex-column">
						<label class="text-md-left col-form-label col-sm-12">Phone</label>
						<label id="phone" class="col-sm-12 ">
					</div>

					<div class="col-sm-5 flex-column">
						<label class="text-md-left col-form-label col-sm-12">Registration Date</label>
						<label id="reg" class="col-sm-12 ">
					</div>
				</div>

				<div class="form-group col-sm-8 row">
					<label class="col-sm-3 col-form-label text-md-right">Disease</label>
					<select class="col-sm-8 form-control" name="disease" id="disease" required>
						<option value="">Select a Disease</option>
						@foreach( $diseases as $disease )
							<option value="{{ $disease->id }}">{{ $disease->disease }}</option>
						@endforeach
					</select>
				</div>

				<div class="col-sm-12 d-flex justify-content-center">
					<input type="text" placeholder="Enter a symptom ... " onchange="searchSymptom(this.value);" value=""
			onkeyup="this.onchange();" onpaste="this.onchange();" oninput="this.onchange();" name="search" class="col-sm-9 form-control">
				</div>

				<div class="mt-3 col-sm-12" id="symptomDiv">
					
				</div>

				<div class="mt-5 p-3 col-sm-12 border border-info rounded flex-column ">
					<h6 class="text-info">Selected search symptoms</h6>
					<hr style="width:40%; margin-left: 0;">
					<input type="hidden" name="counter" id="counter" value="0">
					<div class="mt-3 mx-2 col-sm-12" id="selectedDiv">

						
					</div>

				</div>
			</div>



			<div class="card-footer d-flex justify-content-center mt-4 row">
				<a href="javascript:void(0)" class="btn btn-info btn-md text-white" id="search">SEARCH</a>
				<button class="ml-3 btn btn-md btn-info text-white px-5"> SAVE</button>
			</div>
		</form>
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
					}
				});
			}
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



	

</script>


@endsection