<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\ExchangeTicker;
use Illuminate\Http\Request;

class ExchangesController extends Controller
{
    public function exchangesByToken(Request $request)
    {
        $exchanges = ExchangeTicker::where('exchange_id',$request->token)->select('exchange','volume','trade_url')->paginate(10);
        
        return response()->json(['status'=>true, 'exchanges'=>$exchanges]);
    }
    public function ExchangeCoins(Request $request)
    {
        $exchanges = Exchange::select('name','exchangeid')->get();
        
        return response()->json(['status'=>true, 'exchanges'=>$exchanges]);
    }
}
