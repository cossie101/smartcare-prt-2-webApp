<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;

class Appointment extends Model
{
    
	protected $table = 'appointments';

	public function name(){

		return Patient::find($this->patient)->name;
	}
}
