<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use App\Models\ExchangeTicker;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExchangesController extends Controller
{
    public function exchangesByToken(Request $request)
    {
        // $exchange = Exchange::where('exchangeid',$request->token)->first();
        DB::enableQueryLog();
        $exchanges = ExchangeTicker::where('base','like', $request->token)->select('exchange','volume','trade_url','base','target')->orderBy('volume','DESC')->paginate(10);
        return response()->json(['status'=>true, 'exchanges'=>$exchanges]);
    }
    public function ExchangeCoins(Request $request)
    {
        $exchanges = Exchange::select('name','exchangeid')->get();
        
        return response()->json(['status'=>true, 'exchanges'=>$exchanges]);
    }
}
