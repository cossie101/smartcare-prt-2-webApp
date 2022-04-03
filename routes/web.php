<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Patient;
use App\Enquiry;
use App\Appointment;
use App\Symptom;
use App\Disease;
use App\SymptomAllocation;
use App\Diagnosis;
use App\DiagnosisSymptom;
use App\Statement;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




 
Route::group(['middleware' => ['auth']], function(){

	Route::get('/', 'ApplicationController@dashboard');
	Route::get('diagnosis', 'DoctorController@diagnosis');
	Route::get('add/diagnosis', 'DoctorController@newDiagnosis');
	Route::post('add/diagnosis', 'DoctorController@saveDiagnosis');
	Route::get('add/disease', 'DoctorController@newDisease');
	Route::post('add/disease', 'DoctorController@saveDisease');
	Route::get('add/symptom', 'DoctorController@newSymptom');
	Route::post('add/symptom', 'DoctorController@saveSymptom');
	Route::get('messages', 'PatientController@messages');
	Route::get('subscriptions', 'SubscriptionController@subscriptions');
	Route::get('patients', 'PatientController@patients');
	Route::get('doctors', 'DoctorController@doctors');
	Route::get('add/doctor', 'DoctorController@newDoctor');
	Route::post('add/doctor', 'DoctorController@saveDoctor');
	Route::get('add/patient', 'PatientController@addPatient');
	Route::post('save/patient', 'PatientController@savePatient');
	Route::get('subscribe/patient', 'PatientController@getSubscription');
	Route::post('subscribe/patient', 'PatientController@saveSubscription');
	Route::post('save/status', 'DoctorController@statusUpdate');
	Route::get('appointments', 'DoctorController@appointment');
	Route::get('payments', 'ApplicationController@payments');
	Route::get('reports', 'ApplicationController@reports');
	Route::post('reports', 'ApplicationController@generateReport');
	Route::get('logs', 'ApplicationController@logs');
	Route::post('system/log', 'ApplicationController@loadLogs');
	Route::get('medical/history', 'PatientController@medicalHistory');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('patient/register', 'PatientController@registerPatient');





Route::get('get/patient', function(Request $request){
	return Patient::where('idno', $request->get('idno'))->first();
});


Route::get('get/enquiry', function(Request $request){
	return Enquiry::where('enquiries.id', $request->get('id'))
					->join('patients', 'patients.id', '=', 'enquiries.patient')
					->select('patients.name', 'enquiry', 'title', 'enquiries.created_at')
					->first();
});

Route::get('get/enquiry/status', function( Request $request ){

	$enquiries =  Enquiry::where('enquiries.id', $request->get('id'))
					->join('status', 'enquiries.id', '=', 'status.enquiries_id')
					->join('users', 'users.id', '=', 'status.user')
					->select('description as status', 'name as user', 'status.created_at')
					->get();

	$en = [];

	foreach( $enquiries as $n ){

		$n->date = date('d M Y H:i', strtotime($n->created_at));

		array_push( $en, $n);
	}

	return $en;
});


Route::get('get/appointment', function(Request $request){

	return Appointment::where('appointments.id', $request->get('id'))
						->join('patients', 'patients.id', '=', 'appointments.patient')
						->select('name', 'title', 'description', 'appointments.created_at')
						->first();
});

Route::get('get/appointment/status', function( Request $request ){

	$appointments =  Appointment::where('appointments.id', $request->get('id'))
					->join('status', 'appointments.id', '=', 'status.appointment')
					->join('users', 'users.id', '=', 'status.user')
					->select('status.description as status', 'name as user', 'status.created_at')
					->get();

	$en = [];

	foreach( $appointments as $n ){

		$n->date = date('d M Y H:i', strtotime($n->created_at));

		array_push( $en, $n);
	}

	return $en;
});

Route::get('get/symptom', function( Request $request ){

	return Symptom::orWhere('symptom', 'like', '%'.$request->get('text').'%')->get();
});

Route::post('search/disease', function( Request $request ){

	//$data = $request->all();

	$symptoms = [];

	for( $i = 1; $i <= $request->get('counter'); $i++){
		

		$symptom = Symptom::find($request->get($i));
		$symptom = $symptom->symptom;
		$allocations = SymptomAllocation::where('symptom', $request->get($i))->get();

		$diseases = [];

		foreach( $allocations as $a ){

			$disease = Disease::find($a->disease);
			array_push($diseases, $disease->disease);
			
		}

		$symptoms[$symptom] = $diseases;
		
		
	}

	$log = 'sym.text';
	$w = fopen($log, "a");
	fwrite($w, json_encode($symptoms));
	fclose($w);

	return json_encode($symptoms);
});


Route::get('get/enquiries', function(Request $request){

	$enquiries = Enquiry::where('patient', $request->get('id'))->get();

	return $enquiries;
});

Route::get('get/history', function(Request $request){

	//return Diagnosis::all();

	$diagnosis = Diagnosis::where('patient', $request->get('id'))->get();

	$d = [];

	foreach( $diagnosis as $diag ){

		$symptoms = DiagnosisSymptom::where('diagnosis', $diag->id)->get();

		$s = [];

		foreach($symptoms as $symptom){

			array_push($s, Symptom::find($symptom->symptom)->symptom);
			//array_push($s, $symptom);
		}

		$diag->date = date('d-m-Y H:i', strtotime($diag->created_at));
		$diag->disease = Disease::find($diag->disease)->disease;
		$diag->symptom = $s;

		array_push($d, $diag);
	}

	return $d;
});

Route::get('get/symptoms', function(Request $request){

	$symptoms = DiagnosisSymptom::where('diagnosis', $request->get('id'))->get();

	$s = [];

	foreach($symptoms as $symptom){

		$symptom->symptom = Symptom::find($symptom->symptom)->symptom;
		array_push($s, $symptom);
	}

	return $s;
});

Route::get('get/statements', function(Request $request){

	$statements = Statement::where('patient', $request->get('id'))->get();

	$s = [];

	foreach( $statements as $statement ){

		$statement->date = date('d-m-Y H:i');

		array_push($s, $statement);
	}

	return $s;
});