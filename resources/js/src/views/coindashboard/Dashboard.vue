<template>
    <div>
        <b-card no-body>
            <b-overlay :show="fagLoad" rounded="sm">
                <b-card-body>
                    <div class="mx-auto" style="margin-top:-30px !important">
                        <b-row class="mt-3 mb-1">
                            <b-col md="6" xl="4">
                                <div class="d-flex mx-auto justify-content-center">
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
                                <div class="d-flex mx-auto justify-content-center">
                                    <h5 class="text-secondary" style="margin-right:8px;">Dominance:</h5>
                                    <div class="d-flex justify-content-between" v-if="loaded">
                                        <h5 style="margin:0 8px 0 8px"> {{fag.data.btc_dom}}
                                        </h5>
                                        <h5 style="margin:0 8px 0 8px" >{{fag.data.eth_dom}}</h5>
                                    </div>

                                </div>

                            </b-col>

                        </b-row>
                    </div>
                    <b-row class="">
                        <b-col md="6" xl="3">
                            <div class="mx-auto w-75 text-center">
                                <h5 class="w-75 mx-auto">Fear and Greed</h5>
                                <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-110" :end-angle="110"
                                    :value="fag.data.fear_greed_index" :separator-step="5" :min="0" :max="100"
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
            </b-overlay>
        </b-card>
        <div class="body-content-overlay" />
        <div class="searchbar mt-1 mb-1">
            <b-row>
                <b-col cols="8" md="8" xl="11">
                    <b-input-group class="input-group-merge">
                        <b-form-input v-model="params.filters2" placeholder="Search Product" class="search-product" />
                        <b-input-group-append is-text>
                            <feather-icon icon="SearchIcon" class="text-muted" />
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
                <b-col cols="4" md="4" xl="1">
                    <div class="d-flex jusctify-content-between">
                        <div v-b-modal.modal-filters variant="outline-primary">
                            <feather-icon icon="FilterIcon" size="28" class="text-black cursor-pointer"
                                style="margin:6px 8px 6px 0px; " />
                        </div>
                        <div @click="clearFilters">
                            <feather-icon icon="RefreshCcwIcon" size="28" class="text-black cursor-pointer"
                                style="margin:6px 0px 6px 8px" />
                        </div>
                    </div>
                </b-col>
            </b-row>
        </div>
        <div class="body-content-overlay" />
        <div id="">
            <b-overlay :show="isBusy" rounded="sm">
                <b-table sticky-header :no-border-collapse="true" tbody-tr-class="cursor-pointer" show-empty
                    @row-clicked="detailsModel($event)" style="white-space: nowrap;" responsive :items="items.data"
                    :fields="fields">
                    <template #empty="scope">
                        <h4>{{ scope.emptyText }}</h4>
                    </template>

                    <template #head()="scope">
                        <div class="text-nowrap cursor-pointer text-center " style="font-size:11px !important;"
                            @click="sortingCols(scope.field.key)">
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

                            <div class="text-nowrap text-truncate" style="max-width: 100px; font-size:11px">
                                {{ data.value }}
                            </div>
                        </div>
                    </template>
                    <template #cell(current_price)="data">
                        <div class="" style=" font-size:11px">{{data.value}}$</div>
                    </template>
                    <template #cell(market_cap)="data">
                        <div class="" style=" font-size:11px">{{data.value?data.value:0}}$</div>
                    </template>
                    <template #cell(high_24h)="data">
                        <div v-if="data.value !=''" class="" style=" font-size:11px">{{data.value}}$</div>
                    </template>
                    <template #cell(low_24h)="data">
                        <div v-if="data.value !=''" class="" style=" font-size:11px">{{data.value}}$</div>
                    </template>

                    <template #cell(price_change_percentage_24h)="data">
                        <div v-if="data.value">
                            <span v-if="data.value>= 0" class="text-success" style="font-size:11px">{{ data.value }}
                                %</span>
                            <span v-else class="text-danger" style="font-size:11px">{{ data.value }} %</span></div>
                    </template>
                    <template #cell(roi_percentage)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger"
                                style="font-size:11px">{{ roundData(data.value) }} %</span></div>
                    </template>
                    <template #cell(total_supply_percent)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }}
                                %</span>
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
                                @click="sortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger"
                                style="font-size:11px">{{ roundData(data.value) }} %</span></div>
                    </template>
                    <template #cell(social_engagement_change)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger"
                                style="font-size:11px">{{ roundData(data.value) }} %</span></div>
                    </template>
                    <template #cell(average_sentiment_change)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="font-size:11px">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger"
                                style="font-size:11px">{{ roundData(data.value) }} %</span></div>
                    </template>
                    <template #cell()="data">
                        <div class="text-center" style="font-size:11px">
                            <span class="text-nowrap">{{ data.value }}</span>
                        </div>
                    </template>
                </b-table>
            </b-overlay>

        </div>
        <div class="mx-2 mb-2">
            <b-row>

                <b-col cols="12" sm="6"
                    class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    <span class="text-muted">Showing {{ items.from }} to {{ items.to }} of {{ items.total }}
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
            <vue-apex-charts class="full" width="100%" :dataLabels="true" type="line" :options="chartOptions"
                :series="series"></vue-apex-charts>
        </b-modal>
        <b-modal id="modal-filters" :hide-footer="true" size="xl" title="Filters">

            <template>
                <div class="accordion" role="tablist">
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.baseFilters variant="info">Base Filters</b-button>
                        </b-card-header>
                        <b-collapse id="baseFilters" visible accordion="filterAccordion" role="tabpanel">
                            <b-card-body>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Market Cap" label-for="market_cap">
                                                <div class="d-flex">
                                                    <b-form-input v-numeric-only v-model="filterKey.mc_min"
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-numeric-only v-model="filterKey.mc_max"
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Daily Price Change (%)"
                                                label-for="price_change_percentage_24h">
                                                <div class="d-flex">
                                                    <b-form-input name="price_change_percentage_24h" v-numeric-only
                                                        v-model="filterKey.day_min_change" placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.day_max_change" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Platform" label-for="">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.platform"
                                                        :options="platforms" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Token Price">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_token_price" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_token_price" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Circulating Supply">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_circulating_supply"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_circulating_supply"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Category" label-for="">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.category"
                                                        :options="categories" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Market Cap. Rank">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_market_cap_rank" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_market_cap_rank" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Total Supply">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_total_supply" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_total_supply" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Keywords" label-for="">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.keywords"
                                                        placeholder="key words" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Trade Volume">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_trade_volume" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_trade_volume" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="ROI %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_roi_per" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_roi_per" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="ROI in X's">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_times_roi" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_times_roi" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>

                                </b-row>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Days in Market">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_days_in_market" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_days_in_market" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Total Supply (%)">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_total_supply_per"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_total_supply_per"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Seed Price">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_seed_price" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_seed_price" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Seed ROI">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_seed_roi" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_seed_roi" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>

                                </b-row>
                            </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.socialSentiments variant="info">Social Sentiments</b-button>
                        </b-card-header>
                        <b-collapse id="socialSentiments" accordion="filterAccordion" role="tabpanel">
                            <b-card-body>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Sentiment Change %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_social_sentiment"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_social_sentiment"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Social Mentions Change %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_social_mentions_change"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_social_mentions_change"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Social Engagement Change %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_social_engagement_change"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_social_engagement_change"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Average Sentiment (1-5)">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_average_sentiment_1_5"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_average_sentiment_1_5"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>

                                </b-row>
                            </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.unlocking variant="info">Unlocking</b-button>
                        </b-card-header>
                        <b-collapse id="unlocking" accordion="filterAccordion" role="tabpanel">
                            <b-card-body>
                                <b-row>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Total Locked">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_total_locked" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_total_locked" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Unlock Status">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.next_unlock_status"
                                                        :options="unlockStatusCoins" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Next Unlock # of Tokens">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_next_unlock_n_tokens"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_next_unlock_n_tokens"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Next Unlock %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_next_unlock_per" v-numeric-only
                                                        placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_next_unlock_per" v-numeric-only
                                                        placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="Next Unlock Size">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.next_unlock_size"
                                                        :options="nextUnlockSize" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="3 Months Unlock # of Tokens">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_3_months_unlock_n_tokens"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_3_months_unlock_n_tokens"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="3 Months Unlock %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_3_months_unlock_per"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_3_months_unlock_per"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="3 Months Unlock Size">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.three_months_unlock_size"
                                                        :options="nextUnlockSize" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="6 Months Unlock # of Tokens">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_6_months_unlock_n_tokens"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_6_months_unlock_n_tokens"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="6 Months Unlock %">
                                                <div class="d-flex">
                                                    <b-form-input v-model="filterKey.min_6_months_unlock_per"
                                                        v-numeric-only placeholder="min" />
                                                    <span>
                                                        <feather-icon icon="ArrowRightIcon" size="16"
                                                            class="align-middle" style="margin:10px 6px 0 0px" /></span>
                                                    <b-form-input v-model="filterKey.max_6_months_unlock_per"
                                                        v-numeric-only placeholder="max" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="4">
                                        <div class="">
                                            <b-form-group label="6 Months Unlock Size">
                                                <div class="d-flex">
                                                    <b-form-select id="" v-model="filterKey.six_months_unlock_size"
                                                        :options="nextUnlockSize" />
                                                </div>
                                            </b-form-group>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>
            </template>
            <div class="float-right">
                <b-button @click="clearFilters">Clear all</b-button>
                <b-button @click="filterCoins">Apply filters</b-button>
            </div>
        </b-modal>
        <b-modal id="modal-details" v-if="activeData" ok-only ok-title="Close" centered size="lg"
            :title="activeData.name +' - '+activeData.symbol">
            <template>
                <div class="accordion" role="tablist">
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.marketData variant="info">Market Data</b-button>
                        </b-card-header>
                        <b-collapse id="marketData" visible accordion="detailsModel" role="tabpanel">
                            <b-card-body>
                                <b-row>
                                    <b-col md="6" xl="6" class="text-center">
                                        <h5>{{ activeData.name }} Price</h5>
                                        <div class="d-flex justify-content-center" style="font-size:12px">
                                            <span>${{ activeData.current_price }}</span> &nbsp;<span
                                                :class="{'text-success':activeData.price_change_percentage_24h>=0,'text-danger':activeData.price_change_percentage_24h<=0}">{{ activeData.price_change_percentage_24h }}
                                                %</span></div>
                                    </b-col>
                                    <b-col md="6" xl="6" class="text-center">
                                        <h5>{{ activeData.name }} Market Cap</h5>
                                        <div class="d-flex justify-content-center" style="font-size:12px">
                                            <span>${{ activeData.market_cap }}</span> </div>
                                    </b-col>
                                </b-row>
                                <b-row class="" style="max-height:120px">
                                    <b-col cols="12" class="text-center">
                                        <h5>{{ activeData.name }} Market Cap</h5>
                                        <trend :data="activeData.sparkline_in_7d" :gradient="['#d40808']" auto-draw
                                            smooth></trend>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.soicalData variant="info">Social Data</b-button>
                        </b-card-header>
                        <b-collapse id="soicalData" accordion="detailsModel" role="tabpanel">
                            <b-card-body>
                                <b-row class="text-center mt-1 mb-1">
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2 justify-content-center">
                                            <span class="mr-1">Social Mentions: </span>
                                            <span class="text-success" v-if="activeData.social_mentions>=0">
                                                +{{activeData.social_mentions}} %</span>
                                            <span class="text-danger" v-else> -{{activeData.social_mentions}} %</span>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2  justify-content-center">
                                            <span class="mr-1">Average Sentiment: </span>
                                            <span>{{activeData.average_sentiment}}</span>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2 justify-content-center">
                                            <span class="mr-1"> Social Engagement: </span>
                                            <span class="text-success" v-if="activeData.social_engagement>=0">
                                                +{{activeData.social_engagement}} %</span>
                                            <span class="text-danger" v-else> {{activeData.social_engagement}} %</span>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2  justify-content-center">
                                            <span class="mr-1">Historical Sentiment: </span>
                                            <span class="text-success"
                                                v-if="roundData(activeData.average_sentiment_change)>=0">
                                                +{{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                %</span>
                                            <span class="text-danger" v-else>
                                                {{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                %</span>
                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2 justify-content-center">
                                            <span class="mr-1">Social Score: </span>
                                            <span class="">
                                                {{ calculate_social_score(activeData) }}/10</span>

                                        </div>
                                    </b-col>
                                    <b-col md="6" xl="6">
                                        <div class="d-flex m-2 justify-content-center">
                                            <span class="mr-1">Total Supply %: </span>
                                            <span class="">
                                                {{ activeData.total_supply_percent}} %</span>

                                        </div>
                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.website && activeData.website != '' ">
                                        <a :href="activeData.website" target="_blank">
                                            <b-img rounded :src="'/images/static/website.png'" fluid
                                                alt="Responsive image" />
                                        </a>
                                        <div>Website</div>

                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.twitter && activeData.twitter != '' ">
                                        <a :href="activeData.twitter" target="_blank">
                                            <b-img rounded :src="'/images/static/twitter.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Twtter</div>
                                        <span class="text-center"
                                            v-if="activeData.twitter_followers">{{activeData.twitter_followers}}
                                            Follower</span>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.telegram && activeData.telegram != '' ">
                                        <a :href="activeData.telegram" target="_blank">
                                            <b-img rounded :src="'/images/static/telegram.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Telegram</div>
                                        <span class="text-center"
                                            v-if="activeData.telegram_members">{{activeData.telegram_members}}
                                            Follower</span>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.discord && activeData.discord != '' ">
                                        <a :href="activeData.discord" target="_blank">
                                            <b-img rounded :src="'/images/static/discord.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Discard</div>
                                        <span class="text-center"
                                            v-if="activeData.discord_followers">{{activeData.discord_followers}}
                                            Follower</span>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.medium && activeData.medium != '' ">
                                        <a :href="activeData.medium" target="_blank">
                                            <b-img rounded :src="'/images/static/medium.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Medium</div>
                                        <span class="text-center"
                                            v-if="activeData.medium_followers">{{activeData.medium_followers}} Followers
                                        </span>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.reddit && activeData.reddit != '' ">
                                        <a :href="activeData.reddit" target="_blank">
                                            <b-img rounded :src="'/images/static/reddit.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Reddit</div>
                                        <span class="text-center"
                                            v-if="activeData.reddit_followers">Follower{{activeData.reddit_followers}}
                                        </span>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.whitepaper && activeData.whitepaper != '' ">
                                        <a :href="activeData.whitepaper" target="_blank">
                                            <b-img rounded :src="'/images/static/whitepaper.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>White paper</div>
                                    </b-col>
                                    <b-col md="3" class="text-center" xl="2"
                                        v-if="activeData.github && activeData.github != '' ">
                                        <a :href="activeData.github" target="_blank">
                                            <b-img rounded :src="'/images/static/github.png'" fluid
                                                alt="Responsive image" />

                                        </a>
                                        <div>Github</div>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-collapse>
                    </b-card>

                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.unlokcing variant="info">Unlocking Data</b-button>
                        </b-card-header>
                        <b-collapse id="unlokcing" accordion="detailsModel" role="tabpanel">
                            <b-card-body>
                                <b-card-body>
                                    <b-row class="text-center mt-1 mb-1">
                                        <b-col md="6" xl="6">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Date: </span>
                                                <span
                                                    class="text-danger">{{dateFormat(activeData.next_unlock_date)}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Date Text: </span>
                                                <span class="text-danger">{{activeData.next_unlock_date_text}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Percent Of Tokens: </span>
                                                <span class="text-danger">{{activeData.next_unlock_percent_of_tokens}}
                                                    %</span>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="d-flex m-2  justify-content-center">
                                                <span class="mr-1">Next Unlock Number Of Tokens: </span>
                                                <span>{{activeData.next_unlock_number_of_tokens}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Size: </span>
                                                <span class="text-success"> {{activeData.next_unlock_size}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6" v-if="activeData.next_unlock_Status">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Status: </span>
                                                <span class="text-success"> {{activeData.next_unlock_Status}}</span>
                                            </div>
                                        </b-col>

                                    </b-row>

                                </b-card-body>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                    <b-card no-body class="mb-1">
                        <b-card-header header-tag="header" class="p-1" role="tab">
                            <b-button block v-b-toggle.description variant="info">Description</b-button>
                        </b-card-header>
                        <b-collapse id="description" accordion="detailsModel" role="tabpanel">
                            <b-card-body>
                                <b-card-text v-html="activeData.coin_description">
                                </b-card-text>
                            </b-card-body>
                        </b-collapse>
                    </b-card>
                </div>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import {
        BTable,
        BFormCheckbox,
        BAvatar,
        BImg,
        BBadge,
        BPagination,
        BRow,
        BCol,
        BCard,
        BCardHeader,
        BCardBody,
        BModal,
        VBModal,
        BDropdown,
        BDropdownItem,
        BFormRadioGroup,
        BFormRadio,
        BInputGroup,
        BInputGroupAppend,
        BFormInput,
        BButton,
        BFormGroup,
        BCollapse,
        VBToggle,
        BCardText,
        BFormSelect,
        BSpinner,
        BOverlay

    } from 'bootstrap-vue'

    import Ripple from 'vue-ripple-directive'
    import axios from '@axios'
    import {
        VueSvgGauge
    } from 'vue-svg-gauge'
    import VueApexCharts from 'vue-apexcharts'
    import platformData from './platforms'
    import fieldsData from './fields'
    import categoryData from './categories'
    import filterFields from './filterfields'
    import Trend from "vuetrend"

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
            BDropdown,
            BDropdownItem,
            BFormRadioGroup,
            BFormRadio,
            BInputGroup,
            BInputGroupAppend,
            BFormInput,
            BButton,
            BFormGroup,
            BCollapse,
            BCardText,
            BFormSelect,
            Trend,
            BImg,
            BSpinner,
            BOverlay

        },
        data() {
            return {
                stickyHeader: true,
                true: false,
                loaded: false,
                loadedData: false,
                fields: fieldsData,
                items: [],
                pricesWs: null,
                coinsStr: '',
                Cpagpage: 1,
                sortKey: '',
                sortBy: '',
                isBusy: true,
                params: {
                    filters: [],
                    filters2: "",
                    sort: ["market_cap", "desc"]
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
                    colors: ['#fca503'],

                },
                series: [{
                    name: 'Fear Greed Index',
                    data: []
                }],
                searchKey: null,
                filterKey: filterFields,
                platforms: platformData,
                categories: categoryData,
                unlockStatusCoins: [{
                        value: null,
                        text: 'All'
                    },
                    {
                        value: 'red',
                        text: 'Last Week of Unlock'
                    }, {
                        value: 'orange',
                        text: 'Less Than 2 Months & More Than 1 Week'
                    }, {
                        value: 'green',
                        text: 'More Than 2 Months'
                    }
                ],
                nextUnlockSize: [{
                        value: null,
                        text: 'ALL'
                    },
                    {
                        value: 'small',
                        text: 'SMALL'
                    }, {
                        value: 'medium',
                        text: 'MEDIUM'
                    }, {
                        value: 'large',
                        text: 'LARGE'
                    },
                ],
                activeData: {},
                fagLoad: false,

            }

        },
        directives: {
            'b-modal': VBModal,
            'b-toggle': VBToggle,
            Ripple,

        },
        methods: {
             loadCoins() {
                this.$bvModal.hide('modal-filters');
                this.isBusy = true;
                this.loadedData = false;
                 axios.post('api/get_coins?page=' + this.Cpagpage, this.params).then(res => {
                    this.items = res.data;
                    this.loadedData = true;
                setTimeout(() => {
                    this.isBusy = false;
                }, 1000);
                })
                
            },
            loadFag() {
                this.isBusy = true;
                this.fagLoad = true;
                axios.post('api/get_fag').then(res => {
                    if (res.data) {
                        this.fag = res;
                        this.loaded = true;
                        this.fag.data.fear_greed_history = JSON.parse(this.fag.data.fear_greed_history);
                        let array = [];
                        this.fag.data.fear_greed_history.forEach(element => {
                            var d = new Date(parseInt(element.timestamp) * 1000);
                            let date = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
                            array.unshift(date);
                            this.chartOptions.xaxis.categories = array;
                            this.series[0].data.unshift(parseInt(element.value))

                        });
                    this.fagLoad = false;

                    }
                    

                })
                setTimeout(() => {
                    this.isBusy = false;
                }, 1000);
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
            sortingCols(val) {
                this.isBusy = true;
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
            },
            filterCoins() {

                this.isBusy = true;
                this.params.filters = [];
                let strArray = [];
                if (this.filterKey.mc_min) {
                    this.params.filters.push(["market_cap", ">=", this.filterKey.mc_min.replaceAll(",", "")]);
                }
                if (this.filterKey.mc_max) {
                    this.params.filters.push(["market_cap", "<=", this.filterKey.mc_max.replaceAll(",", "")]);
                }
                if (this.filterKey.day_min_change) {
                    this.params.filters.push(["price_change_percentage_24h", ">=", this.filterKey.day_min_change]);
                }
                if (this.filterKey.day_max_change) {
                    this.params.filters.push(["price_change_percentage_24h", "<=", this.filterKey.day_max_change]);
                }
                if (this.filterKey.platform && this.filterKey.platform != '') {
                    this.params.filters.push(["coin_platform", "like", "%" + this.filterKey.platform + "%"]);
                }
                if (this.filterKey.min_token_price) {
                    this.params.filters.push(["current_price", ">=", this.filterKey.min_token_price]);
                }
                if (this.filterKey.max_token_price) {
                    this.params.filters.push(["current_price", "<=", this.filterKey.max_token_price]);
                }
                if (this.filterKey.min_circulating_supply) {
                    this.params.filters.push(["circulating_supply", ">=", this.filterKey.min_circulating_supply]);
                }
                if (this.filterKey.max_circulating_supply) {
                    this.params.filters.push(["circulating_supply", "<=", this.filterKey.max_circulating_supply]);
                }
                if (this.filterKey.category && this.filterKey.category != '') {
                    this.params.filters.push(["coin_category", "like", "%" + this.filterKey.category + "%"]);
                }
                if (this.filterKey.max_market_cap_rank) {
                    this.params.filters.push(["market_cap_rank", "<=", this.filterKey.max_market_cap_rank]);
                }
                if (this.filterKey.min_market_cap_rank) {
                    this.params.filters.push(["market_cap_rank", ">=", this.filterKey.min_market_cap_rank]);
                }
                if (this.filterKey.min_total_supply) {
                    this.params.filters.push(["total_supply", ">=", this.filterKey.min_total_supply]);
                }
                if (this.filterKey.max_total_supply) {
                    this.params.filters.push(["total_supply", "<=", this.filterKey.max_total_supply]);
                }
                if (this.filterKey.keywords) {
                    this.params.filters.push(["coin_description", "like", "%'" + this.filterKey.keywords + "'%"]);
                }
                if (this.filterKey.min_trade_volume) {
                    this.params.filters.push(["total_volume", ">=", this.filterKey.min_trade_volume]);
                }
                if (this.filterKey.max_trade_volume) {
                    this.params.filters.push(["total_volume", "<=", this.filterKey.max_trade_volume]);
                }

                if (this.filterKey.min_roi_per) {
                    this.params.filters.push(["roi_percentage", ">=", this.filterKey.min_roi_per]);
                }
                if (this.filterKey.max_roi_per) {
                    this.params.filters.push(["roi_percentage", "<=", this.filterKey.max_roi_per]);
                }
                if (this.filterKey.min_times_roi) {
                    this.params.filters.push(["roi_times", ">=", this.filterKey.min_times_roi]);
                }
                if (this.filterKey.max_times_roi) {
                    this.params.filters.push(["roi_times", "<=", this.filterKey.max_times_roi]);
                }
                if (this.filterKey.min_days_in_market) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.min_days_in_market));

                    this.params.filters.push(["genesis_date", ">=", d.toISOString().split("T")[0]]);
                }
                if (this.filterKey.max_days_in_market) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.max_days_in_market));
                    this.params.filters.push(["genesis_date", "<=", d.toISOString().split("T")[0]]);
                }

                if (this.filterKey.min_total_supply_per) {
                    this.params.filters.push(["total_supply_percent", ">=", this.filterKey.min_total_supply_per]);
                }

                if (this.filterKey.max_total_supply_per) {
                    this.params.filters.push(["total_supply_percent", "<=", this.filterKey.max_total_supply_per]);
                }
                if (this.filterKey.min_seed_price) {
                    this.params.filters.push(["seed_price", ">=", this.filterKey.min_seed_price]);
                }

                if (this.filterKey.max_seed_price) {
                    this.params.filters.push(["seed_price", "<=", this.filterKey.max_seed_price]);
                }
                if (this.filterKey.min_seed_roi) {
                    this.params.filters.push(["roi_seed", ">=", this.filterKey.min_seed_roi]);
                }

                if (this.filterKey.max_seed_roi) {
                    this.params.filters.push(["roi_seed", "<=", this.filterKey.max_seed_roi]);
                }

                //end base filters

                //start social sentiments 

                if (this.filterKey.min_social_sentiment) {
                    this.params.filters.push(["average_sentiment_change", ">=", this.filterKey
                        .min_social_sentiment
                    ]);
                }

                if (this.filterKey.max_social_sentiment) {
                    this.params.filters.push(["average_sentiment_change", "<=", this.filterKey
                        .max_social_sentiment
                    ]);
                }
                if (this.filterKey.min_social_mentions_change) {
                    this.params.filters.push(["social_mentions_change", ">=", this.filterKey
                        .min_social_mentions_change
                    ]);
                }

                if (this.filterKey.max_social_mentions_change) {
                    this.params.filters.push(["social_mentions_change", "<=", this.filterKey
                        .max_social_mentions_change
                    ]);
                }
                if (this.filterKey.min_social_engagement_change) {
                    this.params.filters.push(["social_engagement_change", ">=", this.filterKey
                        .min_social_engagement_change
                    ]);
                }

                if (this.filterKey.max_social_engagement_change) {
                    this.params.filters.push(["social_engagement_change", "<=", this.filterKey
                        .max_social_engagement_change
                    ]);
                }
                if (this.filterKey.min_average_sentiment_1_5) {
                    this.params.filters.push(["average_sentiment", ">=", this.filterKey
                        .min_average_sentiment_1_5
                    ]);
                }

                if (this.filterKey.max_average_sentiment_1_5) {
                    this.params.filters.push(["average_sentiment", "<=", this.filterKey
                        .max_average_sentiment_1_5
                    ]);
                }
                //end soical sentiments
                //start unlocking 
                if (this.filterKey.min_total_locked) {
                    this.params.filters.push(["total_locked", ">=", this.filterKey.min_total_locked]);
                }

                if (this.filterKey.max_total_locked) {
                    this.params.filters.push(["total_locked", "<=", this.filterKey.max_total_locked]);
                }
                if (this.filterKey.next_unlock_status) {
                    var d1 = new Date();
                    d1.setDate(d1.getDate() + 7);
                    var d2 = new Date();
                    d2.setDate(d2.getDate() + 60);
                    if (this.filterKey.next_unlock_status == "red") {
                        this.params.filters.push(["next_unlock_date", "<=", d1.toISOString().split("T")[0]]);
                    }
                    if (this.filterKey.next_unlock_status == "orange") {
                        this.params.filters.push(["next_unlock_date", ">", d1.toISOString().split("T")[0]]);
                        this.params.filters.push(["next_unlock_date", "<=", d2.toISOString().split("T")[0]]);
                    }

                    if (this.filterKey.next_unlock_status == "green") {
                        this.params.filters.push(["next_unlock_date", ">", d2.toISOString().split("T")[0]]);
                    }
                }
                if (this.filterKey.min_next_unlock_n_tokens) {
                    this.params.filters.push(["next_unlock_number_of_tokens", ">=", this.filterKey
                        .min_next_unlock_n_tokens
                    ]);
                }

                if (this.filterKey.max_next_unlock_n_tokens) {
                    this.params.filters.push(["next_unlock_number_of_tokens", "<=", this.filterKey
                        .max_next_unlock_n_tokens
                    ]);
                }
                if (this.filterKey.min_next_unlock_per) {
                    this.params.filters.push(["next_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_next_unlock_per
                    ]);
                }

                if (this.filterKey.max_next_unlock_per) {
                    this.params.filters.push(["next_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_next_unlock_per
                    ]);
                }
                if (this.filterKey.next_unlock_size) {
                    this.params.filters.push(["next_unlock_size", "like", "%" + this.filterKey.next_unlock_size + "%"]);
                }
                if (this.filterKey.min_3_months_unlock_n_tokens) {
                    this.params.filters.push(["three_months_unlock_number_of_tokens", ">=", this.filterKey
                        .min_3_months_unlock_n_tokens
                    ]);
                }

                if (this.filterKey.max_3_months_unlock_n_tokens) {
                    this.params.filters.push(["three_months_unlock_number_of_tokens", "<=", this.filterKey
                        .max_3_months_unlock_n_tokens
                    ]);
                }
                if (this.filterKey.min_3_months_unlock_per) {
                    this.params.filters.push(["three_months_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_3_months_unlock_per
                    ]);
                }

                if (this.filterKey.max_3_months_unlock_per) {
                    this.params.filters.push(["three_months_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_3_months_unlock_per
                    ]);
                }
                if (this.filterKey.three_months_unlock_size) {
                    this.params.filters.push(["three_months_unlock_size", "like", "%" + this.filterKey
                        .three_months_unlock_size + "%"
                    ]);
                }
                if (this.filterKey.min_6_months_unlock_n_tokens) {
                    this.params.filters.push(["six_months_unlock_number_of_tokens", ">=", this.filterKey
                        .min_6_months_unlock_n_tokens
                    ]);
                }
                if (this.filterKey.max_6_months_unlock_n_tokens) {
                    this.params.filters.push(["six_months_unlock_number_of_tokens", "<=", this.filterKey
                        .max_6_months_unlock_n_tokens
                    ]);
                }
                if (this.filterKey.min_6_months_unlock_per) {
                    this.params.filters.push(["six_months_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_6_months_unlock_per
                    ]);
                }
                if (this.filterKey.max_6_months_unlock_per) {
                    this.params.filters.push(["six_months_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_6_months_unlock_per
                    ]);
                }
                if (this.filterKey.six_months_unlock_size) {
                    this.params.filters.push(["six_months_unlock_size", "like", "%" + this.filterKey
                        .six_months_unlock_size + "%"
                    ]);
                }

                this.loadCoins();

            },
            clearFilters() {
                this.filterKey = {
                    mc_min: null,
                    mc_max: null,
                    day_min_change: null,
                    day_max_change: null,
                    platform: null,
                    min_token_price: null,
                    max_token_price: null,
                    min_circulating_supply: null,
                    max_circulating_supply: null,
                    category: null,
                    max_market_cap_rank: null,
                    min_market_cap_rank: null,
                    market_cap_rank: null,
                    min_total_supply: null,
                    max_total_supply: null,
                    keywords: null,
                    min_trade_volume: null,
                    max_trade_volume: null,
                    min_roi_per: null,
                    max_roi_per: null,
                    min_times_roi: null,
                    max_times_roi: null,
                    min_days_in_market: null,
                    max_days_in_market: null,
                    min_total_supply_per: null,
                    max_total_supply_per: null,
                    min_seed_price: null,
                    max_seed_price: null,
                    min_seed_roi: null,
                    max_seed_roi: null,
                    min_social_sentiment: null,
                    max_social_sentiment: null,
                    min_social_mentions_change: null,
                    max_social_mentions_change: null,
                    min_social_engagement_change: null,
                    max_social_engagement_change: null,
                    min_average_sentiment_1_5: null,
                    max_average_sentiment_1_5: null,
                    min_total_locked: null,
                    max_total_locked: null,
                    next_unlock_status: null,
                    min_next_unlock_n_tokens: null,
                    max_next_unlock_n_tokens: null,
                    min_next_unlock_per: null,
                    max_next_unlock_per: null,
                    next_unlock_size: null,
                    min_3_months_unlock_n_tokens: null,
                    max_3_months_unlock_n_tokens: null,
                    min_3_months_unlock_per: null,
                    max_3_months_unlock_per: null,
                    three_months_unlock_size: null,
                    min_6_months_unlock_n_tokens: null,
                    max_6_months_unlock_n_tokens: null,
                    min_6_months_unlock_per: null,
                    max_6_months_unlock_per: null,
                    six_months_unlock_size: null,
                }
                this.params.filters = [];
                this.params.filters2 = '';
                this.params.sort = ["market_cap", "desc"];
                this.loadCoins();
            },
            detailsModel(item) {
                if (typeof item.sparkline_in_7d == 'string') {
                    let sparklines = item.sparkline_in_7d.split("|").map(Number);
                    sparklines = sparklines.slice(0, -1);
                    item.sparkline_in_7d = sparklines;
                }
                this.activeData = item;
                this.$bvModal.show('modal-details');
            },
            dateFormat(val) {
                if (val) {
                    let d = new Date(val)
                    return d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear();
                }
            },
            calculate_social_score(rowdata) {
                let score = 0;
                let total_apps = 0;
                total_apps = 0;
                if (rowdata.twitter != null)
                    total_apps = total_apps + 1;

                if (rowdata.telegram != null)
                    total_apps = total_apps + 1;

                if (rowdata.discord != null)
                    total_apps = total_apps + 1;

                if (rowdata.medium != null)
                    total_apps = total_apps + 1;

                if (rowdata.reddit != null)
                    total_apps = total_apps + 1;

                if (rowdata.whitepaper != null)
                    total_apps = total_apps + 1;

                if (rowdata.github != null)
                    total_apps = total_apps + 1;

                if (rowdata.twitter_followers != null) {
                    if (rowdata.telegram_members != null) {

                        if (parseInt(rowdata.twitter_followers) < 300000)
                            score = score + 1;

                        else if (parseInt(rowdata.twitter_followers) < 400000)
                            score = score + 2;

                        else if (parseInt(rowdata.twitter_followers) < 600000)
                            score = score + 3;

                        else if (parseInt(rowdata.twitter_followers) < 750000)
                            score = score + 4;

                        else if (parseInt(rowdata.twitter_followers) < 1000000)
                            score = score + 5;

                        else if (parseInt(rowdata.twitter_followers) > 1000000)
                            score = score + 6;
                        else
                            score = 0;


                        if (parseInt(rowdata.telegram_members) < 30000)
                            score = score + 1;

                        else if (parseInt(rowdata.telegram_members) < 50000)
                            score = score + 2;

                        else if (parseInt(rowdata.telegram_members) < 80000)
                            score = score + 3;

                        else if (parseInt(rowdata.telegram_members) > 80000)
                            score = score + 4;

                        else
                            score = score + 1;

                    } else {

                        if (parseInt(rowdata.twitter_followers) < 100000)
                            score = score + 1;

                        else if (parseInt(rowdata.twitter_followers) < 300000)
                            score = score + 2;

                        else if (parseInt(rowdata.twitter_followers) < 400000)
                            score = score + 4;

                        else if (parseInt(rowdata.twitter_followers) < 750000)
                            score = score + 6;

                        else if (parseInt(rowdata.twitter_followers) < 1000000)
                            score = score + 7;

                        else if (parseInt(rowdata.twitter_followers) > 1000000)
                            score = score + 8;

                        else
                            score = 0;

                    }
                } else {
                    if (rowdata.telegram_members != null) {

                        if (parseInt(rowdata.telegram_members) < 20000)
                            score = score + 1;

                        else if (parseInt(rowdata.telegram_members) < 40000)
                            score = score + 2;

                        else if (parseInt(rowdata.telegram_members) < 80000)
                            score = score + 4;

                        else if (parseInt(rowdata.telegram_members) < 120000)
                            score = score + 5;

                        else if (parseInt(rowdata.telegram_members) < 180000)
                            score = score + 6;

                        else if (parseInt(rowdata.telegram_members) < 500000)
                            score = score + 7;

                        else if (parseInt(rowdata.telegram_members) > 500000)
                            score = score + 8;
                        else
                            score = score + 1;


                    }
                }

                //Check the apps
                if (total_apps < 4)
                    score = score + 1;
                else if (total_apps >= 4)
                    score = score + 2;




                if (score > 10) {
                    score = 10;
                }

                return score;
            },
            liveCoinFetch() {
                if (this.pricesWs && this.pricesWs.readyState === WebSocket.OPEN) {
                    this.pricesWs.close();
                }
                this.coinsStr = '';
                this.items.data.forEach(element => {
                    this.coinsStr += element.coin_id + ',';
                });
                this.pricesWs = new WebSocket('wss://ws.coincap.io/prices?assets=' + this.coinsStr)
                let thisScope = this;
                this.pricesWs.onmessage = function (msg) {
                    let coinFetched = JSON.parse(msg.data);
                    let objKeys = Object.keys(coinFetched);
                    objKeys.forEach(element => {
                        let index = thisScope.items.data.findIndex(x => x.coin_id === element)
                        if (thisScope.items.data[index]) {
                            thisScope.items.data[index].current_price = coinFetched[element];
                        }
                    });

                }
            }

        },
        mounted() {
            this.loadCoins();
            this.loadFag();
        },

        watch: {
            'Cpagpage': function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.loadCoins()
                }
            },
            'params.filters2': function (newVal, oldVal) {
                if (oldVal != newVal && newVal.trim().length == 0 || newVal.trim().length >= 3) {
                    this.Cpagpage = 1;
                    this.loadCoins()
                }
            },
            'loadedData': function (n, o) {
                if (this.loadedData == true) {

                    this.liveCoinFetch();
                }

            }
        }
    }

</script>
<style>
    .nameWidth {
        width: 55px !important;
    }

    .full {
        width: 100%
    }

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

    #overlay {
        position: fixed;
        /* Sit on top of the page content */
        display: none;
        /* Hidden by default */
        width: 100%;
        /* Full width (cover the whole page) */
        height: 100%;
        /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
        z-index: 2;
        /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer;
        /* Add a pointer on hover */
    }

</style>
