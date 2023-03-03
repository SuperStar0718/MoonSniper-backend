<?php

namespace App\Http\Controllers;

use stdClass;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\CoinsData;
use App\Models\CoinsList;
use App\Models\Dashboard;
use App\Models\UserColumn;
use Illuminate\Http\Request;
use App\Models\UserFavorites;
use App\Models\ExchangeTicker;
use Illuminate\Support\Facades\DB;
use App\Models\TradingVolumeHistory;
use Illuminate\Support\Facades\Auth;

class Coingecko extends Controller
{
    public function get_coin_count()
    {
        echo json_encode(CoinsList::count());
    }

    public function get_coin_list()
    {
        echo json_encode(CoinsList::all());
    }

    public function get_fear_greed()
    {
        $data = Dashboard::first();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://markets.chainalysis.com/api/inflows-to-exchanges?asset=BTC');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $str = curl_exec($curl);
        $result = curl_exec($curl);
        curl_close($curl);
        return response()->json(['data'=>$data, 'btcflow'=>$result]);
        return null;

    }

    // Filter coin data by some criterias & paginate with 50 records per page
    public function get_coin_prices(Request $request)
    {

        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);
        $query = DB::table('coins');
        $favorites = UserFavorites::where('user_id', Auth::user()->id)->get();

        if (intval($input_array["api_mode"]) == 2) {
            $query->whereRaw("(coin_data.`next_unlock_date` IS NOT NULL OR coin_data.`next_unlock_date_text` IS NOT NULL OR coin_data.`total_locked_percent` IS NOT NULL OR coin_data.`next_unlock_percent` IS NOT NULL  OR coin_data.`next_unlock_number_of_tokens` IS NOT NULL OR coin_data.`next_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`next_unlock_size` IS NOT NULL OR coin_data.`first_vc_unlock` IS NOT NULL OR coin_data.`end_vc_unlock` IS NOT NULL OR coin_data.`first_vc_unlock_text` IS NOT NULL OR coin_data.`end_vc_unlock_text` IS NOT NULL OR coin_data.`three_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_size` IS NOT NULL OR coin_data.`six_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_size` IS NOT NULL)");
        }
        if ($input_array["filters2"] == "" &&( $input_array["sort"][1] == "asc" || $input_array["sort"][1] == "desc")) {
            $query->orderBy(DB::raw("ISNULL(" . $input_array["sort"][0] . "), " . $input_array["sort"][0]), $input_array["sort"][1]);
        }
        if ($input_array["filters2"] != "") {
            // $query->where(DB::raw("CONCAT(coins.`name`, ' ', coins.`symbol`)"), 'LIKE', "%" . $input_array["filters2"] . "%");
            $query->where(function($q) use ($input_array) {
                $q->where('coins.symbol', '=', $input_array["filters2"])
                  ->orWhere(DB::raw("CONCAT(coins.`symbol`, ' ', coins.`name`)"), 'LIKE', $input_array["filters2"] . '%')
                  ->orWhere(DB::raw("CONCAT(coins.`symbol`, ' ', coins.`name`)"), 'LIKE', '%' . $input_array["filters2"] . '%')
                  ->orWhere('coins.name', 'LIKE', '%' . $input_array["filters2"] . '%');
            })
            ->orderByRaw("CASE WHEN coins.symbol = '" . $input_array["filters2"] . "' THEN 1 
                                WHEN coins.symbol LIKE '" . $input_array["filters2"] . "%' THEN 2 
                                WHEN coins.symbol LIKE '%" . $input_array["filters2"] . "%' THEN 3 
                                ELSE 4 END");
        }else{
            $query->where('coin_data.market_cap', '!=', null)->where('coin_data.market_cap', '!=', '');
        }
        if ($input_array["selectedExchange"] && count($input_array["selectedExchange"]) > 0) {
            $seList = [];
            foreach ($input_array["selectedExchange"] as $key => $value) {
                $seList[] = $value['exchangeid'];
            }
            $BaseByExchange = ExchangeTicker::whereIn('exchange_id', $seList)->distinct()->pluck('base');
            $query->whereIn('coins.symbol', $BaseByExchange);
        }
        $query->select('*')
            ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol');
        if (intval($input_array["favoritesMode"]) == 1) {
            // $query->where('coins.symbol','!=',null);
            $query->join('user_favorites', function ($join) {
                $join->on('coins.symbol', '=', 'user_favorites.coin_symbol')
                    ->on('coins.coin_id', '=', 'user_favorites.coinid')->where('user_favorites.user_id', Auth::user()->id);
            });
        }
        $data = $query->whereColumn('coin_data.coin_id', '=', 'coins.coin_id')
            ->where($input_array["filters"])
        // ->where('coin_data.market_cap','>',0)
            ->whereNotNull('coin_data.coin_id')
            ->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
        $favorites = UserFavorites::where('user_id', Auth::user()->id)->get();

        // Masking Data for Free Users
        $logged_in_user = Auth::user();
        if ($logged_in_user->currentPlan == 'free') {
            for ($data_index = 0; $data_index < count($data); $data_index++) {
                // Don't Mask Values for Coins with Flag = 1
                if (!(intval($data[$data_index]->market_cap_rank) >= 1 && intval($data[$data_index]->market_cap_rank) <= 5)) {
                    $data[$data_index]->seed_price = "********";
                    $data[$data_index]->roi_seed = "********";
                    // $data[$data_index]->total_locked = "********";
                    $data[$data_index]->next_unlock_date = "********";
                    $data[$data_index]->next_unlock_date_text = "********";
                    $data[$data_index]->next_unlock_number_of_tokens = "********";
                    $data[$data_index]->next_unlock_percent_of_tokens = "********";
                    $data[$data_index]->next_unlock_size = "********";
                    $data[$data_index]->first_vc_unlock = "********";
                    $data[$data_index]->end_vc_unlock = "********";
                    $data[$data_index]->first_vc_unlock_text = "********";
                    $data[$data_index]->end_vc_unlock_text = "********";
                    $data[$data_index]->three_months_unlock_number_of_tokens = "********";
                    $data[$data_index]->three_months_unlock_percent_of_tokens = "********";
                    $data[$data_index]->three_months_unlock_size = "********";
                    $data[$data_index]->six_months_unlock_number_of_tokens = "********";
                    $data[$data_index]->six_months_unlock_percent_of_tokens = "********";
                    $data[$data_index]->six_months_unlock_size = "********";
                    // $data[$data_index]->next_unlock_status = "********";
                }

            }
        }
        return response()->json(['status' => true, 'tokens' => $data, 'favorites' => $favorites]);
        echo json_encode($data);

    }
    public function get_single_coin($coinid)
    {
        $data = CoinsData::where("coin_id", $coinid)->first();
        echo json_encode($data);
    }
    

