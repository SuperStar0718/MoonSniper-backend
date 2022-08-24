<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlansController extends Controller
{
    public function plans()
    {
       $plans = Plan::select('label','value')->get();
       return response()->json(['plans'=>$plans]);
    }
}
