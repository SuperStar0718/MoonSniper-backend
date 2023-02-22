<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CoinsData;
use App\Models\UnlockingPdf;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotifyCoinAlert;

class AlertController extends Controller
{
    public function addAlert(Request $request)
    {
        $filterData = array();

        if ($request->min_price != null) {
            $filterData['min_price'] = $request->min_price;

        }
        if ($request->max_price != null) {
            $filterData['max_price'] = $request->max_price;

        }
        if ($request->min_price_percentage != null) {
            $filterData['min_price_percentage'] = $request->min_price_percentage;

        }
        if ($request->max_price_percentage != null) {
            $filterData['max_price_percentage'] = $request->max_price_percentage;

        }
        if ($request->min_tradingper24h != null) {
            $filterData['min_tradingper24h'] = $request->min_tradingper24h;

        }
        if ($request->max_tradingper24h != null) {
            $filterData['max_tradingper24h'] = $request->max_tradingper24h;

        }
        if ($request->min_roipercentage != null) {
            $filterData['min_roipercentage'] = $request->min_roipercentage;

        }
        if ($request->max_roipercentage != null) {
            $filterData['max_roipercentage'] = $request->max_roipercentage;

        }
        if ($request->min_marketcap != null) {
            $filterData['min_marketcap'] = $request->min_marketcap;

        }
        if ($request->max_marketcap != null) {
            $filterData['max_marketcap'] = $request->max_marketcap;

        }
        if ($request->min_marketcap_percentage != null) {
            $filterData['min_marketcap_percentage'] = $request->min_marketcap_percentage;

        }
        if ($request->max_marketcap_percentage != null) {
            $filterData['max_marketcap_percentage'] = $request->max_marketcap_percentage;

        }
        if ($request->min_nextunlock != null) {
            $filterData['min_nextunlock'] = $request->min_nextunlock;

        }
        if ($request->max_nextunlock != null) {
            $filterData['max_nextunlock'] = $request->max_nextunlock;

        }
        if ($request->min_socialsentiments != null) {
            $filterData['min_socialsentiments'] = $request->min_socialsentiments;

        }
        if ($request->max_socialsentiments != null) {
            $filterData['max_socialsentiments'] = $request->max_socialsentiments;

        }
        if ($request->min_socialsentiments != null) {
            $filterData['min_socialsentiments'] = $request->min_socialsentiments;

        }
        if ($request->max_socialsentiments != null) {
            $filterData['max_socialsentiments'] = $request->max_socialsentiments;
        }

        $filterData['coin_id'] = $request->coin_id;
        $filterData['symbol'] = $request->symbol;
        $filterData['name'] = $request->name;
        $filterData['coin_name'] = $request->coin_name;
        $filterData['priority'] = $request->priority;
        $user = Auth::user();
        $user->notify((new NotifyCoinAlert($filterData)));
        return response()->json(['status' => true, 'data' => $filterData]);

    }
    public function getUserAlerts()
    {
        $user = Auth::user();

        $notifications = Notifications::where('notifiable_id', '=', $user->id)->where('note',  null)->orderby('created_at', 'DESC')->paginate(10);
        foreach ($notifications as $key => $value) {
            $notifications[$key]['data'] = json_decode($value->data);
        }
        return response()->json(['status' => true, 'data' => $notifications]);

    }
    public function getUserAlertList()
    {
        $user = Auth::user();
        $notifications = Notifications::where('notifiable_id', '=', $user->id)->where('note' ,'!=',  null)->where('show_date' ,  null)->orderby('created_at', 'DESC')->get();
        foreach ($notifications as $key => $value) {
            $notifications[$key]['data'] = json_decode($value->data);
            // $notifications[$key]['data']->coindata = CoinsData::where('coin_id',$notifications[$key]['data']->coin_id)->where('symbol',$notifications[$key]['data']->symbol)
            // ->select('price_change_percentage_24h','roi_percentage','market_cap','next_unlock_percent_of_tokens','average_sentiment_change','current_price')
            // ->first();
            
        }
                    return response()->json(['status' => true, 'data' => $notifications,'user' => $user]);

    }
    public function deleteAlert(Request $request)
    {
        Notifications::where('id', '=', $request->id)->delete();

        return response()->json(['status' => true, 'id' => $request->id]);
    }
    public function updateAlert(Request $request)
    {
        $notification = Notifications::where('id', '=', $request->id)->first();
        if ($request->min_price != null) {
            $filterData['min_price'] = $request->min_price;

        }
        if ($request->max_price != null) {
            $filterData['max_price'] = $request->max_price;

        }
        if ($request->min_price_percentage != null) {
            $filterData['min_price_percentage'] = $request->min_price_percentage;

        }
        if ($request->max_price_percentage != null) {
            $filterData['max_price_percentage'] = $request->max_price_percentage;

        }
        if ($request->min_tradingper24h != null) {
            $filterData['min_tradingper24h'] = $request->min_tradingper24h;

        }
        if ($request->max_tradingper24h != null) {
            $filterData['max_tradingper24h'] = $request->max_tradingper24h;

        }
        if ($request->min_roipercentage != null) {
            $filterData['min_roipercentage'] = $request->min_roipercentage;

        }
        if ($request->max_roipercentage != null) {
            $filterData['max_roipercentage'] = $request->max_roipercentage;

        }
        if ($request->min_marketcap != null) {
            $filterData['min_marketcap'] = $request->min_marketcap;

        }
        if ($request->max_marketcap != null) {
            $filterData['max_marketcap'] = $request->max_marketcap;

        }
        if ($request->min_marketcap_percentage != null) {
            $filterData['min_marketcap_percentage'] = $request->min_marketcap_percentage;

        }
        if ($request->max_marketcap_percentage != null) {
            $filterData['max_marketcap_percentage'] = $request->max_marketcap_percentage;

        }
        if ($request->min_nextunlock != null) {
            $filterData['min_nextunlock'] = $request->min_nextunlock;

        }
        if ($request->max_nextunlock != null) {
            $filterData['max_nextunlock'] = $request->max_nextunlock;

        }
        if ($request->min_socialsentiments != null) {
            $filterData['min_socialsentiments'] = $request->min_socialsentiments;

        }
        if ($request->max_socialsentiments != null) {
            $filterData['max_socialsentiments'] = $request->max_socialsentiments;

        }
        if ($request->min_socialsentiments != null) {
            $filterData['min_socialsentiments'] = $request->min_socialsentiments;

        }
        if ($request->max_socialsentiments != null) {
            $filterData['max_socialsentiments'] = $request->max_socialsentiments;
        }

        $filterData['coin_id'] = $request->coin_id;
        $filterData['symbol'] = $request->symbol;
        $filterData['name'] = $request->name;
        $filterData['coin_name'] = $request->coin_name;
        $filterData['priority'] = $request->priority;

        $notification->data = $filterData;
        $notification->save();
        return response()->json(['status' => true, 'id' => $notification->id]);
    }
    public function allowCoinAlerts(Request $request)
    {
        $user  = User::find(Auth::user()->id);
        $arrayField = [['CoinAlert'=>true]];
        $user->allow_alerts =  $arrayField;
        $user->save();
    }
    public function loadAlertCoinData(Request $request)
    {

        $data = CoinsData::where("coin_id", $request->coinid)->where("symbol", $request->symbol)->first();
        return response()->json(['status' => true, 'data' => $data]);
    }
    public function markAlerts(Request $request)
    {
       $alerts = $request->data;
       foreach ($alerts as $key => $value) {
        $notification =  Notifications::where('id', $value['id'])->first();
        $notification->show_date = Carbon::now();
        $notification->save();
       }
       return response()->json(['status' => true, 'alerts' => $alerts ]);
    }
    public function userNotifications(Request $request)
    {
        $user =Auth::user();
        $notifications = Notifications::
        where('notifiable_id', '=', $user->id)
        ->where('note', '!=',null)
        ->where('show_date', '!=',null)
        ->orderby('show_date', 'DESC')
        ->select('id','note','read_at','data','show_date')
        ->get();
        return response()->json(['status' => true, 'notifications' => $notifications]);
    }
    public function readNotification(Request $request)
    {
          Auth::user()->unreadNotifications->where('id', $request->id)->markAsRead();
          return response()->json(['status' => true]);
    }
    public function CheckApi(Request $request)
    {
         $alerts = $request->data;
        $addPdf = new UnlockingPdf();
        $paths = $alerts;
        $addPdf->file = $paths;
        $addPdf->save();
        return response()->json(['status' => true, 'notifications' => $alerts]);

    }
    public function CheckError(Request $request)
    {
         $alerts = $request->data;
        $addPdf = new UnlockingPdf();
        $paths = $alerts;
        $addPdf->file = $paths;
        $addPdf->save();
        return response()->json(['status' => true, 'notifications' => $alerts]);
    }
    public function triggerNotification(Request $request)
    {
        $arrayToUpdate = array();
       
        Notifications::massUpdate(
            values: $request->all(),
            uniqueBy: 'id'
        );
       return response()->json(['status' => true]);
    
     
    }
}
