<?php

namespace App\Http\Controllers;

use App\Models\CoinsData;
use App\Models\CoinsList;
use App\Models\Dashboard;
use App\Models\TradingVolumeHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return json_encode($data);
        return null;

    }

    // Filter coin data by some criterias & paginate with 50 records per page
    public function get_coin_prices(Request $request)
    {

        $input_json = $request->getContent();
        $input_array = json_decode($input_json, true);
        if(intval($input_array["api_mode"]) == 1 ) 
        {
            if ($input_array["sort"][1] == "asc" || $input_array["sort"][1] == "desc") {

                //$input_array["sort"][0] = DB::raw("-".$input_array["sort"][0]);
                //$input_array["sort"][0] = DB::raw("COALESCE(".$input_array["sort"][0].",zz)");

                /*$numberic_columns = array('market_cap_rank', 'current_price','market_cap',  'total_volume','high_24h','low_24h','price_change_percentage_24h','ath','atl','roi_times','roi_percentage');
            )
                if(in_array($input_array["sort"][0], $numeric_columns) && $input_array["sort"][0] == "desc")
                {
                    $input_array["sort"][0] = DB::raw("-".$input_array["sort"][0]);
                    $input_array["sort"][1] = "desc";
                }*/



                if($input_array["filters2"] != "")
                {
                    $data = DB::table('coins')
                    ->select('*')
                    ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                    ->where($input_array["filters"])
                    ->whereNotNull('coin_data.coin_id')
                    ->where(DB::raw("CONCAT(coins.`name`, ' ', coins.`symbol`)"), 'LIKE', "%".$input_array["filters2"]."%")
                    ->orderBy(DB::raw("ISNULL(".$input_array["sort"][0]."), ".$input_array["sort"][0]), $input_array["sort"][1])
                    ->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
                }else
                {
                    $data = DB::table('coins')
                    ->select('*')
                    ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                    ->where($input_array["filters"])
                    ->whereNotNull('coin_data.coin_id')
                    ->orderBy(DB::raw("ISNULL(".$input_array["sort"][0]."), ".$input_array["sort"][0]), $input_array["sort"][1])
                    ->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
                }
                


            } else {
                if($input_array["filters2"] != "")
                {
                    $data = DB::table('coins')
                        ->select('*')
                        ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                        ->where($input_array["filters"])
                        ->where(DB::raw("CONCAT(coins.`name`, ' ', coins.`symbol`)"), 'LIKE', "%".$input_array["filters2"]."%")
                        ->paginate(100);
                }
                else
                {
                    $data = DB::table('coins')
                        ->select('*')
                        ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                        ->where($input_array["filters"])
                        ->paginate(100);
                }

            }
        }else if(intval($input_array["api_mode"]) == 2 )
        {
                if ($input_array["sort"][1] == "asc" || $input_array["sort"][1] == "desc") {

                if($input_array["filters2"] != "")
                {
                    $data = DB::table('coins')
                    ->select('*')
                    ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                    ->where($input_array["filters"])
                    ->whereNotNull('coin_data.coin_id')
                    ->where(DB::raw("CONCAT(coins.`name`, ' ', coins.`symbol`)"), 'LIKE', "%".$input_array["filters2"]."%")
                    ->whereRaw("(coin_data.`next_unlock_date` IS NOT NULL OR coin_data.`next_unlock_date_text` IS NOT NULL OR coin_data.`total_locked_percent` IS NOT NULL OR coin_data.`next_unlock_percent` IS NOT NULL OR coin_data.`next_unlock_status` IS NOT NULL OR coin_data.`next_unlock_number_of_tokens` IS NOT NULL OR coin_data.`next_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`next_unlock_size` IS NOT NULL OR coin_data.`first_vc_unlock` IS NOT NULL OR coin_data.`end_vc_unlock` IS NOT NULL OR coin_data.`first_vc_unlock_text` IS NOT NULL OR coin_data.`end_vc_unlock_text` IS NOT NULL OR coin_data.`three_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_size` IS NOT NULL OR coin_data.`six_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_size` IS NOT NULL)")
                    ->orderBy(DB::raw("ISNULL(".$input_array["sort"][0]."), ".$input_array["sort"][0]), $input_array["sort"][1])
                    ->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
                }else
                {
                    $data = DB::table('coins')
                    ->select('*')
                    ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                    ->where($input_array["filters"])
                    ->whereNotNull('coin_data.coin_id')
                    ->whereRaw("(coin_data.`next_unlock_date` IS NOT NULL OR coin_data.`next_unlock_date_text` IS NOT NULL OR coin_data.`total_locked_percent` IS NOT NULL OR coin_data.`next_unlock_percent` IS NOT NULL OR coin_data.`next_unlock_status` IS NOT NULL OR coin_data.`next_unlock_number_of_tokens` IS NOT NULL OR coin_data.`next_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`next_unlock_size` IS NOT NULL OR coin_data.`first_vc_unlock` IS NOT NULL OR coin_data.`end_vc_unlock` IS NOT NULL OR coin_data.`first_vc_unlock_text` IS NOT NULL OR coin_data.`end_vc_unlock_text` IS NOT NULL OR coin_data.`three_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_size` IS NOT NULL OR coin_data.`six_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_size` IS NOT NULL)")
                    ->orderBy(DB::raw("ISNULL(".$input_array["sort"][0]."), ".$input_array["sort"][0]), $input_array["sort"][1])
                    ->paginate($input_array["perpage"] ? $input_array["perpage"] : 6);
                }
                


            } else {
                if($input_array["filters2"] != "")
                {
                    $data = DB::table('coins')
                        ->select('*')
                        ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                        ->where($input_array["filters"])
                        ->where(DB::raw("CONCAT(coins.`name`, ' ', coins.`symbol`)"), 'LIKE', "%".$input_array["filters2"]."%")
                        ->whereRaw("(coin_data.`next_unlock_date` IS NOT NULL OR coin_data.`next_unlock_date_text` IS NOT NULL OR coin_data.`total_locked_percent` IS NOT NULL OR coin_data.`next_unlock_percent` IS NOT NULL OR coin_data.`next_unlock_status` IS NOT NULL OR coin_data.`next_unlock_number_of_tokens` IS NOT NULL OR coin_data.`next_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`next_unlock_size` IS NOT NULL OR coin_data.`first_vc_unlock` IS NOT NULL OR coin_data.`end_vc_unlock` IS NOT NULL OR coin_data.`first_vc_unlock_text` IS NOT NULL OR coin_data.`end_vc_unlock_text` IS NOT NULL OR coin_data.`three_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_size` IS NOT NULL OR coin_data.`six_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_size` IS NOT NULL)")
                        ->paginate(100);
                }
                else
                {
                    $data = DB::table('coins')
                        ->select('*')
                        ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')
                        ->where($input_array["filters"])
                        ->whereRaw("(coin_data.`next_unlock_date` IS NOT NULL OR coin_data.`next_unlock_date_text` IS NOT NULL OR coin_data.`total_locked_percent` IS NOT NULL OR coin_data.`next_unlock_percent` IS NOT NULL OR coin_data.`next_unlock_status` IS NOT NULL OR coin_data.`next_unlock_number_of_tokens` IS NOT NULL OR coin_data.`next_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`next_unlock_size` IS NOT NULL OR coin_data.`first_vc_unlock` IS NOT NULL OR coin_data.`end_vc_unlock` IS NOT NULL OR coin_data.`first_vc_unlock_text` IS NOT NULL OR coin_data.`end_vc_unlock_text` IS NOT NULL OR coin_data.`three_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`three_months_unlock_size` IS NOT NULL OR coin_data.`six_months_unlock_number_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_percent_of_tokens` IS NOT NULL OR coin_data.`six_months_unlock_size` IS NOT NULL)")
                        ->paginate(100);
                }

            }
        }
        // Masking Data for Free Users
        $logged_in_user = Auth::user();
        if ($logged_in_user->currentPlan == 'basic') {
            for ($data_index = 0; $data_index < count($data); $data_index++) {
                // Don't Mask Values for Coins with Flag = 1
                if (!(intval($data[$data_index]->market_cap_rank) >= 1 && intval($data[$data_index]->market_cap_rank) <= 5)) {
                    $data[$data_index]->seed_price = "********";
                    $data[$data_index]->roi_seed = "********";
                    $data[$data_index]->total_locked = "********";
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
                    $data[$data_index]->next_unlock_status = "********";
                }

            }
        }

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
        echo json_encode($data);
    }
}
