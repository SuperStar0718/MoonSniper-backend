<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Iksaku\Laravel\MassUpdate\MassUpdatable;

class CoinsData extends Model
{
    use HasFactory;
    use MassUpdatable;
    protected $table = 'coin_data';
    public $timestamps = true;
    protected $fillable = ['coin_id','coingeckoid', 'symbol', 'image', 'current_price', 'market_cap', 'market_cap_rank', 'fully_diluted_valuation', 'total_volume', 'high_24h', 'low_24h', 'price_change_24h', 'price_change_percentage_24h', 'market_cap_change_24h', 'market_cap_change_percentage_24h', 'circulating_supply','inflation','historical_circulation','last_historical_circulation', 'total_supply', 'max_supply', 'ath', 'ath_change_percentage', 'ath_date', 'atl', 'atl_change_percentage', 'atl_date', 'roi_times', 'roi_currency', 'roi_percentage', 'updated_at', 'created_at', 'price_change_percentage_14d_in_currency', 'price_change_percentage_1h_in_currency', 'price_change_percentage_1y_in_currency', 'price_change_percentage_200d_in_currency', 'price_change_percentage_24h_in_currency', 'price_change_percentage_30d_in_currency', 'price_change_percentage_7d_in_currency', 'sparkline_in_7d', 'trading_volume', 'description', 'platform', 'total_supply_percent', 'seed_price', 'roi_seed', 'total_locked', 'next_unlock_date',  'next_unlock_date_text', 'total_locked_percent', 'next_unlock_percent', 'next_unlock_status', 'next_unlock_number_of_tokens', 'next_unlock_percent_of_tokens', 'next_unlock_size', 'first_vc_unlock', 'end_vc_unlock', 'first_vc_unlock_text', 'end_vc_unlock_text', 'three_months_unlock_number_of_tokens', 'three_months_unlock_percent_of_tokens', 'three_months_unlock_size', 'six_months_unlock_number_of_tokens', 'six_months_unlock_percent_of_tokens', 'six_months_unlock_size', 'social_mentions', 'social_engagement', 'average_sentiment', 'historical_sentiment', 'historical_social_mentions', 'historical_social_engagement', 'average_sentiment_change', 'social_mentions_change', 'social_engagement_change'];
    protected $attributes = [
        'historical_sentiment' => '{
            "values": []
        }',
        'historical_social_mentions' => '{
            "values": []
        }',
        'historical_social_engagement' => '{
            "values": []
        }'
    ];
}
