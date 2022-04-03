<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Subscription;
use App\Log;

class SubscriptionController extends Controller
{
    
    public function subscriptions(){

    	$log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited the subscriptions page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	$subscriptions = Subscription::where('active', 1)->paginate(10);
    	return View('subscriptions.subscriptions', compact('subscriptions'));
    }
}
