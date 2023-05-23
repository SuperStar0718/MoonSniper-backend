<template>
    <div>
      <b-row class="w-100 m-auto">
        <b-col v-for="(item, index) in tempData" :key="index" cols="6" md="3" class="border-col">
          <h3 class="text-center font-weight-bold market-value" :class="{ 'text-success': (item.compare===true), 'text-danger': (item.compare===false) }">
            <span v-if="item.compare !== 'icon'">{{ item.value }}</span> <!-- Render item.value if item.compare is not equal to 'icon' -->
            <a v-else-if="item.compare === 'icon'" :href="item.url" target="_blank" class="d-block">
                <b-img rounded :src="item.imageSrc" class="w-50 mx-auto hover-image" alt="Icon" fluid style="max-width: 50px;"/> 
            </a>          
        </h3>
          <h6 class="text-center market-caption">
            <span v-if="item.compare !== 'icon'">{{ item.caption }}</span> 
            <span v-if="(item.compare === 'icon' && item.value != 0)">{{ item.value }}</span>
            <span v-if="(item.compare === 'icon' && item.value == 0)">{{ item.text }}</span> 
          </h6>
        </b-col>
      </b-row>
    </div>
</template>

<style>
.border-col {
    border: 1px solid #45e0ff;
}

.market-value {
    margin-bottom: 0.2rem;
    margin-top: 0.5rem;
}

.market-caption {
    font-size: 0.8rem;
}
.text-success {
    color: rgb(132 204 22);
}
.text-danger{
    color: rgb(220 38 38);
}
.hover-image:hover{
    filter: brightness(0.8);
}
</style>

<script>
import { BRow, BCol, BImg } from "bootstrap-vue";

