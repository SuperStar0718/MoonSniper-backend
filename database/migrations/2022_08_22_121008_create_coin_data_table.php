<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_data', function (Blueprint $table) {
            $table->id();
            $table->string('coin_id',100);
            $table->string('symbol',100)->unique();
            $table->text('image')->nullable();
            $table->double('current_price')->nullable();
            $table->double('market_cap')->nullable();
            $table->integer('market_cap_rank')->nullable();
            $table->double('fully_diluted_valuation')->nullable();
            $table->bigInteger('total_volume')->nullable();
            $table->double('high_24h')->nullable();
            $table->double('low_24h')->nullable();
            $table->double('price_change_24h')->nullable();
            $table->double('price_change_percentage_24h')->nullable();
            $table->double('market_cap_change_24h')->nullable();
            $table->double('market_cap_change_percentage_24h')->nullable();
            $table->double('circulating_supply')->nullable();
            $table->double('total_supply')->nullable();
            $table->double('max_supply')->nullable();
            $table->double('ath')->nullable();
            $table->text('ath_change_percentage')->nullable();
            $table->dateTime('ath_date')->nullable();
            $table->double('atl')->nullable();
            $table->text('atl_change_percentage')->nullable();
            $table->dateTime('atl_date')->nullable();
            $table->float('roi_times',8,2)->nullable();
            $table->text('roi_currency')->nullable();
            $table->double('roi_percentage')->nullable();
            $table->double('price_change_percentage_14d_in_currency')->nullable();
            $table->double('price_change_percentage_1h_in_currency')->nullable();
            $table->double('price_change_percentage_1y_in_currency')->nullable();
            $table->double('price_change_percentage_200d_in_currency')->nullable();
            $table->double('price_change_percentage_24h_in_currency')->nullable();
            $table->double('price_change_percentage_30d_in_currency')->nullable();
            $table->double('price_change_percentage_7d_in_currency')->nullable();
            $table->text('sparkline_in_7d')->nullable();
            $table->decimal('trading_volume', 40,15)->nullable();
            $table->text('description')->nullable();
            $table->text('platform')->nullable();
            $table->bigInteger('twitter_followers')->nullable();
            $table->bigInteger('telegram_members')->nullable();
            $table->bigInteger('medium_followers')->nullable();
            $table->text('token_sale_price')->nullable();
            $table->text('token_sale_type')->nullable();
            $table->string('round_sale')->nullable();
            $table->double('round_price')->nullable();
            $table->double('total_supply_percent', 15, 2)->nullable();
            $table->double('seed_price')->nullable();
            $table->double('roi_seed')->nullable();
            $table->double('total_locked')->nullable();
            $table->double('total_locked_percent')->nullable();
            $table->double('next_unlock_percent')->nullable();
            $table->dateTime('next_unlock_date')->nullable();
            $table->text('next_unlock_date_text')->nullable();
            $table->double('next_unlock_number_of_tokens')->nullable();
            $table->double('next_unlock_percent_of_tokens')->nullable();
            $table->text('next_unlock_size')->nullable();
            $table->dateTime('first_vc_unlock')->nullable();
            $table->dateTime('end_vc_unlock')->nullable();
            $table->text('first_vc_unlock_text')->nullable();
            $table->text('end_vc_unlock_text')->nullable();
            $table->double('three_months_unlock_number_of_tokens')->nullable();
            $table->double('three_months_unlock_percent_of_tokens')->nullable();
            $table->text('three_months_unlock_size')->nullable();
            $table->double('six_months_unlock_number_of_tokens')->nullable();
            $table->double('six_months_unlock_percent_of_tokens')->nullable();
            $table->text('six_months_unlock_size')->nullable();
            $table->integer('social_mentions')->unsigned()->nullable()->default(0);
            $table->integer('social_engagement')->unsigned()->nullable()->default(0);
            $table->float('average_sentiment')->unsigned()->nullable()->default(0);
            $table->json('historical_sentiment');
            // $table->text('next_unlock_status')->nullable();
            $table->json('historical_social_mentions');
            $table->json('historical_social_engagement');
            $table->float('average_sentiment_change')->signed()->nullable()->default(0);
            $table->float('social_mentions_change')->signed()->nullable()->default(0);
            $table->float('social_engagement_change')->signed()->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coin_data');
    }
};
