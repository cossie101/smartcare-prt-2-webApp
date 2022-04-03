<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Payment;
use App\Subscription;
use App\Patient;
use App\User;
use App\Log;
use PDF;
use App\Enquiry;
use Carbon\Carbon;
use App\DiagnosisSymptom;
use App\Diagnosis;

class ApplicationController extends Controller
{
    
    public function dashboard(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited smartcare application dashboard";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('dashboard');
    }

    public function payments(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the payments page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	$payments = Payment::orderBy('id', 'desc')->paginate(10);

    	return View('payments', compact('payments'));
    }

    public function reports(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the reports page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $doctors = User::where('role', 'doctor')->where('active', 1)->get();
        $patients = Patient::where('active', 1)->get();
        $admin = User::where('role', 'admin')->where('active', 1)->get();

    	return View('reports.reports', compact('doctors', 'patients', 'admin'));
    }

    public function generateReport( Request $request ){

    	$date = $request->get('date');
        
        //return Carbon::createFromFormat('Y-m-d H:i:s', $date);

    	if( $request->get('report') == 'payment' ){

           if( $request->get('userType') == 'patient' || $request->get('userType') == 'doctor' ){

                 $log = new Log;
                $log->user = Auth::id();
                $log->description = Auth::user()->name." generated payment report for the period";
                $log->date = date('Y-m-d');
                $log->time = date('H:i:s');
                $log->save();

                $title = "Payment";
                $period = date('d m Y', strtotime($date));

                $payments = Payment::where('patient', $request->get('patient'))/*->where('created_at', Carbon::createFromFormat('Y-m-d H:i:s', $date))*/->get();

                $pdf = PDF::loadView('reports.report', compact('title', 'period', 'payments'))->setPaper('a4', 'portrait');

                return $pdf->stream('Payments.pdf');
           }else{

                return redirect()->back()->with('message', 'This user cannot make payments');
           }
    	}elseif( $request->get('report') == 'subscription' ){

    		$title = "Subscriptions";
    		$period = date('d m Y')." - ".date('d m Y');

    		//if( $format = 'year' ){

    			$subscriptions = Subscription::get();
    		//}

	        $pdf = PDF::loadView('reports.subscription', compact('title', 'period', 'subscriptions'))->setPaper('a4', 'portrait');

	        return $pdf->stream('Payments.pdf');
    	}elseif( $request->get('report') == 'patient' ){

    		$title = "Patients";
    		$period = date('d m Y')." - ".date('d m Y');

    		//if( $format = 'year' ){

    			$patients = Patient::get();
    		//}

	        $pdf = PDF::loadView('reports.patients', compact('title', 'period', 'patients'))->setPaper('a4', 'portrait');

	        return $pdf->stream('Patients.pdf');
    	}elseif( $request->get('report') == 'doctor' ){

    		$title = "Doctors";
    		$period = date('d m Y')." - ".date('d m Y');

    		//if( $format = 'year' ){

    			$doctors = User::where('role', 'doctor')->where('active', 1)->orderBy('id', 'desc')->get();
    		//}

	        $pdf = PDF::loadView('reports.doctor', compact('title', 'period', 'doctors'))->setPaper('a4', 'portrait');

	        return $pdf->stream('Doctors.pdf');
    	}elseif( $request->get('report') == 'enquiry' ){

            if( $request->get('userType') == 'patient' ){

                $title = "Doctors' Enquiries";
                $period = date('d m Y')." - ".date('d m Y');

                //if( $format = 'year' ){

                    $enquiries = Enquiry::where('doctor', $request->get('doctor'))->orderBy('id', 'desc')->get();
                //}

                $pdf = PDF::loadView('reports.enquiries', compact('title', 'period', 'enquiries'))->setPaper('a4', 'portrait');

                return $pdf->stream('Enquiries.pdf');
            }elseif( $request->get('userType') == 'doctor' ){

                $title = "Doctors";
                $period = date('d m Y')." - ".date('d m Y');

                //if( $format = 'year' ){

                    $enquiries = Enquiry::where('doctor', $request->get('doctor'))->orderBy('id', 'desc')->get();
                //}

                $pdf = PDF::loadView('reports.enquiries', compact('title', 'period', 'enquiries'))->setPaper('a4', 'portrait');

                return $pdf->stream('Enquiries.pdf');
            }
        }elseif( $request->get('report') == 'history' ){

            if( $request->get('patient') != null ){

                $patient = Patient::find($request->get('patient'));
                $title = $patient->name." Medical History";
                $period = date('d m Y')." - ".date('d m Y');

                $d = [];

                $diagnosis = Diagnosis::where('patient', $request->get('patient'))->get();

                foreach( $diagnosis as $diag ){

                        $d[$diag->id] = DiagnosisSymptom::where('diagnosis', $diag->id)->get();
                }

                $pdf = PDF::loadView('reports.history', compact('title', 'period', 'd'))->setPaper('a4', 'portrait');

                return $pdf->stream('Medical History.pdf');
            }else{

                return redirect()->back()->withInput()->with('message', 'You have to select a patient to view their medical histroy');
            }
        }


    }

    public function logs(){

        $log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the logs page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

        $users = User::where('active', 1)->get();

        return View('logs', compact('users'));
    }

    public function loadLogs( Request $request ){

        if( $request->get('user') == 'all'){


            $period = date('d-m-Y', strtotime($request->get('date')));

            $log = new Log;
            $log->user = Auth::id();
            $log->description = Auth::user()->name." loaded system logs for ".$period;
            $log->date = date('Y-m-d');
            $log->time = date('H:i:s');
            $log->save();

           // return Log::get();
            $logs = Log::where('date', '=', date('Y-m-d', strtotime($request->get('date'))))->get();
            
            $title = "System Logs ";

            $pdf = PDF::loadView('reports.logs', compact('logs', 'title', 'period'))->setPaper('a4', 'portrait');
        }else{

            $title = User::find($request->get('user'))->name." System Logs ";
            $logs = Log::where('user', $request->get('user'))->where('date', date('Y-m-d', strtotime($request->get('date'))))->get();
             $period = date('d-m-Y', strtotime($request->get('date')));

             $log = new Log;
            $log->user = Auth::id();
            $log->description = Auth::user()->name." loaded ".$title." for the date ".$period;
            $log->date = date('Y-m-d');
            $log->time = date('H:i:s');
            $log->save();


            $pdf = PDF::loadView('reports.logs', compact('logs', 'title', 'period'))->setPaper('a4', 'portrait');
        }

        

        return $pdf->stream('Logs.pdf');
    }
}
