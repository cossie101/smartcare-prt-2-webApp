<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Patient;
use App\Payment;
use App\Statement;
use App\Subscription;
use App\Enquiry;
use App\Status;
use App\User;
use App\Appointment;
use App\Schedule;
use App\Doctor;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('login', function(Request $request){

	$patient = Patient::where('username', $request->get('username'))->first();

	if( !empty($patient)){

		if( $request->get('password') == Crypt::decrypt( $patient->password )){
			//if( $patient->subscribed == 1 ){
				return array(
					'name' => $patient->name,
					'phone' => $patient->phone,
					'email' => $patient->email,
					'idno' => $patient->idno,
					'userId' => $patient->id,
					'status' => 'success',
					'message' => 'Login successful',
					'subscription' => 'valid'
				);/*
			}else{
				return array(
					'name' => $patient->name,
					'phone' => $patient->phone,
					'email' => $patient->email,
					'idno' => $patient->idno,
					'userId' => $patient->id,
					'status' => 'success',
					'message' => "You don't have an active subscription",
					'subscription' => 'invalid'
				);
			}*/
		}else{
			return array(
				'status' => 'failed',
				'message' => 'Wrong credentials'
			);
		}
	}else{

		return array(
			'status' => 'failed',
			'message' => "There isn't such username credentials"
		);
	}
});


Route::get('signup', function(Request $request){

	$patient = Patient::where('username', $request->get('username'))->get();

	if( count($patient) != 0 ){

		return array(
			'status' => 'failed',
			'message' => 'That username is already taken'
		);
	}else{
		$newPatient = new Patient;
		$newPatient->name = $request->get('name');
		$newPatient->username = $request->get('username');
		$newPatient->email = $request->get('email');
		$newPatient->phone = $request->get('phone');
		$newPatient->idno = $request->get('idno');
		$newPatient->password = Crypt::encrypt( $request->get('password') );
		$newPatient->save();

		return array(
			'status' => 'success',
			'message' => 'Sign up was successful'
		);

	}
});


Route::get('pay/subscription', function(Request $request){

	$patient = Patient::find($request->get('member'));

	if( $patient != null ){

		$payment = new Payment;
		$payment->patient = $patient->id;
		$payment->amount = $request->get('amount');
		$payment->reference = 'PAY-'.date('YmdHis');
		$payment->save();

		$statement = new Statement;
		$statement->patient = $patient->id;
		$statement->description = "Subscription Payment";
		$statement->type = "CREDIT";
		$statement->bf = $patient->balance;
		$statement->amount = $request->get('amount');
		$statement->cf = $patient->balance - $request->get('amount');
		$statement->save();

		$subscription = new Subscription;
		$subscription->patient = $patient->id;
		$subscription->payment = $payment->id;
		$subscription->expiryTime = date('Y-m-d H:i:s', strtotime('+1 years'));
		$subscription->active = 1;
		$subscription->save();

		$patient->subscribed = 1;
		$patient->active = 1;
		$patient->account = 'P-'.date('Ymd').'/'.$patient->id;
		$patient->save();


		return array(
				'status' => 'success',
				'message' => 'Subscription was successful'
			);

	}else{
		return array(
				'status' => 'success',
				'message' => 'That username is invalid'
			);
	}
});


Route::get('save/enquiry', function(Request $request){

	$enquiry = Enquiry::where('active', 1)->where('solved', 0)->where('patient', $request->get('user'))->first();

	if( $enquiry == null ){

		$newEnquiry = new Enquiry;
		$newEnquiry->title = $request->get('title');
		$newEnquiry->patient = $request->get('member');
		$newEnquiry->enquiry = $request->get('enquiry');
		$newEnquiry->active = 1;
		$newEnquiry->save();

		$newStatus = new Status;
		$newStatus->enquiries_id = $newEnquiry->id;
		$newStatus->patient_id = $request->get('member');
		$newStatus->description = 'ENQ/#'.$newStatus->id.'/NEW  '.'Enquiry submission';
		$newStatus->user = 1;
		$newStatus->save();

		return array(
			'status' => 'success',
			'message' => 'Enquiry has been saved successfully'
		);

	}else{

		return array(
			'status' => 'failed',
			'message' => 'You already have an unclosed similar enquiry'
		);
	}
});



Route::get('load/enquiry', function(Request $request){

	$enquiry = Enquiry::where('patient', $request->get('member'))->get();

	$ens = [];

	foreach($enquiry as $en){
		$en->enquiryID = $en->id;
		$en->enquiryTitle = $en->title;
		$en->enquiryDate = date('d M, Y H:s', strtotime($en->created_at));

		array_push($ens, $en);
	}

	return json_encode($ens);
});


Route::get('fetch/status', function( Request $request ){

	$status = Status::where('enquiries_id', $request->get('enquiry'))->get();

	$ens = [];
	$i = 1;

	foreach($status as $en){
		$en->id = $i;
		$en->enquiryTitle = $en->description;
		if( $en->user == 1 ){

			$en->author = "System";
		}else{

			$en->author = User::find($en->user)->name;
		}
		$en->date = date('d M, Y H:s', strtotime($en->created_at));

		array_push($ens, $en);
		$i++;
	}

	return json_encode($ens);
});



Route::get('save/appointment', function( Request $request){

	$appointment = Appointment::where('patient', $request->get('patient'))->where('active', 0)->where('description', $request->get('description'))->get();

	if( count($appointment) == 0){

		$newAppointment = new Appointment;
		$newAppointment->title = $request->get('title');
		$newAppointment->description = $request->get('appointment');
		$newAppointment->active = 1;
		$newAppointment->date = $request->get('appointmentDate');
		$newAppointment->patient = $request->get('patient');
		$newAppointment->save();

		$newStatus = new Status();
		$newStatus->appointment = $newAppointment->id;
		$newStatus->patient_id = $request->get('patient');
		$newStatus->description = 'APP/#'.$newStatus->id.'/NEW  '.'Appointment submission';
		$newStatus->user = 1;
		$newStatus->save();

		return array(
					'status' => 'success',
					'message' => 'Appointment has been send successfully'
				);

	}else{
		return array( 
				'status' => 'success',
				'message' => 'You have already created this appointment'
			);
	}
});


Route::get('fetch/doctors', function (){

	return Doctor::where('active', 1)->get();
});

Route::get('payment', function( Request $request ){

	$newPayment = new Payment;
	$newPayment->patient = $request->get('patient');
	$newPayment->amount = $request->get('amount');
	$newPayment->reference = "SC/Payment/".date('YmdHis');
	$newPayment->save();

	return array( 
				'status' => 'success',
				'message' => 'The payment has been posted successfully'
			);
});

Route::get('payments', function( Request $request ){

	return Payment::where('patient', $request->get('patient'))->get();
});

Route::get('fetch/appointments', function( Request $request ){

	$appointments = Appointment::where('patient', $request->get('patient'))->get();

	$ens = [];
	$i = 1;

	foreach($appointments as $en){
		$en->appointment = $en->description;
		if( $en->assigned == 0 ){

			$en->doctor = "Not Assigned";
		}else{

			$en->doctor = User::find($en->assigned)->name;
		}
		$en->date = date('d M, Y H:s', strtotime($en->created_at));

		array_push($ens, $en);
		$i++;
	}

	return $ens;
});

