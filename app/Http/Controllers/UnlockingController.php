<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoinsData;
use App\Models\CoinsList;
use App\Models\UnlockingPdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $parser = new \Smalot\PdfParser\Parser();
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
    public function dataFromUrl()
    {

        $jsonData = file_get_contents('https://token.unlocks.app/');
        $data = $this->getBetween($jsonData, 'type="application/json">', '</script>');
        $data1 = json_decode($data);
        $data1->props->pageProps->info->data;
        $array = [];
        foreach ($data1->props->pageProps->info->data as $key => $value) {
            $coin = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)
                ->first();

            if ($coin) {

                $coinData = CoinsData::where('coin_id', $coin->coin_id)->first();

                if ($coinData) {
                    $coinData->current_price = $value->token->price;
                    $coinData->fully_diluted_valuation = $value->token->fullyDiluted;
                    $coinData->market_cap = $value->token->marketCap;
                    $coinData->max_supply = $value->token->maxSupply;
                    if ($value->nextEventData != null) {
                        $coinData->next_unlock_date = Carbon::parse($value->nextEventData->beginDate);
                        $coinData->next_unlock_number_of_tokens = $value->nextEventData->amount;

                        $tokenPer = $value->nextEventData->amount / $value->token->maxSupply * 100;
                        $coinData->next_unlock_percent_of_tokens = $tokenPer;

                        if ($tokenPer >= 0 && $tokenPer <= 8) {
                            $coinData->next_unlock_size = 'SMALL';
                        } else if ($tokenPer > 8 && $tokenPer <= 14) {
                            $coinData->next_unlock_size = 'MEDIUM';
                        } else if ($tokenPer > 14) {
                            $coinData->next_unlock_size = 'BIG';
                        }
                    }
                    $coinData->save();
                }
                // $array[] = $coin->coin_id;
                // $array[$coin->coin_id] =  json_decode($this->getChartDetails("https://token.unlocks.app/api/chart/".$coin->coin_id.""));
            }

        }
        // foreach ($data1->props->pageProps->info->data as $key => $value) {
        //     $array[] = CoinsList::where('name', $value->token->name)->where('coins.symbol', $value->token->symbol)->select('coin_data.*')
        //         ->leftJoin('coin_data', 'coins.symbol', '=', 'coin_data.symbol')->first();

        // }
        return $array;

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
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'accept-language: en-US,en;q=0.9',
            'cache-control: max-age=0',
            // 'if-none-match: W/"g9yn8ynf9j7za4"',
            'sec-ch-ua: "Google Chrome";v="107", "Chromium";v="107", "Not=A?Brand";v="24"',
            'sec-ch-ua-mobile: ?0',
            'sec-fetch-dest: document',
            'sec-fetch-mode: navigate',
            'sec-fetch-site: none',
            'sec-fetch-user: ?1',
            'upgrade-insecure-requests: 1',
            'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36',
        ));

       return $str = curl_exec($curl);

       
    //     $curl = curl_init();

    //     curl_setopt($curl, CURLOPT_URL, $url);

    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    //     curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');

    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

    //     $str = curl_exec($curl);

    //     return $str;

        //Get Twitter account
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_URL, $url);
        // $result = curl_exec($ch);
        // curl_close($ch);
        // return json_decode($result);

    }

}
