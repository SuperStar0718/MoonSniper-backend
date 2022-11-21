<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\CoinsData;
use Dotenv\Dotenv;

class GetLunarCrushDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug("Lunarcrush Job started at: ".date("Y-m-d H:i:s"));

        // load dotenv for lunarcrush api key
        $env = Dotenv::createArrayBacked(base_path())->load();

        // query lunarcrush API
        // $response = Http::withHeaders(['Authorization' => 'Bearer '. 'LUNARCRUSH_API_KEY'])->get('https://lunarcrush.com/api3/coins');
        $response = Http::withHeaders(['Authorization' => 'Bearer '. $env["LUNARCRUSH_API_KEY"]])->get('https://lunarcrush.com/api3/coins');
        $response_body = $response->getBody();
        $lunarcrush_data = json_decode($response_body);
        $new_coins_array = array();

        // get unique symbol list
        $existing_symbols_list = CoinsData::select(
            'symbol',
            'historical_social_mentions',
            'historical_social_engagement',
            'social_mentions',
            'social_engagement',
            'average_sentiment',
            'historical_sentiment'
        )->get();
        $existing_symbols = [];
        foreach ($existing_symbols_list as $row) {
            $existing_symbols[$row->symbol] = $row;
        }

        // $existing_symbols = CoinsData::all()->pluck('historical_sentiment', 'symbol')->toArray();
        
        if(!isset($lunarcrush_data->data)) {
            Log::error('Bad API Response: '.$response_body);
            return;
        }

        foreach($lunarcrush_data->data as $coin_data) {
            $symbol = $coin_data->s;
            if(array_key_exists($symbol, $existing_symbols)) {
                $social_mentions = $coin_data->sv;
                $social_engagement = $coin_data->ss;
                $average_sentiment = $coin_data->as;
                $average_sentiment_change = (float) 0.0;
                $social_mentions_change = (float) 0.0;
                $social_engagement_change = (float) 0.0;
                $historical_sentiment = $existing_symbols[$symbol]['historical_sentiment'];
                $historical_social_mentions = $existing_symbols[$symbol]['historical_social_mentions'];
                $historical_social_engagement = $existing_symbols[$symbol]['historical_social_engagement'];
                $current_hour = intval(date('H'));

                if($historical_sentiment == null || $historical_sentiment == "{}") {
                    $historical_sentiment = json_encode([ "values" => [$average_sentiment]]);
                }
                if($historical_social_mentions == null || $historical_social_mentions == "{}") {
                    $historical_social_mentions = json_encode([ "values" => [$social_mentions]]);
                }
                if($historical_social_engagement == null || $historical_social_engagement == "{}") {
                    $historical_social_engagement = json_encode([ "values" => [$social_engagement]]);
                }

                if($current_hour < 12) {
                    // historical sentiment
                    $decoded_historical_sentiment = json_decode($historical_sentiment);
                    if($decoded_historical_sentiment == null) {
                        $decoded_historical_sentiment = (object) [ "values" => array() ];
                    }
                    array_unshift($decoded_historical_sentiment->values, $average_sentiment);
                    if(count($decoded_historical_sentiment->values) > 1) {
                        $today_value = $decoded_historical_sentiment->values[0];
                        $yesterday_value = $decoded_historical_sentiment->values[1];
                        if(($today_value - $yesterday_value) == 0 || $yesterday_value == 0) {
                            $average_sentiment_change = 0.0;
                        } else {
                            $average_sentiment_change = (float)((($today_value - $yesterday_value) / $yesterday_value) * 100);
                        }
                        if(count($decoded_historical_sentiment->values) > 7) {
                            $decoded_historical_sentiment->values = array_slice($decoded_historical_sentiment->values, 0,7);
                        }
                    }
                    $historical_sentiment = json_encode($decoded_historical_sentiment);

                    // historical social engagement
                    $decoded_historical_social_engagement = json_decode($historical_social_engagement);
                    if($decoded_historical_social_engagement == null) {
                        $decoded_historical_social_engagement = (object) [ "values" => array() ];
                    }
                    array_unshift($decoded_historical_social_engagement->values, $social_engagement);
                    if(count($decoded_historical_social_engagement->values) > 1) {
                        $today_value = $decoded_historical_social_engagement->values[0];
                        $yesterday_value = $decoded_historical_social_engagement->values[1];
                        if(($today_value - $yesterday_value) == 0 || $yesterday_value == 0) {
                            $social_engagement_change = 0.0;
                        } else {
                            $social_engagement_change = (float)((($today_value - $yesterday_value) / $yesterday_value) * 100);
                        }
                        if(count($decoded_historical_social_engagement->values) > 7) {
                            $decoded_historical_social_engagement->values = array_slice($decoded_historical_social_engagement->values, 0,7);
                        }
                    }
                    $historical_social_engagement = json_encode($decoded_historical_social_engagement);

                    // historical social mentions
                    $decoded_historical_social_mentions = json_decode($historical_social_mentions);
                    if($decoded_historical_social_mentions == null) {
                        $decoded_historical_social_mentions = (object) [ "values" => array() ];
                    }
                    array_unshift($decoded_historical_social_mentions->values, $social_mentions);

                    if(count($decoded_historical_social_mentions->values) > 1) {
                        $today_value = $decoded_historical_social_mentions->values[0];
                        $yesterday_value = $decoded_historical_social_mentions->values[1];
                        if(($today_value - $yesterday_value) == 0 || $yesterday_value == 0) {
                            $social_mentions_change = 0.0;
                        } else {
                            $social_mentions_change = (float)((($today_value - $yesterday_value) / $yesterday_value) * 100);
                        }
                        if(count($decoded_historical_social_mentions->values) > 7) {
                            $decoded_historical_social_mentions->values = array_slice($decoded_historical_social_mentions->values, 0,7);
                        }
                    }
                    $historical_social_mentions = json_encode($decoded_historical_social_mentions);
                }
                $new_coins_array[] = [
                    "symbol" => $symbol,
                    "average_sentiment" => $average_sentiment,
                    "social_mentions" => $social_mentions,
                    "social_engagement" => $social_engagement,
                    "average_sentiment_change" => $average_sentiment_change,
                    "social_mentions_change" => $social_mentions_change,
                    "social_engagement_change" => $social_engagement_change,
                    "historical_sentiment" => $historical_sentiment,
                    "historical_social_mentions" => $historical_social_mentions,
                    "historical_social_engagement" => $historical_social_engagement
                ];
            }
        }

        try {
            CoinsData::massUpdate(
                values: $new_coins_array,
                uniqueBy: 'symbol'
            );
        }catch (\Exception $exception){
            Log::error("Something went wrong at : ".$exception);
        }
        Log::debug("Lunarcrush Job ended at: ".date("Y-m-d H:i:s"));
    }
}
