<template>
    <div>
        <b-card no-body>
            <b-card-body>
              <div class="mx-auto" style="margin-top:-30px !important">
                <b-row class="mt-3 mb-1">
                    <b-col md="6" xl="4">
                        <div class="d-flex mx-auto ">
                            <h5 class="text-secondary" style="margin-right:8px;">MC:</h5>
                            <h5 v-if="loaded">{{fag.data.market_cap}}</h5>
                            <!-- <div class="d-flex text-success">
                                <feather-icon icon="CloudIcon" size="12" class="align-middle"
                                    style="margin:2px 6px 0 10px" /><span style="font-size:12px;">4.4%</span>
                            </div> -->
                        </div>

                    </b-col>
                    <b-col md="6" xl="4" class="mb-1">
                        <div class="d-flex mx-auto justify-content-center">
                            <h5 class="text-secondary" style="margin-right:8px;">VOL(24):</h5>
                            <h5 v-if="loaded"> {{fag.data.vol_24h}}</h5>
                            <!-- <div class="d-flex text-success">
                                <feather-icon icon="CloudIcon" size="12" class="align-middle"
                                    style="margin:2px 6px 0 10px" /><span style="font-size:12px;">4.4%</span>
                            </div> -->
                        </div>

                    </b-col>
                    <b-col md="6" xl="4" class="mb-1">
                        <div class="d-flex mx-auto justify-content-end">
                            <h5 class="text-secondary" style="margin-right:8px;">Dominance:</h5>
                            <div class="d-flex justify-content-between" v-if="loaded">
                                <h5 style="margin:0 8px 0 8px"> {{fag.data.btc_dom}}</h5>
                                <h5 style="margin:0 8px 0 8px">{{fag.data.eth_dom}}</h5>
                            </div>

                        </div>

                    </b-col>

                </b-row>
              </div>
                <b-row class="">
                    <b-col md="6" xl="3">
                        <div class="mx-auto w-75 text-center">
                            <h5 class="w-75">Fear and Greed</h5>
                            <VueSvgGauge  width="60%" class="w-75" :start-angle="-110" :end-angle="110" :value="fag.data.fear_greed_index"
                                :separator-step="5" :min="0" :max="100"
                                :gauge-color="[{ offset: 0, color: '#f55442'}, { offset: 100, color: '#0bd63a'}]"
                                :scale-interval="0.1">
                                <div class="inner-text">
                                    <div class="mt-2"
                                        :class="{'text-danger':fag.data.fear_greed_index<50,'text-success':fag.data.fear_greed_index>=50}">
                                        <span class="d-block"
                                            style="font-size:12px">{{fag.data.fear_greed_index}}</span>
                                        <span class="d-block"
                                            style="font-size:12px">{{fag.data.fear_greed_classification}}</span>
                                        <span class="d-block text-info " style="font-size:10px"><a
                                                v-ripple.400="'rgba(113, 102, 240, 0.15)'" v-b-modal.modal-chart
                                                variant="outline-primary">View
                                                History</a></span>
                                    </div>
                                </div>
                            </VueSvgGauge>
                        </div>
                    </b-col>
                    <b-col md="6" xl="3">
                        <div class="mx-auto w-75 text-center">
                            <!-- <h5>Indicator</h5> -->
                        </div>
                    </b-col>
                    <b-col md="6" xl="3">
                        <div class="mx-auto w-75 text-center">
                            <!-- <h5>Indicator</h5> -->
                        </div>
                    </b-col>
                    <b-col md="6" xl="3">
                        <div class="mx-auto w-75 text-center">
                            <!-- <h5>Indicator</h5> -->
                        </div>
                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
        <b-card>
            <b-card-body>

            </b-card-body>
        </b-card>
        <b-table sticky-header :no-border-collapse="true" style="white-space: nowrap;" responsive :items="items.data"
            :fields="fields">

            <template #head()="scope">
                <div class="text-nowrap cursor-pointer text-center " style="font-size:11px !important;"
                    @click="SortingCols(scope.field.key)">
                    <div class="d-flex">
                        <span> {{ scope.label }} </span> <span class="mx-auto text-center">
                            <feather-icon icon="ChevronUpIcon" size="8" class="align-middle d-block"
                                :class="{'text-danger':params.sort[1] =='asc'&& params.sort[0] ==scope.field.key}" />
                            <feather-icon icon="ChevronDownIcon" size="8"
                                :class="{'text-danger':params.sort[1] =='desc'&& params.sort[0] ==scope.field.key}"
                                class="align-middle d-block" /> </span>
                    </div>
                </div>
            </template>
            <template #cell(coin_platform)="data">
                <div class="" v-html="getPlatformTags(data.value)"></div>
            </template>

            <template #cell(name)="data">
                <div style="text-align: center;">
                    <b-avatar class=" text-center" :src="data.item.image" />

                    <div class="text-nowrap text-truncate" style="max-width: 100px; font-size:11px">{{ data.value }}
                    </div>
                </div>
            </template>
            <template #cell(current_price)="data">
                <div class="" style=" font-size:11px">{{data.value}}$</div>
            </template>
            <template #cell(market_cap)="data">
                <div v-if="data.value !=''" class="" style=" font-size:11px">{{data.value}}$</div>
            </template>
            <template #cell(high_24h)="data">
                <div v-if="data.value !=''" class="" style=" font-size:11px">{{data.value}}$</div>
            </template>
            <template #cell(low_24h)="data">
                <div v-if="data.value !=''" class="" style=" font-size:11px">{{data.value}}$</div>
            </template>

            <template #cell(price_change_percentage_24h)="data">
                <div v-if="data.value">
                    <span v-if="data.value>= 0" class="text-success" style="font-size:11px">{{ data.value }} %</span>
                    <span v-else class="text-danger" style="font-size:11px">{{ data.value }} %</span></div>
            </template>
            <template #cell(roi_percentage)="data">
                <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                        @click="SortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }} %</span>
                    <span v-else-if="data.value!=null" class="text-danger"
                        style="font-size:11px">{{ roundData(data.value) }} %</span></div>
            </template>
            <template #cell(ath)="data">
                <div v-if="data.value">
                    <span style="font-size:11px">{{data.value}}$</span>
                </div>
            </template>
            <template #cell(atl)="data">
                <div v-if="data.value">
                    <span style="font-size:11px">{{data.value}}$</span>
                </div>
            </template>
            <template #cell(social_mentions_change)="data">
                <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                        @click="SortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }} %</span>
                    <span v-else-if="data.value!=null" class="text-danger"
                        style="font-size:11px">{{ roundData(data.value) }} %</span></div>
            </template>
            <template #cell(social_engagement_change)="data">
                <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                        @click="SortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }} %</span>
                    <span v-else-if="data.value!=null" class="text-danger"
                        style="font-size:11px">{{ roundData(data.value) }} %</span></div>
            </template>
            <template #cell(average_sentiment_change)="data">
                <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                        @click="SortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }} %</span>
                    <span v-else-if="data.value!=null" class="text-danger"
                        style="font-size:11px">{{ roundData(data.value) }} %</span></div>
            </template>
            <template #cell()="data">
                <div class="text-center" style="font-size:11px">
                    <span class="text-nowrap">{{ data.value }}</span>
                </div>
            </template>
        </b-table>
        <div class="mx-2 mb-2">
            <b-row>

                <b-col cols="12" sm="6"
                    class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    <span class="text-muted">Showing {{ items.from }} to {{ items.to }} of {{ items.of }}
                        entries</span>
                </b-col>
                <!-- Pagination -->
                <b-col cols="12" sm="6" class="d-flex align-items-center justify-content-center justify-content-sm-end">

                    <b-pagination v-model="Cpagpage" :total-rows="items.total" :per-page="items.per_page" first-number
                        last-number class="mb-0 mt-1 mt-sm-0" prev-class="prev-item" next-class="next-item">
                        <template #prev-text>
                            <feather-icon icon="ChevronLeftIcon" size="18" />
                        </template>
                        <template #next-text>
                            <feather-icon icon="ChevronRightIcon" size="18" />
                        </template>
                    </b-pagination>

                </b-col>

            </b-row>
        </div>
        <b-modal id="modal-chart" ok-only ok-title="Close" centered size="lg" title="Fear Greed Index History">
            <vue-apex-charts  class="full" width="100%"    :dataLabels="true"  type="line" :options="chartOptions" :series="series"></vue-apex-charts>
        </b-modal>
    </div>
