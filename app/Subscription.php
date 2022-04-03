<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\Payment;

class Subscription extends Model
{
    protected $table = 'subscriptions';


    public function patient(){
    	return Patient::find( $this->patient );
    }

    public function payment(){
    	return Payment::find( $this->payment );
    }
}
