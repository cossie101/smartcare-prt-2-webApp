<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\User;

class Enquiry extends Model
{
    protected $table = 'enquiries';

    public function patient(){

    	return Patient::find($this->patient);
    }

    public function doctor(){

    	if($this->doctor != null){
    		
    		return User::find($this->doctor);
    	}else{

    		return "N/A";
    	}
    }
}
