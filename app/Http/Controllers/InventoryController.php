<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Log;

class InventoryController extends Controller
{
    public function inventory(){

    	$log = new Log;
        $log->user = Auth::id();
        $log->description = Auth::user()->name." visited inventory page";
        $log->date = date('Y-m-d');
        $log->time = date('H:i:s');
        $log->save();

    	return View('inventory.inventory');
    }
}
