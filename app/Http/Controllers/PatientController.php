<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Enquiry;
use App\Patient;
use App\Log;
use App\Payment;
use App\Statement;
use App\Subscription;

class PatientController extends Controller
{
    
    public function patients(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the patients page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	$patients = Patient::paginate(10);
    	$unsubscribed = Patient::paginate(10);


    	return View('patients.patients', compact('patients', 'unsubscribed'));
    }

    public function messages(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the enquiries page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	$enquiries = Enquiry::where('active', 1)->paginate(10);
        $solved = Enquiry::where('solved', 1)->orderBy('id', 'desc')->paginate(10);

    	return View('patients.enquiries', compact('enquiries', 'solved'));
    }


    public function registerPatient(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." loaded the patient registration page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('patients.register');
    }


    public function addPatient(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." loaded the new patient page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('patients.create');
    }

    public function savePatient(Request $request){

    	$newPatient = new Patient;
    	$newPatient->name = $request->get('name');
    	$newPatient->idno = $request->get('idno');
    	$newPatient->email = $request->get('email');
    	$newPatient->phone = $request->get('phone');
    	$newPatient->username = $request->get('name');
    	$newPatient->password = Crypt::crypt($request->get('password'));
    	$newPatient->user = $request->user()->id;
    	$newPatient->save();

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." saved a new patient name: ".$request->get('name')." ID: ".$newPatient->id;
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return redirect('patients')->with('message', 'Patient has been registered successfully');
    }


    public function getSubscription(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the patient subscription page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('patients.subscribe');
    }


    public function saveSubscription(Request $request){

        // /return $request->all();

    	if( $request->get('password') != $request->get('confirm') ){

    		return back()->withInput()->with('message', 'Passwords do not match');
    	}else{

    		$patient = Patient::where('idno', $request->get('idno'))->first();
	    	
	    	
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

            $log = new Log;
            $log->user = Auth::id();
            $log->description = Auth::user()->name." saved a new patient subscription for <Name: ".$request->get('name')." ID: ".$patient->id.">";
            $log->date = date('Y-m-d');
            $log->time = date('H:i:s');
            $log->save();

	    	return redirect('patients')->with('Subscription has been made successfully');
    	}
    }

    public function medicalHistory(){

        return View('patients.history');
    }
}
