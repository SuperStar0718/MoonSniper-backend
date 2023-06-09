<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\CoinsData;
use App\Models\CoinsList;
use App\Models\UnlockingPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Libraries\CoinGecko\CoinGeckoClient;
use App\Notifications\NotifyTokenUnlockNotification;

class UnlockingController extends Controller
{
    public function coinsForAutoSuggest(Request $request)
    {
        $coins = CoinsList::where('name', 'like', $request->key . '%')
            ->orWhere('coins.symbol', 'like', $request->key . '%')
            ->select('coins.coin_id', 'name', 'coins.symbol', 'coin_data.market_cap_rank')
            ->leftJoin('coin_data', 'coin_data.coin_id', '=', 'coins.coin_id')
            ->orderBy(DB::raw('ISNULL(coin_data.market_cap_rank), coin_data.market_cap_rank'), 'ASC')
            ->get();
        return response()->json($coins);
    }
    public function loadSingleCoin(Request $request)
    {
        $coin = DB::table('coins')->where('coin_data.coin_id', $request->coinid)
            ->Join('coin_data', 'coins.coin_id', '=', 'coin_data.coin_id')->select('coin_data.coin_id',
            'coin_data.total_locked',
            'coin_data.next_unlock_date',
            'coin_data.next_unlock_date_text',
            'coin_data.next_unlock_number_of_tokens',
            'coin_data.next_unlock_percent_of_tokens',
            'coin_data.next_unlock_size',
            'coin_data.first_vc_unlock',
            'coin_data.end_vc_unlock',
            'coin_data.first_vc_unlock_text',
            'coin_data.end_vc_unlock_text',
            'coin_data.three_months_unlock_number_of_tokens',
            'coin_data.three_months_unlock_percent_of_tokens',
            'coin_data.three_months_unlock_size',
            'coin_data.six_months_unlock_number_of_tokens',
            'coin_data.six_months_unlock_percent_of_tokens',
            'coin_data.six_months_unlock_size',
            'coin_data.seed_price',
            'coin_data.roi_times',
            'coin_data.atl',
            'coin_data.ath',
            'coin_data.current_price',
            'coin_data.market_cap',
            'coins.coin_category',
        )->first();
        return response()->json(['coin' => $coin]);
    }
    public function loadSingleCoinWithTopFive(Request $request)
    {
        $coin = DB::table('coins')->where('coin_data.coin_id', $request->coinid)
            ->Join('coin_data', 'coins.coin_id', '=', 'coin_data.coin_id')->select('coin_data.coin_id',
            'coin_data.roi_times',
            'coin_data.atl',
            'coin_data.ath',
            'coin_data.current_price',
            'coin_data.market_cap',
            'coins.coin_category',
        )->first();
        if ($coin && $coin->coin_category != null) {
            $coins = CoinsList::where('coin_category', '=', $coin->coin_category)
                ->select('coin_data.market_cap', 'coin_data.market_cap_rank', 'coins.coin_category')
                ->limit(5)
                ->leftJoin('coin_data', 'coin_data.coin_id', '=', 'coins.coin_id')
                ->orderBy(DB::raw('ISNULL(coin_data.market_cap_rank), coin_data.market_cap_rank'), 'ASC')
                ->get();
            return response()->json(['coin' => $coin, 'coins' => $coins]);

        } else {
            return response()->json(['coin' => $coin, 'coins' => null]);
        }

    }
    public function updateCoinData(Request $request)
    {
        $coin = CoinsData::where('coin_id', $request->coinid)->first();
        $coin->total_locked = $request->total_locked;
        $coin->next_unlock_date = $request->next_unlock_date;
        $coin->next_unlock_date_text = $request->next_unlock_date_text;
        $coin->next_unlock_number_of_tokens = $request->next_unlock_number_of_tokens;
        $coin->next_unlock_percent_of_tokens = $request->next_unlock_percent_of_tokens;
        $coin->next_unlock_size = $request->next_unlock_size;
        $coin->first_vc_unlock = $request->first_vc_unlock;
        $coin->end_vc_unlock = $request->end_vc_unlock;
        $coin->first_vc_unlock_text = $request->first_vc_unlock_text;
        $coin->end_vc_unlock_text = $request->end_vc_unlock_text;
        $coin->three_months_unlock_number_of_tokens = $request->three_months_unlock_number_of_tokens;
        $coin->three_months_unlock_percent_of_tokens = $request->three_months_unlock_percent_of_tokens;
        $coin->three_months_unlock_size = $request->three_months_unlock_size;
        $coin->six_months_unlock_number_of_tokens = $request->six_months_unlock_number_of_tokens;
        $coin->six_months_unlock_percent_of_tokens = $request->six_months_unlock_percent_of_tokens;
        $coin->six_months_unlock_size = $request->six_months_unlock_size;
        $coin->seed_price = $request->seed_price;
        $coin->save();
        return response()->json(['status' => 'success']);
    }
    public function UploadPDF(Request $request)
    {

        if ($request->hasFile('pdfFile')) {
            $addPdf = new UnlockingPdf();
            $filenameWithExt = $request->file('pdfFile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pdfFile')->getClientOriginalExtension();
            $filenameWithExt = $filename . '_' . rand(100, 9999);
            $fileNameToStore = $filenameWithExt . '.' . $extension;
            $request->file('pdfFile')->storeAs('public/unlocking/pdfs', $fileNameToStore);
            $paths = $fileNameToStore;
            $addPdf->file = $paths;
            $addPdf->save();
            return response()->json(['status' => 'success', 'filename' => $fileNameToStore]);
        } else {
            return response()->json(['status' => 'failed']);
        }
    }

