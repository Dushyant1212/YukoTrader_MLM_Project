<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Level;
use App\Traits\GlobalStatus;

class Plan extends Model
{
    use GlobalStatus;
    
    public function level()
    {
    	return $this->hasMany(Level::class);
    }

    public function sumLevelOfCommission($planId)
    {
    	$general = gs();
    	return Level::where('plan_id', $planId)->where('level','<=',  $general->matrix_height)->sum('amount');
    }

    public function totalLevel($planId)
    {
        $general = gs();
        return  Level::where('plan_id', $planId)->where('level','<=',  $general->matrix_height)->get();
    }
    
}
