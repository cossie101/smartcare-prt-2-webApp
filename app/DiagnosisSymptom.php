<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Symptom;

class DiagnosisSymptom extends Model
{
    
    protected $table = 'diagnosis_symptoms';

    public function symptom(){

    	return Symptom::find($this->symptom);
    }
}