    public function get_trading_volume_history(Request $request)
    {
        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);

        $coin_id = $input_array["coin_id"];
        $symbol = $input_array["symbol"];

        $data = TradingVolumeHistory::where("coin_id", $coin_id)->where("symbol", $symbol)->get();
        return json_encode($data);
    }
    public function updateVisibleFields(Request $request)
    {

        $Columns = UserColumn::where('user_id', '=', Auth::user()->id)->where('mode', '=', $request->mode)->first();
        if ($Columns) {
            $Columns->columns = $request->fields;
            $Columns->save();
        } else {
            $Columns = new UserColumn();
            $Columns->columns = $request->fields;
            $Columns->mode = $request->mode;
            $Columns->user_id = Auth::user()->id;
            $Columns->save();
        }

        $columnsObject = json_decode($Columns->columns);
        return response()->json(['status' => true, 'fields' => $columnsObject]);
    }

    public function loadVisibleFileds(Request $request)
    {
        $Columns = UserColumn::where('user_id', '=', Auth::user()->id)->where('mode', '=', $request->mode)->first();
        $OrderColumns = UserColumn::where('user_id', '=', Auth::user()->id)->where('mode', '=',  $request->orderMode)->first();
        if ($Columns) {
            $columnsObject = json_decode($Columns->columns);
            return response()->json(['status' => true, 'fields' => $columnsObject, 'mode' => $Columns->mode,'orderColumns'=>$OrderColumns]);
        } else {
            return response()->json(['status' => false, 'fields' => null,'orderColumns'=>$OrderColumns]);
        }
    }
    public function manageFavorites(Request $request)
    {
        $favorites = UserFavorites::where('coin_symbol', $request->symbol)->where('coinid', $request->coin_id)->where('user_id', Auth::user()->id)->first();
        if ($favorites) {
            $favorites->delete();
            return response()->json(['status' => true, 'favorite' => 'removed']);
        } else {
            $favorites = new UserFavorites();
            $favorites->coin_symbol = $request->symbol;
            $favorites->coinid = $request->coin_id;
            $favorites->user_id = Auth::user()->id;
            $favorites->save();
            return response()->json(['status' => true, 'favorite' => 'added', 'favorites' => $favorites]);

        }
    }
    public function ethGasPrice()
    {
        $url = 'https://api.etherscan.io/api?module=gastracker&action=gasoracle&apikey=PPC3KTB1AUAKS4UE3M8RFKK8XI1YGXID9K';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15"));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $ethprice = json_decode($result, true);

        return response()->json($ethprice);
    }
    public function marketcapValues()
    {
        $url = 'https://www.coingecko.com/market_cap/total_charts_data?duration=7&locale=en&vs_currency=usd';
        $client = new Client();
        $response = $client->get($url );
        $result = $response->getBody();
        $mcValues = json_decode($result, true);
        return response()->json(['status'=>true, 'mcValues'=>$mcValues]);
    }
    public function loadPriceChartByCoin(Request $request)
    {

        $apisData = array();
        $typeApi = ['24_hours.json', '7_days.json', '14_days.json', '30_days.json', 'max.json'];
        $type = $request->type;
        switch ($type) {
            case '24':
                $value = '24_hours.json';
                break;
            case '7':
                $value = '7_days.json';
                break;
            case '14':
                $value = '14_days.json';
                break;
            case '30':
                $value = '30_days.json';
                break;
            case '90':
                $value = '90_days.json';
                break;
            case '365':
                $value = '365_days.json';
                break;
            case 'all':
                $value = 'max.json';
                break;
            default:
                $value = 'max.json';
                break;
        }
        $url = 'https://www.coingecko.com/price_charts/' . $request->coingickoid . '/usd/' . $value . '';
        
          $client = new Client();
                $response = $client->get($url );
                $result = $response->getBody();
    
        $data = json_decode($result, true);
        $apisData[$value] = $data;
        switch ($type) {
            case '24':
                $typeData = $apisData['24_hours.json']['stats'];
                break;
            case '7':
                $typeData = '7_days.json';
                $typeData = $apisData['7_days.json']['stats'];
                break;
            case '14':
                $typeData = $apisData['14_days.json']['stats'];
                break;
            case '30':
                $typeData = $apisData['30_days.json']['stats'];
                break;
            case '90':
                $typeData = $apisData['90_days.json']['stats'];
                break;
            case '365':
                $typeData = $apisData['365_days.json']['stats'];
                break;
            case 'all':
                $typeData = $apisData['max.json']['stats'];
                break;
            default:
                $typeData = $apisData['max.json']['stats'];
                break;
        }
        return response()->json(['status'=>true,'chart'=>$typeData]);
    }
    public function loadMcChartByCoin(Request $request)
    {

        $apisData = array();
        $typeApi = ['24_hours.json', '7_days.json', '14_days.json', '30_days.json', 'max.json'];
        $type = $request->type;
        switch ($type) {
            case '24':
                $value = '24_hours.json';
                break;
            case '7':
                $value = '7_days.json';
                break;
            case '14':
                $value = '14_days.json';
                break;
            case '30':
                $value = '30_days.json';
                break;
            case '90':
                $value = '90_days.json';
                break;
            case '365':
                $value = '365_days.json';
                break;
            case 'all':
                $value = 'max.json';
                break;
            default:
                $value = 'max.json';
                break;
        }
        $url = 'https://www.coingecko.com/market_cap/' . $request->coingickoid . '/usd/' . $value . '';
        $client = new Client();
                $response = $client->get($url );
                $result = $response->getBody();
        $data = json_decode($result, true);
        $apisData[$value] = $data;
        switch ($type) {
            case '24':
                $typeData = $apisData['24_hours.json']['stats'];
                break;
            case '7':
                $typeData = '7_days.json';
                $typeData = $apisData['7_days.json']['stats'];
                break;
            case '14':
                $typeData = $apisData['14_days.json']['stats'];
                break;
            case '30':
                $typeData = $apisData['30_days.json']['stats'];
                break;
            case '90':
                $typeData = $apisData['90_days.json']['stats'];
                break;
            case '365':
                $typeData = $apisData['365_days.json']['stats'];
                break;
            case 'all':
                $typeData = $apisData['max.json']['stats'];
                break;
            default:
                $typeData = $apisData['max.json']['stats'];
                break;
        }
        return response()->json(['status'=>true,'chart'=>$typeData]);
    }
    public function updateUserFields(Request $request)
    {
        $Columns = UserColumn::where('user_id', '=', Auth::user()->id)->where('mode', '=', $request->mode)->first();
        if ($Columns) {
            $Columns->columns = json_encode($request->keyArray);
            $Columns->save();
        } else {
            $Columns = new UserColumn();
            $Columns->columns =  json_encode($request->keyArray);
            $Columns->mode =$request->mode;
            $Columns->user_id = Auth::user()->id;
            $Columns->save();
        }
        
        $columnsObject = json_decode($Columns->columns);
        return response()->json(['status' => true, 'fields' => $columnsObject]);
    }
}
