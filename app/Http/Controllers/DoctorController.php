<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Diagnosis;
use App\Symptom;
use App\Disease;
use App\Enquiry;
use App\Status;
use App\Appointment;
use App\SymptomAllocation;
use App\Log;
use App\DiagnosisSymptom;
use App\Patient;

class DoctorController extends Controller
{
    

    public function doctors(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited doctors' page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	$doctors = User::where('role', 'doctor')->where('active', 1)->paginate(10);

    	return View('doctors.doctors', compact('doctors'));
    }

    public function newDoctor(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." loaded the doctor registration page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('doctors.create');
    }

    public function saveDoctor(Request $request){

    	if( $request->get('password') != $request->get('confirm') ){

    		return back()->withInput()->with('message', 'The two passwords do not match');
    	}else{

    		$doctor = User::where('username', $request->get('username'))->first();

	    	if( $doctor == null ){

				$newDoctor = new User;
				$newDoctor->name = $request->get('name');
				$newDoctor->idno = $request->get('idno');
				$newDoctor->phone = $request->get('phone');
				$newDoctor->email = $request->get('email');
				$newDoctor->username = $request->get('username');
				$newDoctor->password = Hash::make( $request->get('password') );
				$newDoctor->role = 'doctor';
				$newDoctor->user = $request->user()->id;
				$newDoctor->save();

                $log = new Log;
                $log->user = Auth::id();
                $log->description = Auth::user()->name." saved a new doctor <Name: ".$newDoctor->name." ID: ".$newDoctor->id.">";
                $log->date = date('Y-m-d');
                $log->time = date('H:i:s');
                $log->save();

				return redirect('doctors')->with('message', 'The doctor has been added successfully');

	    	}else{

	    		return back()->withInput()->with('message', 'That username is already taken');
	    	}

    	}
    	
    }



    public function diagnosis(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited diagnosis page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $diagnosis = Diagnosis::where('closed', 0)->orderBy('id', 'desc')->paginate(10);

    	return View('diagnosis.diagnosis', compact('diagnosis'));
    }


    public function newDiagnosis(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited new diagnosis page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $diseases = Disease::where('active', 1)->get();
        $patients = Patient::get();

        return View('diagnosis.create', compact('diseases', 'patients'));
    }


    public function saveDiagnosis(Request $request){

        //return $request->all();

        $newDiagnosis = new Diagnosis;
        $newDiagnosis->disease = $request->get('disease');
        $newDiagnosis->doctor = $request->user()->id;
        $newDiagnosis->patient = Patient::where('idno', $request->get('idno'))->first()->id;
        $newDiagnosis->save();

        if( $request->get('counter') > 0 ){

            for($i = 1; $i <= $request->get('counter'); $i++ ){

                $newDiagnosisSymptom = new DiagnosisSymptom;
                $newDiagnosisSymptom->diagnosis = $newDiagnosis->id;
                $newDiagnosisSymptom->symptom = $request->get($i);
                $newDiagnosisSymptom->save();
            }
        }

        return redirect('diagnosis')->with('message', 'The new diagnosis has been saved successfully');
    }


    public function newDisease(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the diseases page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $symptoms = Symptom::where('active', 1)->get();
        $diseases = Disease::where('active', 1)->paginate();

        return View('diagnosis.disease', compact('symptoms', 'diseases'));
    }

    public function saveDisease( Request $request ){

         //return $request->all();

        $newDisease = new Disease;
        $newDisease->code = $request->get('code');
        $newDisease->disease = $request->get('disease');
        $newDisease->active = 1;
        $newDisease->save();

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." saved a new disease Disease: ".$newDisease->disease." ID: ".$newDisease->id;
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        for($i = 1; $i <= $request->get('check'.$i); $i++){

            if( !empty($request->get('check'.$i)) ){

                $newAllocation = new SymptomAllocation;
                $newAllocation->disease = $newDisease->id;
                $newAllocation->symptom = $request->get('check'.$i);
                $newAllocation->active = 1;
                $newAllocation->save();
            }else{
                break;
            }
        }

        return redirect('diagnosis')->with('message', 'The new disease detail has been saved successfully');
    }

    public function newSymptom(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the symptoms page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $symptoms = Symptom::where('active', 1)->paginate(10);

        return View('diagnosis.symptom', compact('symptoms'));
    }

    public function saveSymptom( Request $request ){

        $newSymptom = new Symptom;
        //$newSymptom->disease = $request->get('disease');
        $newSymptom->code = $request->get('code');
        $newSymptom->symptom = $request->get('symptom');
        $newSymptom->active = 1;
        $newSymptom->save();

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." craeted a new symptom Symptom".$request->get('symptom');
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        return redirect('diagnosis')->with('message', 'The new disease symptom has been saved successfully');
    }

    public function statusUpdate( Request $request ){

        //return $request->all();

        $enquiry = Enquiry::find($request->get('enquiry_id'));
        $enquiry->doctor = $request->user()->id;
        $enquiry->save;

        $newStatus = new Status;
        $newStatus->patient_id = $enquiry->patient;
        $newStatus->enquiries_id = $request->get('enquiry_id');
        $newStatus->description = $request->get('status');
        $newStatus->user = $request->user()->id;
        $newStatus->save();

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." craeted a new status to respond to a patients enquiry";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        return redirect('messages')->with('status had been saved successfully');
    }

    public function appointment(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the appointments page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $appointments = Appointment::where('active', 1)->orderBy('id', 'desc')->paginate(3);

        return View('doctors.appointments', compact('appointments'));
    }


}
