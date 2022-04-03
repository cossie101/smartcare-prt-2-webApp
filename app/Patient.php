<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subscription;

class Patient extends Model
{
    protected $table = 'patients';

    public function subscription(){
    	return Subscription::where('patient', $this->id)->first();
    }
}