    public function parsePDF(Request $request)
    {
        // Parse PDF file and build necessary objects.
        $parser = new \Smalot\PdfParser\Parser ();
        $file = storage_path('app') . '/public/unlocking/pdfs/' . $request->input('filename');
        $pdf = $parser->parseFile($file);

        $text = $pdf->getText();
        $pos = $this->strposX($text, 'supply	Size', 3);
        $text = substr($text, $pos + 13);
        $lines = preg_split("/(\r\n|\n|\r)/", $text);
        foreach ($lines as $line) {
            //push to DB each line:
            $row = preg_split("/\t+/", $line);

            $row = array_map(function ($a) {
                return str_replace('A ', 'A', $a);
            }, $row);

            //start saving:
            //get (first!) coin by symbol:
            if (isset($row[1])) {
                $coin = CoinsData::where('symbol', $row[1])->first();
                if ($coin) {

                    $nextUnlockText = null;
                    $nextUnlockDate = null;
                    if (isset($row[7])) {
                        //Next token Date:
                        if (str_contains($row[7], 'Linear across ')) {
                            //we will add the first of this month:
                            $str = substr($row[7], 14);
                            $nextUnlockDate = new Carbon('first day of ' . $str);
                            $nextUnlockText = $row[7];
                        } elseif (str_contains($row[7], 'Weekly across ')) {
                            //TODO: what do we need here?, Ill keep the same:
                            //we will add the first of this month:
                            $str = substr($row[7], 14);
                            $nextUnlockDate = new Carbon('first day of ' . $str);
                            $nextUnlockText = $row[7];
                        } elseif (str_contains($row[7], 'No unlocks until ')) {
                            //Save text only:
                            $nextUnlockText = $row[7];
                        } else {
                            //probably a real date:
                            $date = DateTime::createFromFormat('d-M-y', $row[7]);
                            if ($date !== false) {
                                // it's a date
                                $nextUnlockDate = $date->format('Y-m-d 00:00:00');
                            }
                        }
                    }

                    //Number of tokens:
                    $re = '/^\d+(?:,\d+)*$/';

                    $NumOfTokens = null;
                    if (isset($row[8])) {
                        if (preg_match($re, $row[8])) {
                            $NumOfTokens = intval(str_replace(",", "", $row[8]));
                        }
                    }

                    //percent of circulating supply:
                    $tokensSupplyPercent = null;
                    if (isset($row[9])) {
                        if ($row[9] != '-') {
                            $tokensSupplyPercent = str_replace("%", "", $row[9]);
                        }
                    }

                    //Next Unlock Size:
                    $nextUnlockSize = null;
                    if (isset($row[10])) {
                        if ($row[10] != '-') {
                            $nextUnlockSize = $row[10];
                        }
                    }

                    //first vc unlock:
                    $firstVCUnlock = null;
                    $firstVCUnlockText = null;
                    if (isset($row[5])) {
                        if ($row[5] != 'n.a.') {
                            //probably a real date:
                            $date = DateTime::createFromFormat('d-M-y', $row[5]);
                            if ($date !== false) {
                                // it's a date
                                $firstVCUnlock = $date->format('Y-m-d 00:00:00');
                            }
                        } else {
                            $firstVCUnlockText = "Not Available";
                        }
                    }

                    //Last vc unlock:
                    $lastVCUnlock = null;
                    $lastVCUnlockText = null;
                    if (isset($row[6])) {
                        if ($row[6] != 'n.a.') {
                            //probably a real date:
                            $date = DateTime::createFromFormat('d-M-y', $row[6]);
                            if ($date !== false) {
                                // it's a date
                                $lastVCUnlock = $date->format('Y-m-d 00:00:00');
                            }
                        } else {
                            $lastVCUnlockText = "Not Available";
                        }
                    }

                    //3 Months
                    //num of tokens:
                    $threeMonthsNumberOfTokens = null;
                    if (isset($row[11])) {
                        if (preg_match($re, $row[11])) {
                            $threeMonthsNumberOfTokens = intval(str_replace(",", "", $row[11]));
                        }
                    }

                    //percent of circulating supply:
                    $threeMonthsPercentTokens = null;
                    if (isset($row[12])) {
                        if ($row[12] != '-') {
                            $threeMonthsPercentTokens = str_replace("%", "", $row[12]);
                        }
                    }

                    //Size:
                    $threeMonthsSize = null;
                    if (isset($row[13])) {
                        if ($row[13] != '-') {
                            $threeMonthsSize = $row[13];
                        }
                    }

                    //6 Months
                    //num of tokens:
                    $sixMonthsNumberOfTokens = null;
                    if (isset($row[14])) {
                        if (preg_match($re, $row[14])) {
                            $sixMonthsNumberOfTokens = intval(str_replace(",", "", $row[14]));
                        }
                    }

                    //percent of circulating supply:
                    $sixMonthsPercentTokens = null;
                    if (isset($row[15])) {
                        if ($row[15] != '-') {
                            $sixMonthsPercentTokens = str_replace("%", "", $row[15]);
                        }
                    }

                    //Size:
                    $sixMonthsSize = null;
                    if (isset($row[16])) {
                        if ($row[16] != '-') {
                            $sixMonthsSize = $row[16];
                        }
                    }

                    //Seed price:
                    $seedPrice = null;
                    if (isset($row[3])) {
                        if ($row[3] != 'n.a.') {
                            //probably a real date:
                            $seedPrice = $row[3];
                        }
                    }

                    //$coin->total_locked = $request->total_locked;

                    $coin->next_unlock_date = $nextUnlockDate;
                    $coin->next_unlock_date_text = $nextUnlockText;
                    $coin->next_unlock_number_of_tokens = $NumOfTokens;
                    $coin->next_unlock_percent_of_tokens = $tokensSupplyPercent;
                    $coin->next_unlock_size = $nextUnlockSize;
                    $coin->first_vc_unlock = $firstVCUnlock;
                    $coin->end_vc_unlock = $lastVCUnlock;
                    $coin->first_vc_unlock_text = $firstVCUnlockText;
                    $coin->end_vc_unlock_text = $lastVCUnlockText;
                    $coin->three_months_unlock_number_of_tokens = $threeMonthsNumberOfTokens;
                    $coin->three_months_unlock_percent_of_tokens = $threeMonthsPercentTokens;
                    $coin->three_months_unlock_size = $threeMonthsSize;
                    $coin->six_months_unlock_number_of_tokens = $sixMonthsNumberOfTokens;
                    $coin->six_months_unlock_percent_of_tokens = $sixMonthsPercentTokens;
                    $coin->six_months_unlock_size = $sixMonthsSize;
                    $coin->seed_price = $seedPrice;
                    $coin->save();
                }
            }
        }
        return response()->json(['status' => 'success']);
    }

