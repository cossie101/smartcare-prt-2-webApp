<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;

class Payment extends Model
{
    protected $table = 'payments';

    public function patient(){

    	return Patient::find($this->patient)->name;
    }
}