export default {
    components: {
        BRow,
        BCol,
        BImg,
    },
    props: {
        token: Object,
    },
    methods:{
        toInterNationalNumber(val) {
            if (val)
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 15,
                }).format(val);
        },
        roundData(val) {
            if (val) {
                return this.toInterNationalNumber(parseFloat(val).toFixed(2));
            }
            return 0;
        },
        nFormatter(num) {
            if (Math.abs(num) > 999999999) {
                return Math.sign(num)*((Math.abs(num)/1000000000).toFixed(1)) + 'B';
            } else if (Math.abs(num) > 999999) {
                return Math.sign(num)*((Math.abs(num)/1000000).toFixed(1)) + 'M';
            } else if (Math.abs(num) > 999) {
                return Math.sign(num)*((Math.abs(num)/1000).toFixed(1)) + 'K';
            } else {
                return Math.sign(num)*Math.abs(num);
            }
        },
        xfromlunch(val, val2) {
            if (val2 == 'roi_times') {

                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 15,
                }).format(val.toFixed(2));
            } else {
                var calculated_roi_x = val / val2;
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 15,
                }).format(calculated_roi_x.toFixed(2));
            }
        },
        volumePerCentage(data) {
            if (data) {
                var str_array = data.split(',');
                if (str_array.length > 1) {
                    let per = (str_array[0] - str_array[1]) / str_array[0];
                    return this.twenty4HConversation(per);
                }

            }
        },
        compareVolume(data){
            if (data) {
                var str_array = data.split(',');
                if (str_array.length > 1) {
                    return (str_array[0] - str_array[1]) > 0 
                }
            }
            return true;
        },
        twenty4HConversation(value) {
            let checkval = 0;
            if (value != null) {
                if (value >= 0) {
                    for (let index = 1; index < 10; index++) {
                        if (0 >= checkval) {
                            checkval = parseFloat(value).toFixed(index);
                        } else {
                            break;
                        }
                    }
                } else {
                    for (let index = 1; index < 10; index++) {
                        if (0 <= checkval) {
                            checkval = parseFloat(value).toFixed(index);
                        } else {
                            break;
                        }
                    }
                }
                if (checkval == 0) {
                    return 0;
                }
                return new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 15,
                }).format(checkval);
            }

        },
        getYearMonth(val){
            if(val){
                const date = new Date(val);
                const year = date.getFullYear();
                const month = date.toLocaleString('default', { month: 'long' });

                const formattedDate = year + ' ' + month;

                return formattedDate
            }

            return ""
        },
    },
    data() {
        return {
            tempData: [
                {
                    value:  this.getYearMonth(this.token?.public_date),
                    caption: "Date created",
                },
                {
                    value: `${this.roundData(this.token?.current_price)}$`,
                    caption: "Current price",
                },
                {
                    value: this.nFormatter(this.token?.market_cap),
                    caption: "Market cap",
                },
                {
                    value: `${this.token?.market_cap_rank}#`,
                    caption: "Market rank",
                },
                {
                    value: this.nFormatter(this.token?.circulating_supply),
                    caption: "Circulating Supply",
                },
                {
                    value: `${this.token?.total_supply_percent}%` ?? "",
                    caption: "% in circulation",
                },
                {
                    value: this.nFormatter(this.token?.total_volume ?? 0),
                    caption: "Daily Volume",
                },
                {
                    value: `${this.volumePerCentage(this.token?.volume_history)}%`,
                    caption: "Daily Volume Change %",
                    compare: this.compareVolume(this.token?.volume_history)
                },
                {
                    value: `$${this.roundData(this.token?.ath ?? 0)}`,
                    caption: "All time high",
                },
                {
                    value: `${this.roundData(this.token?.ath_change_percentage ?? 0)}%`,
                    caption: "% from ATH 60%",
                    compare: this.token?.ath_change_percentage >= 0,
                },
                {
                    value: `$${this.roundData(this.token?.atl ?? 0)}`,
                    caption: "All time low",
                },
                {
                    value: `${this.roundData(this.token?.atl_change_percentage ?? 0)}%`,
                    caption: "% from ATL 60%",
                    compare: this.token?.atl_change_percentage >= 0,
                },
                {
                    value: `${this.token?.inflation}%`,
                    caption: "INFLATION",
                    compare: this.token?.inflation >= 0,
                },
                {
                    value: "-",
                    caption: "Holders",
                },
                {
                    value: "-",
                    caption: "Holders 24h % change",
                },
                {
                    value: "-",
                    caption: "Holders 7 day % change",
                },
                {
                    value: this.token?.next_unlock_date_text ?? "",
                    caption: "Next unlock date",
                },
                {
                    value: `${this.roundData(this.token?.social_mentions_change)}%`,
                    caption: "24H Social mentions %",
                    compare: this.token.social_mentions_change >= 0,
                },
                {
                    value: `${this.roundData(this.token?.social_engagement_change)}%`,
                    caption: "24H Social engamgents %",
                    compare: this.token?.social_engagement_change >= 0,
                },
                {
                    value: `${this.roundData(this.token?.average_sentiment)}%`,
                    caption: "24H Social sentiments %",
                    compare: this.token?.average_sentiment >= 0,
                },
                {
                    value: `${this.xfromlunch(this.token?.roi_times??0,'roi_times')}X`,
                    caption: "Xs from Public price",
                },
                {
                    value: `${this.roundData(this.token?.public_price)}$`,
                    caption: "Public price",
                },
                {
                    value: "-",
                    caption: "x to  no 1 in category",
                },
                {
                    value: `${this.roundData(this.token?.market_cap / this.token?.total_volume)}%`,
                    caption: "Market cap/daily volume %",
                },
                {
                    value: this.nFormatter(this.token?.Website ?? 0),
                    caption: "Website",
                    compare: "icon",
                    imageSrc: `/images/static/website.png`,
                    url: this.token.Website ?? '#',
                    text: "Website"
                },
                {
                    value: this.nFormatter(this.token?.twitter_followers) ?? "",
                    caption: "Twitter Followers",
                    compare: "icon",
                    imageSrc: `/images/static/twitter.png`,
                    url: this.token.twitter ?? '#',
                    text: "Twitter"
                },
                {
                    value: this.nFormatter(this.token?.telegram_members) ?? "",
                    caption: "TG Followers",
                    compare: "icon",
                    imageSrc: `/images/static/telegram.png`,
                    url: this.token.telegram ?? '#',
                    text: "Telegram"
                },
                {
                    value: this.nFormatter(this.token?.whitepaper_followers??0) ,
                    caption: "White papar",
                    compare: "icon",
                    imageSrc: `/images/static/whitepaper.png`,
                    url: this.token.whitepaper ?? '#',
                    text: "White paper"
                },
            ],
        };
    },
};
</script>