    private function strposX($haystack, $needle, $number = 0)
    {
        return strpos($haystack, $needle,
            $number > 1 ?
            $this->strposX($haystack, $needle, $number - 1) + strlen($needle) : 0
        );
    }

    public function dataFromUrl($c)
    { 
        $updateCoinsArray = array();
        $coinPreviewData = CoinsData::where('historical_circulation', '!=', null)->get();
        foreach ($coinPreviewData as $key => $coinPreview) {
            $historicalCirculation = json_decode($coinPreview->historical_circulation, true);
            $oldHistoricalCirculation = $historicalCirculation[0];
            $newHistoricalCirculation = end($historicalCirculation);
                $inflationRate = (($newHistoricalCirculation - $oldHistoricalCirculation) / $oldHistoricalCirculation) * 100;
                $inflationRate = round($inflationRate, 2);
                $coin = array(
                    'coin_id' => $coinPreview["coin_id"],
                    'inflation' => $inflationRate,
                );
                $updateCoinsArray[] = $coin;

        }
        CoinsData::massUpdate(
            values:$updateCoinsArray,
            uniqueBy:'coin_id'
        );
        return 'done';
        $client = new CoinGeckoClient(false);
        $coinPreview = null;
        return ($coinPreview == null  ||  !Carbon::parse($coinPreview)->isToday() );
        return !Carbon::parse(null)->isToday();
        $coin_array = $client->coins()->getMarkets('usd', ["sparkline" => "true", "price_change_percentage" => "1h,24h,7d,14d,30d,200d,1y", "per_page" => "250", "page" => 1]);
        $coin_array = collect($coin_array);

        if (isset($coin_array['status']) && isset($coin_array['status']['error_code'])) {
            $error_code = $coin_array['status']['error_code'];
            $error_message = $coin_array['status']['error_message'];

            echo $error_message;

        }
        $newCoinsArray = array();
        $updateCoinsArray = array();
        $newCoinsIds = array();

        //First, lets get ID only to check what is new:
        foreach ($coin_array as $item) {
            if (!empty($item['id'])) {
                $newCoinsIds[] = $item['id'];
            }
        }

        // first get ids from table
        $exist_ids = CoinsData::all('coin_id')->pluck('coin_id')->toArray();

        // get insertable ids (New coins)
        $insertable_ids = array_values(array_diff($newCoinsIds, $exist_ids));

        //What token to remove:

        $exist_list_ids = CoinsList::all('coin_id')->pluck('coin_id')->toArray();
        $purge_ids = array_filter(array_values(array_diff($exist_ids, $exist_list_ids)));

        //get all coins (to make sure we can update them):
        foreach ($coin_array as $item) {
            if (!empty($item['id'])) {

                $ath_datetime = new \DateTime ($item["ath_date"]);
                $ath_datetime_string = $ath_datetime->format('Y-m-d H:i:s');

                $atl_datetime = new \DateTime ($item["atl_date"]);
                $atl_datetime_string = $atl_datetime->format('Y-m-d H:i:s');

                $spark_string = "";
                try {
                    for ($sparkline_index = 0; $sparkline_index < sizeof($item["sparkline_in_7d"]["price"]); $sparkline_index++) {
                        $spark_string .= $item["sparkline_in_7d"]["price"][$sparkline_index] . "|";
                    }

                } catch (\Exception $e) {
                }

                /*if ($item["roi"] != null) {
                $roi_times = $item["roi"]["times"];
                $roi_currency = $item["roi"]["currency"];
                $roi_percentage = $item["roi"]["percentage"];
                } else {
                $roi_times = "";
                $roi_currency = "";
                $roi_percentage = "";
                }*/

                $total_supply_percent = null;
                if ($item["max_supply"] != null && $item["circulating_supply"] != null) {
                    $total_supply_percent = (floatval($item["circulating_supply"]) * 100) / floatval($item["max_supply"]);
                }
                $volume = null;
                $volume_date = Carbon::now();
                $coinPreview = CoinsData::where('coin_id', $item["id"])->first();
                $historicalCirculation = null;
                $inflationRate = 0.00;
                if ($coinPreview ) {
                    $historicalCirculation = $coinPreview->historical_circulation;
                    // && !Carbon::parse($coinPreview->last_volume_date)->isToday() 
                    if ($item["circulating_supply"] != null ) {

                        if ($coinPreview->historical_circulation === null) {
                            // Create a new array with the current value of $item["circulating_supply"]
                            $historicalCirculation = [$item["circulating_supply"]];
                        } else {

                            // Convert existing historical_circulation JSON string to an array
                            $historicalCirculation = json_decode($coinPreview->historical_circulation, true);

                            // Add the new value of $item["circulating_supply"] to the array
                            $historicalCirculation[] = $item["circulating_supply"];

                            // Ensure that the array has a maximum length of 30
                            if (count($historicalCirculation) > 30) {
                                // Remove the oldest value from the array
                                $historicalCirculation = array_shift($historicalCirculation);
                            }

                            // Convert the modified array back to a JSON string
                        }
                        return  $historicalCirculation;
                        if (count($historicalCirculation) > 1) {
                            $oldHistoricalCirculation = $historicalCirculation[0];
                            $newHistoricalCirculation = end($historicalCirculation);
                            if($newHistoricalCirculation != NULL && $oldHistoricalCirculation != null && $newHistoricalCirculation != $oldHistoricalCirculation){
                            $inflationRate = (($newHistoricalCirculation - $oldHistoricalCirculation) / $oldHistoricalCirculation) * 100;
                            $inflationRate = round($inflationRate, 2);
                            }else{
                            $inflationRate = 0.00;
                            }
                        }
                        $historicalCirculation = json_encode($historicalCirculation);
                    }

                }
                if ($coinPreview && !Carbon::parse($coinPreview->last_volume_date)->isToday() || $coinPreview && $coinPreview->volume_history == null) {
                    if ($coinPreview->volume_history == null) {
                        $volume = $item["total_volume"];
                    } else {
                        $volumeList = preg_split("/\,/", $coinPreview->volume_history);
                        if (count($volumeList) > 1) {
                            $volume = $volumeList[1] . ',' . $item["total_volume"];
                        } else {
                            $volume = $volumeList[0] . ',' . $item["total_volume"];
                        }

                    }

                    $volume_date = Carbon::now();

                } else {
                    if ($coinPreview) {
                        $volume = $coinPreview->volume_history;
                        $volume_date = $coinPreview->last_volume_date;
                        // $historicalCirculation = $coinPreview->historical_circulation;
                    }
                }
             return   $coin = array(
                    'coin_id' => $item["id"],
                    'symbol' => strtoupper($item["symbol"]),
                    'image' => $item["image"],
                    'current_price' => $item["current_price"],
                    'market_cap' => $item["market_cap"],
                    'market_cap_rank' => $item["market_cap_rank"],
                    'fully_diluted_valuation' => $item["fully_diluted_valuation"],
                    'total_volume' => $item["total_volume"],
                    'volume_history' => $volume,
                    'last_volume_date' => $volume_date,
                    'high_24h' => $item["high_24h"],
                    'low_24h' => $item["low_24h"],
                    'price_change_24h' => $item["price_change_24h"],
                    'price_change_percentage_24h' => $item["price_change_percentage_24h"],
                    'market_cap_change_24h' => $item["market_cap_change_24h"],
                    'market_cap_change_percentage_24h' => $item["market_cap_change_percentage_24h"],
                    'circulating_supply' => $item["circulating_supply"],
                    'historical_circulation' => $historicalCirculation,
                    'inflation' => $inflationRate,
                    'total_supply' => $item["total_supply"],
                    'total_supply_percent' => $total_supply_percent,
                    'max_supply' => $item["max_supply"],
                    'ath' => $item["ath"],
                    'ath_change_percentage' => $item["ath_change_percentage"],
                    'ath_date' => $ath_datetime_string,
                    'atl' => $item["atl"],
                    'atl_change_percentage' => $item["atl_change_percentage"],
                    'atl_date' => $atl_datetime_string,
                    'price_change_percentage_14d_in_currency' => $item["price_change_percentage_14d_in_currency"],
                    'price_change_percentage_1h_in_currency' => $item["price_change_percentage_1h_in_currency"],
                    'price_change_percentage_1y_in_currency' => $item["price_change_percentage_1y_in_currency"],
                    'price_change_percentage_200d_in_currency' => $item["price_change_percentage_200d_in_currency"],
                    'price_change_percentage_24h_in_currency' => $item["price_change_percentage_24h_in_currency"],
                    'price_change_percentage_30d_in_currency' => $item["price_change_percentage_30d_in_currency"],
                    'price_change_percentage_7d_in_currency' => $item["price_change_percentage_7d_in_currency"],
                    'sparkline_in_7d' => $spark_string,
                    'created_at' => now(),
                    'updated_at' => now(),
                );

            }
        }
    }
    private function tryPushingToDB($arr, $iterates = 0)
    {
        //if its too many records, lets split it...
        foreach (array_chunk($arr, 1000) as $t) {
            try {
                //if there is a duplication order id from any reason, continue...
                CoinsData::insert($t);
                //Log::info("Finance Data has Pushed");
            } catch (\Exception $e) {
                //Log should be added here
                Log::info('PROBLEM:' . $e);

                Log::info('Trying Again!');

                if ($iterates < 20) {
                    //Check what is happening?

                    $iterates++;
                    //Call again:
                    $this->tryPushingToDB($t, $iterates);
                } else {
                    Log::info('Im giving up :(');
                }

            }
        }
    }
    public static function getBetween2($content, $start, $end)
    {
        $r = explode($start, $content);
        $arr = array();
        for ($i = 0; $i < count($r); $i++) {
            if (isset($r[$i])) {
                $r = explode($end, $r[1]);
                $arr[] = $r[0];
            }
        }
        return $arr;
        return '';
    }
    public static function getBetween($content, $start, $end)
    {
        $r = explode($start, $content);
        if (isset($r[1])) {
            $r = explode($end, $r[1]);
            return $r[0];
        }
        return '';
    }
    public function getChartDetails($url)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'accept-language: en-US,en;q=0.9,gu;q=0.8,zh-CN;q=0.7,zh;q=0.6,te;q=0.5',
            'cache-control: max-age=0',
            'cookie: _ga=GA1.1.198816369.1666948558; _hjSessionUser_3057115=eyJpZCI6IjRhMzNkYWVkLWFmZmMtNTdkZi04Mjg0LTcwZDAyNjM0ODlhMiIsImNyZWF0ZWQiOjE2NjY5NDg1NTgxMDgsImV4aXN0aW5nIjp0cnVlfQ==; _hjSession_3057115=eyJpZCI6ImVmNjc3ZGNjLWE0ZjEtNGQ1YS04MzgxLWMxNTNlN2NjZGVhNyIsImNyZWF0ZWQiOjE2NjcyODIwNzg5MDUsImluU2FtcGxlIjpmYWxzZX0=; _hjAbsoluteSessionInProgress=0; _hjIncludedInSessionSample=0; csrfSecret=5r6LUd9a-iXsrpe0HimUmksLRS0wdjNsNnaw.iWfA9P87zb8HbR%252Fo0NGHOKsPXqLD7BAgtl7RScYy4LE; amp_46195f=ovvAh7Wzz3MabEYXZm9fAN...1ggos792c.1ggouroei.1f.0.1f; _ga_75CFN3DMPM=GS1.1.1667282078.10.1.1667284985.52.0.0; uNchBAnD=oAuW6l4u-6mWSRVkJLou4zG7Z35xzV_OOG-0.vCOnwC%2BO0fGkxw3ILHbKmlW5FF8hhYMnwv%2FlKSqufjM',
            'if-none-match: W/"3bgljgn2u32ujh"',
            'sec-ch-ua: "Chromium";v="106", "Google Chrome";v="106", "Not;A=Brand";v="99"',
            'sec-ch-ua-mobile: ?0',
            // 'sec-ch-ua-platform: "Windows"',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: none',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36',
        ));
        return $str = curl_exec($curl);

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        // $str = curl_exec($curl);
        // return $str;
        //Get Twitter account
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_URL, $url);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // return json_decode($result);

    }
    public function notifyTokenUnlock(Request $request)
    {
        $user = Auth::user();
        $checkNotification = $user->notifications()
            ->whereJsonContains('data', ['symbol' => $request->symbol, 'coin_id' => $request->coin_id])
            ->where('note', null)
            ->first();
        if (!$checkNotification) {
            $token = DB::table('coins')
                ->select('coins.coin_id', 'coins.name', 'coins.symbol', 'coin_data.image', 'coin_data.current_price', 'coin_data.market_cap_rank', 'coin_data.next_unlock_date', 'coin_data.next_unlock_date', 'coin_data.next_unlock_date_text', 'coin_data.next_unlock_number_of_tokens')
                ->leftJoin('coin_data', function ($join) {
                    $join->on('coins.symbol', '=', 'coin_data.symbol')
                        ->whereRaw('coins.coin_id = coin_data.coin_id');
                })
                ->where('coins.symbol', $request->symbol)
                ->where('coins.coin_id', $request->coin_id)
                ->first();
            if ($token) {
                $token->notifytype = $request->type;
                $user->notify((new NotifyTokenUnlockNotification($token)));
                return response()->json(['status' => true, 'notification' => 'sent']);
            }
            return response()->json(['status' => false]);

        } else {
            $checkNotification->delete();
            return response()->json(['status' => true, 'notification' => 'removed']);

        }

    }
    public function checkCoinNotified(Request $request)
    {
        $user = Auth::user();
        $checkNotification = $user->notifications()
            ->whereJsonContains('data', ['symbol' => $request->symbol, 'coin_id' => $request->coin_id])
            ->where('note', null)
            ->first();
        if ($checkNotification) {
            return response()->json(['status' => true, 'notification' => 'sent', 'item' => $checkNotification]);

        } else {

            return response()->json(['status' => true, 'notification' => 'notsent']);

        }
    }
    public function GeneratePermissions()
    {
        # code...
    }

}
