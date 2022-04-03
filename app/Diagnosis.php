<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Patient;
use App\User;
use App\Disease;

class Diagnosis extends Model
{
    
    protected $table = 'diagnosis';

    public function patient(){

    	return Patient::where('id', $this->patient)->first()->name;
    }

    public function doctor(){

    	return User::where('id', $this->doctor)->first()->name;
    }

    public static function doctor2($id){

    	return User::find($id)['name'];
    }

    public static function disease($id){

    	return Disease::find($id)['disease'];
    }

    public static function date($id){

    	return date('d-m-Y H:s', strtotime(self::find($id)->created_at));
    }
}
