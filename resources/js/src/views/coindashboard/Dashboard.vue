<template>
    <div id="dashboard">
        <b-card no-body>
            <b-overlay :show="fagLoad" rounded="sm">
                <b-card-body class="pt-1">
                    <div class="mx-auto" style="">
                        <b-row class=" mb-1">
                            <b-col md="3" sm="6" xl="3">
                                <div class="d-flex mx-auto justify-content-center">
                                    <h5 class="text-secondary" style="margin-right:8px;">MC:</h5>
                                    <h5 v-if="loaded">{{fag.data.market_cap?fag.data.market_cap:'-'}}</h5>
                                </div>

                            </b-col>
                            <b-col md="3" sm="6" xl="3" class="mb-1">
                                <div class="d-flex mx-auto justify-content-center">
                                    <h5 class="text-secondary" style="margin-right:8px;">VOL(24):</h5>
                                    <h5 v-if="loaded"> {{fag.data.vol_24h?fag.data.vol_24h:'-'}}</h5>
                                </div>

                            </b-col>
                            <b-col md="3" sm="6" xl="3" class="mb-1">
                                <div class="d-flex mx-auto justify-content-center">
                                    <h5 class="text-secondary" style="margin-right:8px;">Dominance:</h5>
                                    <div class="d-flex justify-content-between" v-if="loaded">
                                        <h5 style="margin:0 8px 0 8px"> {{fag.data.btc_dom}}
                                        </h5>
                                        <h5 style="margin:0 8px 0 8px">{{fag.data.eth_dom}}</h5>
                                    </div>

                                </div>

                            </b-col>
                            <b-col md="3" sm="6" xl="3" class="mb-1">
                                <div class="d-flex mx-auto justify-content-center">
                                    <h5 class="text-secondary" style="margin-right:8px;">ETH Gas:</h5>
                                    <div class="d-flex justify-content-between">
                                        <h5 style="margin:0 8px 0 8px" v-if="loaded">
                                            {{fag.data.eth_gas?fag.data.eth_gas:'-'}}
                                        </h5>

                                    </div>

                                </div>

                            </b-col>

                        </b-row>
                    </div>
                    <b-row class="">
                        <b-col sm="3" md="3" cols="6">
                            <div class="mx-auto w-75 text-center">
                                <h5 class="w-75 mx-auto">Fear and Greed</h5>
                                <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                                    :inner-radius="87" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                                    :max="100"
                                    :gauge-color="[{ offset: 0, color: '#f55442'}, { offset: 100, color: '#0bd63a'}]"
                                    :scale-interval="3">
                                    <div class="inner-text">
                                        <div class="mt-2"
                                            :class="{'text-danger':fag.data.fear_greed_index<50,'text-success':fag.data.fear_greed_index>=50}">
                                            <span class="d-block"
                                                style="font-size:20px">{{fag.data.fear_greed_index}}</span>
                                            <span class="d-block"
                                                style="font-size:15px">{{fag.data.fear_greed_classification}}</span>
                                            <span class="d-block text-info " style="font-size:10px"><a
                                                    v-ripple.400="'rgba(113, 12, 240, 35)'" v-b-modal.modal-chart
                                                    variant="outline-primary">View
                                                    History</a></span>
                                        </div>
                                    </div>
                                </VueSvgGauge>
                            </div>
                        </b-col>
                        <b-col sm="3" md="3" cols="6">
                            <div class="mx-auto w-75 text-center">
                                <h5 class="w-75 mx-auto">NFT Barometer</h5>
                                <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                                    :inner-radius="87" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                                    :max="100"
                                    :gauge-color="[{ offset: 0, color: '#f55442'}, { offset: 100, color: '#0bd63a'}]"
                                    :scale-interval="3">
                                    <div class="inner-text">
                                        <div class="mt-2"
                                            :class="{'text-danger':fag.data.fear_greed_index<50,'text-success':fag.data.fear_greed_index>=50}">
                                            <span class="d-block"
                                                style="font-size:20px">{{fag.data.fear_greed_index}}</span>
                                            <span class="d-block"
                                                style="font-size:15px">{{fag.data.fear_greed_classification}}</span>
                                            <span class="d-block text-info " style="font-size:10px"><a
                                                    v-ripple.400="'rgba(113, 12, 240, 35)'" v-b-modal.modal-chart
                                                    variant="outline-primary">View
                                                    History</a></span>
                                        </div>
                                    </div>
                                </VueSvgGauge>
                            </div>
                        </b-col>
                        <b-col sm="3" md="3" cols="6">
                            <div class="mx-auto w-75 text-center">
                                <h5 class="w-75 mx-auto">BTC in/outflow</h5>
                                <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                                    :inner-radius="87" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                                    :max="100"
                                    :gauge-color="[{ offset: 0, color: '#f55442'}, { offset: 100, color: '#0bd63a'}]"
                                    :scale-interval="3">
                                    <div class="inner-text">
                                        <div class="mt-2"
                                            :class="{'text-danger':fag.data.fear_greed_index<50,'text-success':fag.data.fear_greed_index>=50}">
                                            <span class="d-block"
                                                style="font-size:20px">{{fag.data.fear_greed_index}}</span>
                                            <span class="d-block"
                                                style="font-size:15px">{{fag.data.fear_greed_classification}}</span>
                                            <span class="d-block text-info " style="font-size:10px"><a
                                                    v-ripple.400="'rgba(113, 12, 240, 35)'" v-b-modal.modal-chart
                                                    variant="outline-primary">View
                                                    History</a></span>
                                        </div>
                                    </div>
                                </VueSvgGauge>
                            </div>
                        </b-col>
                        <b-col sm="3" md="3" cols="6">
                            <div class="mx-auto w-75 text-center">
                                <h5 class="w-75 mx-auto">BTC Outflow</h5>
                                <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                                    :inner-radius="87" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                                    :max="100"
                                    :gauge-color="[{ offset: 0, color: '#f55442'}, { offset: 100, color: '#0bd63a'}]"
                                    :scale-interval="3">
                                    <div class="inner-text">
                                        <div class="mt-2"
                                            :class="{'text-danger':fag.data.fear_greed_index<50,'text-success':fag.data.fear_greed_index>=50}">
                                            <span class="d-block"
                                                style="font-size:20px">{{fag.data.fear_greed_index}}</span>
                                            <span class="d-block"
                                                style="font-size:15px">{{fag.data.fear_greed_classification}}</span>
                                            <span class="d-block text-info " style="font-size:10px"><a
                                                    v-ripple.400="'rgba(113, 12, 240, 35)'" v-b-modal.modal-chart
                                                    variant="outline-primary">View
                                                    History</a></span>
                                        </div>
                                    </div>
                                </VueSvgGauge>
                            </div>
                        </b-col>
                    </b-row>
                </b-card-body>
            </b-overlay>
        </b-card>
        <div class="body-content-overlay" />
        <div class="searchbar mt-1 mb-1">
            <b-row>
                <b-col cols="8" md="8" xl="10">
                    <b-input-group class="input-group-merge">
                        <b-form-input v-model="params.filters2" placeholder="Search Product" class="search-product" />
                        <b-input-group-append is-text>
                            <feather-icon icon="SearchIcon" class="text-muted" />
                        </b-input-group-append>
                    </b-input-group>
                </b-col>
                <b-col cols="4" md="4" xl="2">
                    <div class="d-flex jusctify-content-between">
                        <div>
                            <b-button style="padding:5px" v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                variant="outline-primary" class="btn-icon mx-1">
                                <feather-icon v-if="locked" @click="lockedFilter" icon="LockIcon" size="20"
                                    class="text-black cursor-pointer" style=" " />
                                <feather-icon v-if="!locked" @click="lockedFilter" icon="UnlockIcon" size="20"
                                    class="text-black cursor-pointer" style=" " />
                            </b-button>
                        </div>
                        <div v-b-modal.modal-filters variant="outline-primary">
                            <b-button style="padding:5px" v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                variant="outline-primary" class="btn-icon mx-1">
                                <feather-icon icon="FilterIcon" size="20" class="text-black cursor-pointer" style=" " />
                            </b-button>
                        </div>
                        <div @click="clearFilters(true)">
                            <b-button style="padding:5px" v-ripple.400="'rgba(113, 102, 240, 0.15)'"
                                variant="outline-primary" class="btn-icon mx-1">
                                <feather-icon icon="RefreshCcwIcon" size="20" class="text-black cursor-pointer"
                                    style="" />
                            </b-button>

                        </div>

                    </div>
                </b-col>
            </b-row>
        </div>
        <div class="body-content-overlay" />
        <div id="ctable">
            <b-overlay :show="isBusy" rounded="sm">
                <b-table sticky-header :no-border-collapse="true" tbody-tr-class="cursor-pointer" show-empty
                    @row-clicked="detailsModel($event)" style="white-space: nowrap;" responsive :items="items.data"
                    :fields="visibleFields">
                    <template #empty="scope">
                        <h4>{{ scope.emptyText }}</h4>
                    </template>

                    <template #head()="scope">
                        <div class="text-nowrap cursor-pointer text-center " style=""
                            @click="sortingCols(scope.field.key)">
                            <div class="d-flex justify-content-center">
                                <span> {{ scope.label }} </span> <span class="">
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
                    <template #cell(market_cap_rank)="data">
                        <div class="d-flex">
                            <div class="mx-1">
                                <feather-icon icon="StarIcon" size="14" />
                            </div>
                            <div class="" style="">{{ data.value }}</div>
                        </div>
                    </template>
                    <template #cell(name)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start">
                            <b-avatar class="text-center mx-1" style="" :src="data.item.image" />

                            <div class="">
                                <div class="text-nowrap text-truncate" style="max-width: 100px;">
                                    {{ data.value }}
                                </div>
                                <div class="text-nowrap text-truncate text-left"
                                    style="max-width: 100px; font-size:12px;">
                                    {{ data.item.symbol }}
                                </div>

                            </div>
                        </div>
                    </template>
                    <template #cell(seed_price)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' &&data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(roi_seed)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' &&data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(total_locked)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(next_unlock_date)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(next_unlock_status)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(next_unlock_number_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(next_unlock_percent_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(next_unlock_size)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(first_vc_unlock)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(end_vc_unlock)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(three_months_unlock_number_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(three_months_unlock_percent_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(three_months_unlock_size)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>



                    <template #cell(six_months_unlock_number_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(six_months_unlock_percent_of_tokens)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>
                    <template #cell(six_months_unlock_size)="data">
                        <div style="text-align: center;" class="d-flex justify-content-start"
                            :class="{'blurry-text' :userData.currentPlan =='basic' && data.item.market_cap_rank < 1 ||userData.currentPlan =='basic' && data.item.market_cap_rank >5}">
                            {{ data.value }}
                        </div>
                    </template>

                    <template #cell(current_price)="data">
                        <div class="" style="">{{data.value}}$</div>
                    </template>
                    <template #cell(market_cap)="data">
                        <div class="" style="">{{data.value?data.value:0}}$</div>
                    </template>
                    <template #cell(high_24h)="data">
                        <div v-if="data.value !=''" class="" style="">{{data.value}}$</div>
                    </template>
                    <template #cell(low_24h)="data">
                        <div v-if="data.value !=''" class="" style="">{{data.value}}$</div>
                    </template>

                    <template #cell(price_change_percentage_24h)="data">
                        <div v-if="data.value">
                            <span v-if="data.value>= 0" class="text-success" style="">{{ data.value }}
                                %</span>
                            <span v-else class="text-danger" style="">{{ data.value }} %</span></div>
                    </template>
                    <template #cell(roi_percentage)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger" style="">{{ roundData(data.value) }}
                                %</span></div>
                    </template>
                    <template #cell(total_supply_percent)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger" style="">{{ roundData(data.value) }}
                                %</span></div>
                    </template>
                    <template #cell(ath)="data">
                        <div v-if="data.value">
                            <span style="">{{data.value}}$</span>
                        </div>
                    </template>
                    <template #cell(atl)="data">
                        <div v-if="data.value">
                            <span style="">{{data.value}}$</span>
                        </div>
                    </template>
                    <template #cell(social_mentions_change)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger" style="">{{ roundData(data.value) }}
                                %</span></div>
                    </template>
                    <template #cell(social_engagement_change)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger" style="">{{ roundData(data.value) }}
                                %</span></div>
                    </template>
                    <template #cell(average_sentiment_change)="data">
                        <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success"
                                @click="sortingCols(data.value)" style="">{{ roundData(data.value) }}
                                %</span>
                            <span v-else-if="data.value!=null" class="text-danger" style="">{{ roundData(data.value) }}
                                %</span></div>
                    </template>
                    <template #cell()="data">
                        <div class="text-center" style="">
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
        <b-modal id="modal-filters" :hide-footer="true" size="lg" title="Filters">
            <template>
                <b-row>
                    <b-col>
                        <b-form-select v-model="selectedPreset">
                            <b-form-select-option :value="null" selected>Select A Preset</b-form-select-option>
                            <b-form-select-option v-for="(preset,index) in presetFilters" :key="index"
                                :value="preset.id">
                                {{ preset.preset_name }}
                            </b-form-select-option>
                        </b-form-select>
                    </b-col>
                    <b-col class="m-auto">
                        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" v-if="selectedPreset" @click="deletePreset"
                            variant="warning" class="btn-icon">
                            <feather-icon icon="Trash2Icon" />
                        </b-button>
                        <b-button size="md" v-b-modal.modal-preset-create v-ripple.400="'rgba(113, 12, 240, 0.15)'"
                            variant="outline-primary" pill>Create New Preset
                        </b-button>

                    </b-col>
                </b-row>
                <div class="accordion" role="tablist">
                    <app-collapse accordion>
                        <app-collapse-item :isVisible="true" title="Base Filters">
                            <b-card class="mb-1">
                                <b-card-body>
                                    <b-row>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Market Cap">
                                                    <div class="d-flex">
                                                        <b-form-input v-numeric-only v-model="filterKey.min_market_cap"
                                                            placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-numeric-only v-model="filterKey.max_market_cap"
                                                            placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>

                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Token Price">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_current_price"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_current_price"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Circulating Supply">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_circulating_supply"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_circulating_supply"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Total Supply">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_total_supply"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_total_supply"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Market Cap. Rank">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_market_cap_rank"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_market_cap_rank"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Trade Volume">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_trading_volume"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_trading_volume"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="ROI %">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_roi_percentage"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_roi_percentage"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="ROI in X's">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_roi_times" v-numeric-only
                                                            placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_roi_times" v-numeric-only
                                                            placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Daily Price Change (%)"
                                                    label-for="price_change_percentage_24h">
                                                    <div class="d-flex">
                                                        <b-form-input name="price_change_percentage_24h" v-numeric-only
                                                            v-model="filterKey.min_price_change_percentage_24h"
                                                            placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_price_change_percentage_24h"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>




                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Days in Market">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_genesis_date"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_genesis_date"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Total Supply (%)">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_total_supply_percent"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_total_supply_percent"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Seed Price">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_seed_price" v-numeric-only
                                                            placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_seed_price" v-numeric-only
                                                            placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Seed ROI">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_roi_seed" v-numeric-only
                                                            placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_roi_seed" v-numeric-only
                                                            placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Platform" label-for="">
                                                    <div class="d-flex">
                                                        <b-form-select id="" v-model="filterKey.coin_platform"
                                                            :options="platforms" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>

                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Keywords" label-for="">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.keywords"
                                                            placeholder="key words" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Category" label-for="">
                                                    <div class="d-flex">
                                                        <b-form-select id="" v-model="filterKey.coin_category"
                                                            :options="categories" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </app-collapse-item>
                        <app-collapse-item title="Social Sentiments">
                            <b-card no-body class="mb-1">
                                <b-card-body>
                                    <b-row>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Sentiment Change %">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_average_sentiment_change"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_average_sentiment_change"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Social Mentions Change %">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_social_mentions_change"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_social_mentions_change"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Social Engagement Change %">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_social_engagement_change"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_social_engagement_change"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Average Sentiment (1-5)">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_average_sentiment"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_average_sentiment"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                    </b-row>
                                </b-card-body>
                            </b-card>
                        </app-collapse-item>
                        <app-collapse-item title="Unlocking">
                            <b-card no-body class="mb-1">
                                <b-card-body>
                                    <b-row>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Total Locked">
                                                    <div class="d-flex">
                                                        <b-form-input v-model="filterKey.min_total_locked"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input v-model="filterKey.max_total_locked"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Unlock Status">
                                                    <div class="d-flex">
                                                        <b-form-select id="" v-model="filterKey.next_unlock_status"
                                                            :options="unlockStatusCoins" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Next Unlock # of Tokens">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_next_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_next_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Next Unlock %">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_next_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_next_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="Next Unlock Size">
                                                    <div class="d-flex">
                                                        <b-form-select id="" v-model="filterKey.next_unlock_size"
                                                            :options="nextUnlockSize" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="3 Months Unlock # of Tokens">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_three_months_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_three_months_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="3 Months Unlock %">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_three_months_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_three_months_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="3 Months Unlock Size">
                                                    <div class="d-flex">
                                                        <b-form-select id=""
                                                            v-model="filterKey.three_months_unlock_size"
                                                            :options="nextUnlockSize" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="6 Months Unlock # of Tokens">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_six_months_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_six_months_unlock_number_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
                                            <div class="">
                                                <b-form-group label="6 Months Unlock %">
                                                    <div class="d-flex">
                                                        <b-form-input
                                                            v-model="filterKey.min_six_months_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="min" />
                                                        <span>
                                                            <feather-icon icon="ArrowRightIcon" size="16"
                                                                class="align-middle" style="margin:10px 6px 0 0px" />
                                                        </span>
                                                        <b-form-input
                                                            v-model="filterKey.max_six_months_unlock_percent_of_tokens"
                                                            v-numeric-only placeholder="max" />
                                                    </div>
                                                </b-form-group>
                                            </div>
                                        </b-col>
                                        <b-col md="6" xl="6">
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
                            </b-card>
                        </app-collapse-item>
                    </app-collapse>

                </div>
            </template>
            <div class="float-right p-1">
                <b-button @click="clearFilters(true)" v-ripple.400="'rgba(113, 12, 240, 0.15)'"
                    variant="outline-primary" pill>Clear all</b-button>
                <b-button @click="filterCoins(true)" v-ripple.400="'rgba(113, 8, 150, 0.15)'" variant="outline-primary"
                    pill>
                    Apply filters</b-button>
            </div>
        </b-modal>
        <b-modal id="modal-details" :hide-footer="true" v-if="activeData" centered size="lg">
            <template>
                <div slot="modal-title">
                    <div class="d-flex justify-content-between min-block">
                        <div class="">
                            <div>Rank #{{activeData.market_cap_rank}}</div>
                            <div>
                                <b-avatar v-if="activeData.image" :src="activeData.image"></b-avatar>
                                <span class="my-auto"> &nbsp;{{activeData.name +' - '+activeData.symbol}} &nbsp; <span
                                        class="text-success">${{ activeData.current_price }}</span> </span>
                            </div>
                        </div>
                        <div>
                            <div class="bg-theme rounded">

                                <div class="d-flex">
                                    <div class="my-auto" style="margin-right: 4px;">Contract </div>
                                    <b-form-select v-model="selectedContract">
                                        <b-form-select-option :value="null" selected>Select</b-form-select-option>
                                        <b-form-select-option v-for="(address,index) in activeData.contract_address"
                                            :key="index" :value="address.contract_address">
                                            {{ address.platform }}
                                        </b-form-select-option>
                                    </b-form-select>
                                </div>
                                <div v-if="selectedContract" class="d-flex mt-1">
                                    <div class="text-nowrap text-truncate" style="width:150px">{{selectedContract}}
                                    </div>
                                    <b-button size="sm" v-clipboard:copy="selectedContract" v-clipboard:success="onCopy"
                                        v-clipboard:error="onError" v-ripple.400="'rgba(113, 12, 240, 0.15)'"
                                        variant="outline-primary" pill>Copy!
                                    </b-button>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <app-collapse accordion>
                    <app-collapse-item :isVisible="true" visible title="Market Data" class="open">
                        <b-card no-body class="mb-1">
                            <b-card-body>
                                <b-row>
                                    <b-col md="8" sm="7" class="text-center sparlineChat">
                                        <h5> 7 Days</h5>
                                        <trend :data="activeData.sparkline_in_7d" :gradient="['#d40808']" auto-draw
                                            smooth></trend>
                                    </b-col>
                                    <b-col>
                                        <div class="mb-1">
                                            <h5>{{ activeData.name }} Volume</h5>
                                            <div class="" style="font-size:16px; font-weight: 600;">
                                                <span class="">${{ activeData.total_volume }}</span>
                                            </div>
                                        </div>
                                        <div class="mb-1">
                                            <h5>{{ activeData.name }} Market Cap</h5>
                                            <div class="" style="font-size:16px; font-weight: 600;">
                                                <span>${{ activeData.market_cap }}</span> </div>
                                        </div>
                                        <div class="mb-1">
                                            <h5>{{ activeData.name }} Circulating Supply</h5>
                                            <div class="" style="font-size:16px; font-weight: 600;">
                                                <span>{{ activeData.circulating_supply }}</span> </div>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </app-collapse-item>
                    <app-collapse-item title="Social Data">
                        <b-card no-body class="mb-1">
                            <b-card-body>

                                <b-row>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.website && activeData.website != '' ">
                                        <a :href="activeData.website" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/website.png'" fluid class="w-50"
                                                alt="Responsive image" />
                                        </a>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.twitter && activeData.twitter != '' ">
                                        <a :href="activeData.twitter" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/twitter.png'" fluid class="w-50"
                                                alt="Responsive image" />
                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.twitter_followers">{{kFormatter(activeData.twitter_followers)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.telegram && activeData.telegram != '' ">
                                        <a :href="activeData.telegram" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/telegram.png'" fluid class="w-50"
                                                alt="Responsive image" />

                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.telegram_members">{{kFormatter(activeData.telegram_members)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.discord && activeData.discord != '' ">
                                        <a :href="activeData.discord" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/discord.png'" fluid class="w-50"
                                                alt="Responsive image" />

                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.discord_followers">{{kFormatter(activeData.discord_followers)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.medium && activeData.medium != '' ">
                                        <a :href="activeData.medium" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/medium.png'" fluid class="w-50"
                                                alt="Responsive image" />

                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.medium_followers">{{kFormatter(activeData.medium_followers)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.reddit && activeData.reddit != '' ">
                                        <a :href="activeData.reddit" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/reddit.png'" fluid class="w-50"
                                                alt="Responsive image" />

                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.reddit_followers">{{kFormatter(activeData.reddit_followers)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.whitepaper && activeData.whitepaper != '' ">
                                        <a :href="activeData.whitepaper" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/whitepaper.png'" fluid class="w-50"
                                                alt="Responsive image" />

                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.whitepaper_followers">{{kFormatter(activeData.whitepaper_followers)}}
                                        </span>
                                    </b-col>
                                    <b-col class="text-center" cols="1" md="2" lg="2" sm="2"
                                        v-if="activeData.github && activeData.github != '' ">
                                        <a :href="activeData.github" target="_blank" class="d-block">
                                            <b-img rounded :src="'/images/static/github.png'" fluid class="w-50"
                                                alt="Responsive image" />
                                        </a>
                                        <span class="text-center" style="font-size:12px; font-weight:500"
                                            v-if="activeData.github_followers">{{kFormatter(activeData.github_followers)}}
                                        </span>
                                    </b-col>
                                </b-row>
                                <b-row class="text-center mt-1 mb-1">
                                    <b-col sm="3" md="2" v-if="activeData">
                                        <div class="border border-2 rounded border-dark">
                                            <div class="soicalLable">Social Score: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;">
                                                {{ calculate_social_score(activeData) }}/10</div>
                                        </div>
                                    </b-col>
                                    <b-col sm="3" md="2" v-if="activeData.total_supply_percent">
                                        <div class="border border-2 rounded border-dark">
                                            <div class="soicalLable">Total Supply %: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;">
                                                {{ activeData.total_supply_percent}} %</div>
                                        </div>
                                    </b-col>
                                    <b-col sm="3" md="2" v-if="activeData.social_mentions">
                                        <div class="border border-2 rounded border-dark">
                                            <div class="soicalLable">Social Mentions: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px" class="text-success"
                                                v-if="activeData.social_mentions>=0">
                                                +{{activeData.social_mentions}} %</div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;" class="text-danger"
                                                v-else> {{activeData.social_mentions}} %</div>
                                        </div>
                                    </b-col>
                                    <b-col sm="3" md="2" v-if="activeData.average_sentiment">
                                        <div class="border border-2 rounded border-dark">
                                            <div class="soicalLable">Average Sentiment: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;" class="text-success">
                                                {{activeData.average_sentiment}}</div>
                                        </div>
                                    </b-col>
                                    <b-col sm="3" md="2" v-if="activeData.social_engagement">
                                        <div class="border border-2 rounded border-dark">
                                            <div class="soicalLable">Social Engagement: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px" class="text-success"
                                                v-if="activeData.social_mentions>=0">
                                                +{{activeData.social_engagement}} %</div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;" class="text-danger"
                                                v-else> {{activeData.social_engagement}} %</div>
                                        </div>
                                    </b-col>
                                    <b-col sm="3" md="2" v-if="activeData.average_sentiment_change">
                                        <div class="border border-3 rounded border-dark">
                                            <div class="soicalLable">Social Engagement: </div>
                                            <div class="m-0 p-0 border  border border-dark"></div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px" class="text-success"
                                                v-if="roundData(activeData.average_sentiment_change)>=0">
                                                +{{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                %</div>
                                            <div style="margin: 13px 0 16px 0; font-size: 14px;" class="text-danger"
                                                v-else>
                                                {{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                %</div>
                                        </div>
                                    </b-col>

                                </b-row>
                            </b-card-body>
                        </b-card>
                    </app-collapse-item>
                    <app-collapse-item title="Unlocking">
                        <b-card no-body class="mb-1">
                            <b-card-body>
                                <b-row class="">
                                    <b-col md="12" xl="12" v-if="activeData.next_unlock_date">
                                        <div class="d-flex">
                                            <span class="mr-1">Next Unlock Date: </span>
                                            <span style="font-weight:600" class=""
                                                :class="{'blurry-text' :userData.currentPlan =='basic' && activeData.market_cap_rank < 1 ||userData.currentPlan =='basic' && activeData.market_cap_rank >5}">{{dateFormat(activeData.next_unlock_date)}}</span>
                                        </div>
                                    </b-col>
                                    <!-- <b-col md="12" xl="12" v-if="activeData.next_unlock_date_text">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Date Text: </span>
                                                <span class="">{{activeData.next_unlock_date_text}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="12" xl="12" v-if="activeData.next_unlock_percent_of_tokens">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Percent Of Tokens: </span>
                                                <span class="">{{activeData.next_unlock_percent_of_tokens}}
                                                    %</span>
                                            </div>
                                        </b-col>
                                        <b-col md="12" xl="12" v-if="activeData.next_unlock_number_of_tokens">
                                            <div class="d-flex m-2  justify-content-center">
                                                <span class="mr-1">Next Unlock Number Of Tokens: </span>
                                                <span>{{activeData.next_unlock_number_of_tokens}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="12" xl="12" v-if="activeData.next_unlock_size">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Size: </span>
                                                <span class=""> {{activeData.next_unlock_size}}</span>
                                            </div>
                                        </b-col>
                                        <b-col md="12" xl="12" v-if="activeData.next_unlock_Status">
                                            <div class="d-flex m-2 justify-content-center">
                                                <span class="mr-1">Next Unlock Status: </span>
                                                <span class=""> {{activeData.next_unlock_Status}}</span>
                                            </div>
                                        </b-col> -->
                                </b-row>
                            </b-card-body>
                        </b-card>
                    </app-collapse-item>
                    <app-collapse-item title="Description">
                        <b-card no-body class="mb-1">
                            <b-card-body>
                                <b-card-text v-html="activeData.coin_description">
                                </b-card-text>
                            </b-card-body>
                        </b-card>
                    </app-collapse-item>
                </app-collapse>
            </template>
        </b-modal>
        <b-modal id="modal-preset-create" :hide-footer="true" v-if="activeData" centered size="md"
            title="Filter Preset Name:">
            <template>
                <div class="m-3">
                    <b-row>
                        <b-col cols="8">
                            <b-form-input v-model="presetName" />
                        </b-col>
                        <b-col>
                            <b-button size="md" @click="createPresetFilter" v-ripple.400="'rgba(11, 12, 240, 0.15)'"
                                variant="outline-primary" pill>Create
                            </b-button>
                        </b-col>
                    </b-row>
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
        BFormSelectOption,
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
    import AppCollapse from '@core/components/app-collapse/AppCollapse.vue'
    import AppCollapseItem from '@core/components/app-collapse/AppCollapseItem.vue'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import VueSlider from 'vue-slider-component'
    import {
        getUserData
    } from '@/auth/utils'
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
            BOverlay,
            AppCollapse,
            AppCollapseItem,
            BFormSelectOption,
            ToastificationContent,
            VueSlider

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
                locked: false,
                value_2: [0, 50],
                params: {
                    filters: [],
                    filters2: "",
                    sort: ["market_cap", "desc"],
                    api_mode: 1,
                },
                fag: {
                    data: {
                        fear_greed_index: 0,
                        fear_greed_classification: ''
                    }
                },
                selectedContract: null,
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
                userData: null,
                presetName: null,
                presetFilters: [],
                selectedPreset: null,

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
                axios.post('api/get_coins?page=' + this.Cpagpage, JSON.stringify(this.params)).then(res => {
                    if (res.data.data) {
                        this.items = res.data;
                        this.loadedData = true;
                        setTimeout(() => {
                            this.isBusy = false;
                        }, 1000);
                    }

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
            loadPresetFilters() {
                this.isBusy = true;
                this.fagLoad = true;
                axios.post('api/get_preset_filters').then(res => {
                    if (res) {
                        this.presetFilters = res.data;

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
            filterCoins(refresh_flag) {

                this.isBusy = true;
                this.params.filters = [];
                let strArray = [];
                if (this.filterKey.min_market_cap) {
                    this.params.filters.push(["market_cap", ">=", this.filterKey.min_market_cap.replaceAll(",", "")]);
                }
                if (this.filterKey.max_market_cap) {
                    this.params.filters.push(["market_cap", "<=", this.filterKey.max_market_cap.replaceAll(",", "")]);
                }
                if (this.filterKey.min_price_change_percentage_24h) {
                    this.params.filters.push(["price_change_percentage_24h", ">=", this.filterKey
                        .min_price_change_percentage_24h
                    ]);
                }
                if (this.filterKey.max_price_change_percentage_24h) {
                    this.params.filters.push(["price_change_percentage_24h", "<=", this.filterKey
                        .max_price_change_percentage_24h
                    ]);
                }
                if (this.filterKey.coin_platform && this.filterKey.coin_platform != '') {
                    this.params.filters.push(["coin_platform", "like", "%" + this.filterKey.platform + "%"]);
                }
                if (this.filterKey.min_current_price) {
                    this.params.filters.push(["current_price", ">=", this.filterKey.min_current_price]);
                }
                if (this.filterKey.max_current_price) {
                    this.params.filters.push(["current_price", "<=", this.filterKey.max_current_price]);
                }
                if (this.filterKey.min_circulating_supply) {
                    this.params.filters.push(["circulating_supply", ">=", this.filterKey.min_circulating_supply]);
                }
                if (this.filterKey.max_circulating_supply) {
                    this.params.filters.push(["circulating_supply", "<=", this.filterKey.max_circulating_supply]);
                }
                if (this.filterKey.coin_category && this.filterKey.coin_category != '') {
                    this.params.filters.push(["coin_category", "like", "%" + this.filterKey.coin_category + "%"]);
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
                if (this.filterKey.min_trading_volume) {
                    this.params.filters.push(["trading_volume", ">=", this.filterKey.min_trading_volume]);
                }
                if (this.filterKey.max_trading_volume) {
                    this.params.filters.push(["trading_volume", "<=", this.filterKey.max_trading_volume]);
                }

                if (this.filterKey.min_roi_percentage) {
                    this.params.filters.push(["roi_percentage", ">=", this.filterKey.min_roi_percentage]);
                }
                if (this.filterKey.max_roi_percentage) {
                    this.params.filters.push(["roi_percentage", "<=", this.filterKey.max_roi_percentage]);
                }
                if (this.filterKey.min_roi_times) {
                    this.params.filters.push(["roi_times", ">=", this.filterKey.min_roi_times]);
                }
                if (this.filterKey.max_roi_times) {
                    this.params.filters.push(["roi_times", "<=", this.filterKey.max_roi_times]);
                }
                if (this.filterKey.min_genesis_date) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.min_genesis_date));

                    this.params.filters.push(["genesis_date", ">=", d.toISOString().split("T")[0]]);
                }
                if (this.filterKey.max_genesis_date) {
                    var d = new Date();
                    d.setDate(d.getDate() - parseInt(this.filterKey.max_genesis_date));
                    this.params.filters.push(["genesis_date", "<=", d.toISOString().split("T")[0]]);
                }

                if (this.filterKey.min_total_supply_percent) {
                    this.params.filters.push(["total_supply_percent", ">=", this.filterKey.min_total_supply_percent]);
                }

                if (this.filterKey.max_total_supply_percent) {
                    this.params.filters.push(["total_supply_percent", "<=", this.filterKey.max_total_supply_percent]);
                }
                if (this.filterKey.min_seed_price) {
                    this.params.filters.push(["seed_price", ">=", this.filterKey.min_seed_price]);
                }

                if (this.filterKey.max_seed_price) {
                    this.params.filters.push(["seed_price", "<=", this.filterKey.max_seed_price]);
                }
                if (this.filterKey.min_roi_seed) {
                    this.params.filters.push(["roi_seed", ">=", this.filterKey.min_roi_seed]);
                }

                if (this.filterKey.max_roi_seed) {
                    this.params.filters.push(["roi_seed", "<=", this.filterKey.max_roi_seed]);
                }

                //end base filters

                //start social sentiments 

                if (this.filterKey.min_average_sentiment_change) {
                    this.params.filters.push(["average_sentiment_change", ">=", this.filterKey
                        .min_average_sentiment_change
                    ]);
                }

                if (this.filterKey.max_average_sentiment_change) {
                    this.params.filters.push(["average_sentiment_change", "<=", this.filterKey
                        .max_average_sentiment_change
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
                if (this.filterKey.min_average_sentiment) {
                    this.params.filters.push(["average_sentiment", ">=", this.filterKey
                        .min_average_sentiment
                    ]);
                }

                if (this.filterKey.max_average_sentiment) {
                    this.params.filters.push(["average_sentiment", "<=", this.filterKey
                        .max_average_sentiment
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
                if (this.filterKey.min_next_unlock_number_of_tokens) {
                    this.params.filters.push(["next_unlock_number_of_tokens", ">=", this.filterKey
                        .min_next_unlock_number_of_tokens
                    ]);
                }

                if (this.filterKey.max_next_unlock_number_of_tokens) {
                    this.params.filters.push(["next_unlock_number_of_tokens", "<=", this.filterKey
                        .max_next_unlock_number_of_tokens
                    ]);
                }
                if (this.filterKey.min_next_unlock_percent_of_tokens) {
                    this.params.filters.push(["next_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_next_unlock_percent_of_tokens
                    ]);
                }

                if (this.filterKey.max_next_unlock_percent_of_tokens) {
                    this.params.filters.push(["next_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_next_unlock_percent_of_tokens
                    ]);
                }
                if (this.filterKey.next_unlock_size) {
                    this.params.filters.push(["next_unlock_size", "like", "%" + this.filterKey.next_unlock_size + "%"]);
                }
                if (this.filterKey.min_three_months_unlock_number_of_tokens) {
                    this.params.filters.push(["three_months_unlock_number_of_tokens", ">=", this.filterKey
                        .min_three_months_unlock_number_of_tokens
                    ]);
                }

                if (this.filterKey.max_three_months_unlock_number_of_tokens) {
                    this.params.filters.push(["three_months_unlock_number_of_tokens", "<=", this.filterKey
                        .max_three_months_unlock_number_of_tokens
                    ]);
                }
                if (this.filterKey.min_three_months_unlock_percent_of_tokens) {
                    this.params.filters.push(["three_months_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_three_months_unlock_percent_of_tokens
                    ]);
                }

                if (this.filterKey.max_three_months_unlock_percent_of_tokens) {
                    this.params.filters.push(["three_months_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_three_months_unlock_percent_of_tokens
                    ]);
                }
                if (this.filterKey.three_months_unlock_size) {
                    this.params.filters.push(["three_months_unlock_size", "like", "%" + this.filterKey
                        .three_months_unlock_size + "%"
                    ]);
                }
                if (this.filterKey.min_six_months_unlock_number_of_tokens) {
                    this.params.filters.push(["six_months_unlock_number_of_tokens", ">=", this.filterKey
                        .min_six_months_unlock_number_of_tokens
                    ]);
                }
                if (this.filterKey.max_six_months_unlock_number_of_tokens) {
                    this.params.filters.push(["six_months_unlock_number_of_tokens", "<=", this.filterKey
                        .max_six_months_unlock_number_of_tokens
                    ]);
                }
                if (this.filterKey.min_six_months_unlock_percent_of_tokens) {
                    this.params.filters.push(["six_months_unlock_percent_of_tokens", ">=", this.filterKey
                        .min_six_months_unlock_percent_of_tokens
                    ]);
                }
                if (this.filterKey.max_six_months_unlock_percent_of_tokens) {
                    this.params.filters.push(["six_months_unlock_percent_of_tokens", "<=", this.filterKey
                        .max_six_months_unlock_percent_of_tokens
                    ]);
                }
                if (this.filterKey.six_months_unlock_size) {
                    this.params.filters.push(["six_months_unlock_size", "like", "%" + this.filterKey
                        .six_months_unlock_size + "%"
                    ]);
                }
                if (refresh_flag) {
                    this.loadCoins();
                }

            },
            clearFilters(refresh_flag) {
                this.filterKey = {
                    min_market_cap: null,
                    max_market_cap: null,
                    min_price_change_percentage_24h: null,
                    max_price_change_percentage_24h: null,
                    coin_platform: null,
                    min_current_price: null,
                    max_current_price: null,
                    min_circulating_supply: null,
                    max_circulating_supply: null,
                    coin_category: null,
                    max_market_cap_rank: null,
                    min_market_cap_rank: null,
                    market_cap_rank: null,
                    min_total_supply: null,
                    max_total_supply: null,
                    keywords: null,
                    min_trading_volume: null,
                    max_trading_volume: null,
                    min_roi_percentage: null,
                    max_roi_percentage: null,
                    min_roi_times: null,
                    max_roi_times: null,
                    min_genesis_date: null,
                    max_genesis_date: null,
                    min_total_supply_percent: null,
                    max_total_supply_percent: null,
                    min_seed_price: null,
                    max_seed_price: null,
                    min_roi_seed: null,
                    max_roi_seed: null,
                    min_average_sentiment_change: null,
                    max_average_sentiment_change: null,
                    min_social_mentions_change: null,
                    max_social_mentions_change: null,
                    min_social_engagement_change: null,
                    max_social_engagement_change: null,
                    min_average_sentiment: null,
                    max_average_sentiment: null,
                    min_total_locked: null,
                    max_total_locked: null,
                    next_unlock_status: null,
                    min_next_unlock_number_of_tokens: null,
                    max_next_unlock_number_of_tokens: null,
                    min_next_unlock_percent_of_tokens: null,
                    max_next_unlock_percent_of_tokens: null,
                    next_unlock_size: null,
                    min_three_months_unlock_number_of_tokens: null,
                    max_three_months_unlock_number_of_tokens: null,
                    min_three_months_unlock_percent_of_tokens: null,
                    max_three_months_unlock_percent_of_tokens: null,
                    three_months_unlock_size: null,
                    min_six_months_unlock_number_of_tokens: null,
                    max_six_months_unlock_number_of_tokens: null,
                    min_six_months_unlock_percent_of_tokens: null,
                    max_six_months_unlock_percent_of_tokens: null,
                    six_months_unlock_size: null,
                }
                this.params.filters = [];
                this.params.filters2 = '';
                this.params.sort = ["market_cap", "desc"];
                if (refresh_flag) {
                    this.loadCoins();

                }
                this.isBusy = false;
            },
            detailsModel(item) {
                this.selectedContract = null;
                if (typeof item.sparkline_in_7d == 'string') {
                    let sparklines = item.sparkline_in_7d.split("|").map(Number);
                    sparklines = sparklines.slice(0, -1);
                    item.sparkline_in_7d = sparklines;
                }
                if (typeof item.contract_address == 'string') {
                    item.contract_address = JSON.parse(item.contract_address);
                }
                this.activeData = item;
                this.$bvModal.show('modal-details');
            },
            dateFormat(val) {
                if (val) {
                    let d = new Date(val)
                    if (!isNaN(d)) {
                        return d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear();
                    } else {
                        return "********"
                    }
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
            },
            onCopy: function (e) {
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Contract Address Copied',
                        icon: 'CheckCircleIcon',
                        variant: 'success',
                    },
                })
            },
            onError: function (e) {
                this.$toast({
                    component: ToastificationContent,
                    props: {
                        title: 'Contract Address Not Copied',
                        icon: 'XCircleIcon',
                        variant: 'error',
                    },
                })
            },
            kFormatter(num) {
                return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(
                    num) * Math.abs(num)
            },
            lockedFilter() {
                if (this.params.api_mode == 2) {
                    this.params.api_mode = 1;
                    this.locked = false;

                } else {
                    this.locked = true;
                    this.params.api_mode = 2;
                }
                this.loadCoins();
            },
            async createPresetFilter() {
                await this.filterCoins(false);
                let presetPayload = {
                    filters: this.params.filters,
                    filters2: this.params.filters2,
                    filter_name: this.presetName
                }
                if (this.presetName) {
                    axios.post('api/create_preset_filter', JSON.stringify(presetPayload)).then(res => {
                    if (res) {
                        this.presetFilters = res.data;
                        this.selectedPreset = res.data[res.data.length - 1].id;
                        this.presetName = "";
                        this.$bvModal.hide('modal-preset-create');
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Preset has been created',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                    }

                })
                }
           
            },
            deletePreset() {

                axios.post('api/delete_preset_filter', {
                    preset_id: this.selectedPreset
                }).then(res => {
                    if (res) {
                        this.presetFilters = res.data;
                        this.selectedPreset = null;
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Preset has been delete',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                    }

                })
            },
            loadSelectedPresetFilter() {
                this.clearFilters(false);
                let index = this.presetFilters.map(item => item.id).indexOf(this.selectedPreset);
                if (index >= 0) {
                    var preset_json = JSON.parse(this.presetFilters[index].filter_json);
                    preset_json.filters.forEach(element => {
                        let keyval = element[2];
                        if (keyval == "") {
                            keyval = null;
                        }
                        if (element[0] == "coin_platform" || element[0] == "coin_category" || element[0] ==
                            "three_months_unlock_size" || element[0] == "next_unlock_size" || element[0] ==
                            "six_months_unlock_size") {
                            keyval = keyval.replaceAll("%", "");
                            this.filterKey[element[0]] = keyval
                        }
                        if (element[0] == "coin_description") {
                            this.filterKey.keywords = keyval.replaceAll("%", "");
                        } else {
                            if (element[1] && element[1] == '>=') {
                                let keyVal = 'min_' + element[0];
                                this.filterKey[keyVal] = keyval
                            }
                            if (element[1] && element[1] == '<=') {
                                let keyVal = 'max_' + element[0];
                                this.filterKey[keyVal] = keyval
                            }
                            if (element[1] && element[1] == '=') {
                                let keyVal = element[0];
                                this.filterKey[keyVal] = keyval
                            }
                        }

                    });

                }

            }

        },
        computed: {
            visibleFields() {
                if (this.params.api_mode == 1) {
                    return this.fields.filter(field => {
                        return field.visible == 1 || field.visible == 3
                    })
                } else {
                    return this.fields.filter(field => {
                        return field.visible == 3 || field.visible == 2;
                    })
                }
            },

        },
        mounted() {
            this.loadCoins();
            this.loadFag();
            this.loadPresetFilters();
        },
        created() {
            this.userData = getUserData()
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

            },
            'selectedPreset': function (n, o) {
                this.loadSelectedPresetFilter();

            }
        }
    }

</script>
<style>
    #dashboard .nameWidth {
        width: 55px !important;
    }

    #dashboard .full {
        width: 100%
    }

    #dashboard .customBadge {
        font-size: 11px;
        padding: 2px;
        border-radius: 5px;
    }

    #dashboard .b-table-sticky-header {
        overflow-y: auto;
        max-height: 80vh;
    }

    #dashboard td {
        text-align: center;
    }

    #dashboard .inner-text {
        height: 100%;
        width: 100%;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    #dashboard table td {
        padding-left: 4px !important;
        padding-right: 4px !important;
        font-size: 14px;
        font-family: 'Poppins'

    }

    #dashboard table th {
        padding-left: 4px !important;
        padding-right: 4px !important;
        font-size: 12px !important;
        font-family: 'Poppins' !important
    }

    #dashboard .b-avatar {
        width: 30px;
        height: 30px;
        margin: auto;
    }

    #modal-details___BV_modal_title_ {
        width: 100%;
    }

    @media only screen and (max-width: 500px) {
        .min-block {
            display: block !important;
        }
    }

    .sparlineChat svg {
        height: 100%;
        width: 100%
    }

    .soicalLable {
        font-size: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40px;
        margin: auto;
    }

    .blurry-text {
        text-shadow: 0 0 32px white;
        color: transparent;
    }

    .blurry-text {
        text-shadow: 0px -2px 5px #d13e3e;
    }

</style>