</template>

<script>
    import {
        BTable,
        BFormCheckbox,
        BAvatar,
        BBadge,
        BPagination,
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        BModal,
        VBModal,
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import axios from '@axios'
    import {
        VueSvgGauge
    } from 'vue-svg-gauge'
    import VueApexCharts from 'vue-apexcharts'
    export default {
        components: {
            BTable,
            BFormCheckbox,
            BAvatar,
            BBadge,
            BPagination,
            BCard,
            BCardHeader,
            BCardBody,
            BRow,
            BCol,
            VueSvgGauge,
            BModal,
            VueApexCharts,
        },
        data() {
            return {
                stickyHeader: true,
                true: false,
                loaded: false,
                fields: [{
                        key: 'market_cap_rank',
                        label: '#',
                        stickyColumn: true,
                        sortable: false,
                    },
                    {
                        key: 'name',
                        thStyle: {
                            width: '100px !important'
                        },
                        tdStyle: {
                            width: '100px !important'
                        },
                        thClass: 'nameWidth',
                        label: 'Coin',
                        stickyColumn: true,
                    },
                    {
                        key: 'current_price',
                        label: 'Price($)',
                        stickyColumn: true,
                    },
                    {
                        key: 'market_cap',
                        label: 'Market Cap.($)',
                        stickyColumn: true,
                    },
                    {
                        key: 'description',
                        label: 'Description',
                        stickyColumn: true,
                    },

                    {
                        key: 'coin_platform',
                        label: 'Platform',
                        stickyColumn: true,
                    },
                    {
                        key: 'total_volume',
                        label: 'Trading VOL.',
                        stickyColumn: true,
                    },
                    {
                        key: 'high_24h',
                        label: 'High $ (24h)',
                        stickyColumn: true,
                    },
                    {
                        key: 'low_24h',
                        label: 'Low $ (24h)',
                        stickyColumn: true,
                    },
                    {
                        key: 'price_change_percentage_24h',
                        label: 'Price Change % (24h)',
                        stickyColumn: true,
                    },
                    {
                        key: 'ath',
                        label: 'ATH($)',
                        stickyColumn: true,
                    },
                    {
                        key: 'atl',
                        label: 'ATL($)',
                        stickyColumn: true,
                    },
                    {
                        key: 'roi_times',
                        label: `ROI in X's`,
                        stickyColumn: true,
                    },
                    {
                        key: 'roi_percentage',
                        label: 'ROI %',
                        stickyColumn: true,
                    },
                    {
                        key: 'total_supply_percent',
                        label: 'Total Supply %',
                        stickyColumn: true,
                    },
                    {
                        key: 'next_unlock_date',
                        label: 'Next Unlock Date',
                        stickyColumn: true,
                    },
                    {
                        key: 'next_unlock_status',
                        label: 'Next Unlock Status',
                        stickyColumn: true,
                    },
                    {
                        key: 'social_mentions_change',
                        label: 'Social Mentions Change',
                        stickyColumn: true,
                    },
                    {
                        key: 'social_engagement_change',
                        label: 'Social Engagement Change',
                        stickyColumn: true,
                    },
                    {
                        key: 'average_sentiment',
                        label: 'Average Sentiment',
                        stickyColumn: true,
                    },
                    {
                        key: 'average_sentiment_change',
                        label: 'Average Sentiment Change',
                        stickyColumn: true,
                    },
                ],
                items: [],
                Cpagpage: 1,
                sortKey: '',
                sortBy: '',
                params: {
                    filters: [],
                    "filters2": "",
                    sort: ["", ""]
                },
                fag: {
                    data: {
                        fear_greed_index: 0,
                        fear_greed_classification: ''
                    }
                },
                chartOptions: {
                    chart: {
                        id: 'history-chart'
                    },
                    xaxis: {
                        categories: []
                    },
                    colors:['#fca503'],
                    
                },
                series: [{
                    name: 'Fear Greed Index',
                    data: []
                }]
            }

        },
        directives: {
            'b-modal': VBModal,
            Ripple,
        },
        methods: {
            loadCoins() {
                axios.post('api/get_coins?page=' + this.Cpagpage, JSON.stringify(this.params)).then(res => {
                    this.items = res.data;
                })
            },
            loadFag() {
                axios.post('api/get_fag').then(res => {
                    this.fag = res;
                    this.loaded = true;
                    this.fag.data.fear_greed_history = JSON.parse(this.fag.data.fear_greed_history);
                    let array = [];
                    this.fag.data.fear_greed_history.forEach(element => {
                        var d = new Date(parseInt(element.timestamp)*1000);
                         let date =  d.getDate() + '/' + (d.getMonth()+1) + '/' + d.getFullYear();
                        array.unshift(date);
                        this.chartOptions.xaxis.categories = array;
                         this.series[0].data.unshift(parseInt(element.value))
                         
                   });
                  


                })
            },
            getPlatformTags(val) {
                var tags = "";
                const tagsArray = val.split("|");
                var index = 0;
                for (index = 0; index <= 1; index++) {
                    if (tagsArray[index] != undefined && tagsArray[index] != "")
                        tags = tags +
                        ' <div class="d-block " style="margin-bottom:1px;"><span class="bg-success text-white customBadge">' +
                        tagsArray[index] + '</span></div>';
                }
                if (tagsArray.length > 2) {
                    tags = tags + '<span class="text-center">see more...</span>'
                }
                return tags;
            },
            roundData(val) {
                if (val) {
                    return parseFloat(val).toFixed(2);
                }
            },
            SortingCols(val) {
                this.Cpagpage = 1;
                if (this.params.sort[0] == val) {
                    if (this.params.sort[1] == 'asc') {
                        this.params.sort[1] = 'desc'
                    } else {
                        this.params.sort[1] = 'asc'
                    }
                } else {
                    this.params.sort[1] = 'asc';
                    this.params.sort[0] = val
                }



                this.loadCoins();
            }

        },
        mounted() {
            this.loadCoins();
            this.loadFag();
        },
        watch: {
            'Cpagpage': function (newVal, oldVal) {
                var vueComponent = this
                if (oldVal && newVal) {
                    this.loadCoins()
                }
            }
        }
    }

</script>
<style>
    .nameWidth {
        width: 55px !important;
    }
    .full { width: 100% }
    .customBadge {
        font-size: 11px;
        padding: 2px;
        border-radius: 5px;
    }

    .b-table-sticky-header {
        overflow-y: auto;
        max-height: 80vh;
    }

    td {
        text-align: center;
    }

    .inner-text {
        height: 100%;
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

</style>
