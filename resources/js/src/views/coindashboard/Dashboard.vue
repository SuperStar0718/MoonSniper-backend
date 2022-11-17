<template>
    <div id="dashboard">
        <b-overlay :show="fagLoad" rounded="sm" class="pt-1 DashboardHeader" style="">
            <div class="mx-auto topbarDiv" style="">
                <b-row class="HeaderTopBar">
                    <b-col md="3" sm="6" xl="3">
                        <div class="d-flex mx-auto justify-content-center">
                            <div class="greyLetter" style="margin-right:8px;">MC:</div>
                            <div class="whiteLetter" v-if="loaded">{{fag.data.market_cap?fag.data.market_cap:'-'}}</div>
                            <div style="" class="TriangleIcon">
                                <i class="bi bi-triangle-fill" style="color:#6BBE83;"></i>
                            </div>
                            <div style="color:#6BBE83;">
                                4.4%
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3" sm="6" xl="3" class="mb-1">
                        <div class="d-flex mx-auto justify-content-center">
                            <div class="greyLetter" style="margin-right:8px;">Vol(24):</div>
                            <div class="whiteLetter" v-if="loaded"> {{fag.data.vol_24h?fag.data.vol_24h:'-'}}</div>
                            <div style="" class="TriangleIcon">
                                <i class="bi bi-triangle-fill" style="color:#6BBE83;"></i>
                            </div>
                            <div style="color:#6BBE83;">
                                5%
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3" sm="6" xl="3" class="mb-1">
                        <div class="d-flex mx-auto justify-content-center">
                            <div class="greyLetter Dominance" style="margin-right:8px;">Dominance:</div>
                            <div class="d-flex justify-content-between whiteLetter" v-if="loaded">
                                <div style="margin:0 8px 0 8px"> {{fag.data.btc_dom}}
                                </div>
                                <div style="margin:0 8px 0 8px">{{fag.data.eth_dom}}</div>
                            </div>

                        </div>

                    </b-col>
                    <b-col md="3" sm="6" xl="3" class="mb-1">
                        <div class="d-flex mx-auto justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                                class="bi bi-fuel-pump-diesel" viewBox="0 0 16 16">
                                <path
                                    d="M3.5 2a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-5ZM4 14V9h1.796c.5 0 .913.098 1.237.293.325.195.567.479.725.85.161.371.242.82.242 1.344 0 .528-.08.98-.242 1.355a1.805 1.805 0 0 1-.732.861c-.324.198-.734.297-1.23.297H4Zm1.666-4.194h-.692v3.385h.692c.229 0 .427-.035.595-.103a.986.986 0 0 0 .412-.315c.108-.142.188-.318.241-.528.056-.21.083-.456.083-.74 0-.376-.048-.69-.144-.94a1.11 1.11 0 0 0-.436-.569c-.195-.127-.445-.19-.75-.19Z" />
                                <path
                                    d="M3 0a2 2 0 0 0-2 2v13H.5a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1H11v-4a1 1 0 0 1 1 1v.5a1.5 1.5 0 0 0 3 0V8h.5a.5.5 0 0 0 .5-.5V4.324c0-.616 0-1.426-.294-2.081a1.969 1.969 0 0 0-.794-.907C14.534 1.111 14.064 1 13.5 1a.5.5 0 0 0 0 1c.436 0 .716.086.9.195a.97.97 0 0 1 .394.458c.147.328.19.746.201 1.222H13.5a.5.5 0 0 0-.5.5V7.5a.5.5 0 0 0 .5.5h.5v4.5a.5.5 0 0 1-1 0V12a2 2 0 0 0-2-2V2a2 2 0 0 0-2-2H3Zm7 2v13H2V2a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1Z" />
                            </svg>
                            <div class="greyLetter" style="margin-right:8px; margin-left:8px;">ETH Gas:</div>
                            <div class="d-flex justify-content-between">
                                <div style="margin:0 8px 0 8px" class="whiteLetter" v-if="loaded">
                                    {{fag.data.eth_gas?fag.data.eth_gas:'-'}}
                                </div>

                            </div>

                        </div>

                    </b-col>

                </b-row>
            </div>
            <!-- graph -->
            <b-row class="FGCharts" style="">
                <b-col sm="3" md="3" cols="6" v-if="mi_fear_greed">
                    <div class="mx-auto w-75 text-center">
                        <h5 class="w-75 mx-auto margin16_b feerTitle">Fear and Greed</h5>
                        <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                            :inner-radius="96.5" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                            :max="50"
                            :gauge-color="[{offset: 0, color: '#232632'}, { offset: 17, color: '#F6573E'}, { offset: 25, color: '#FD7941'}, { offset: 50, color: '#E7D45D'}, { offset: 75, color: '#7DD75F'}, { offset: 100, color: '#51D868'}]"
                            :scale-interval="0" :transition-duration="0">
                            <div class="rounded-circle" id="marker_0" style="width:8px; height:8px; position: absolute">
                            </div>
                            <div class="inner-text" style="display:block;">
                                <div style="margin-top: 2rem !important;"
                                    :class="{'text-danger':fag.data.fear_greed_index<50,'text-success-green':fag.data.fear_greed_index>=50}">
                                    <span class="d-block feerGreen">{{fag.data.fear_greed_index}}</span>
                                </div>
                                <div class="row" style="margin: 0% 0% 0% 0%;">
                                    <span class="col-3 text-info my-auto" style="float:left;"><a v-b-modal.modal-chart
                                            variant="outline-primary"><i class="bi bi-clock-history darkWhiteText"
                                                style="color:#28c76f;"></i></a>
                                    </span>
                                    <span class="col-6 feerSmallGreen" style="text-align:center;">
                                        {{fag.data.fear_greed_classification}}
                                    </span>
                                    <span class="col-3">

                                    </span>
                                </div>

                            </div>

                        </VueSvgGauge>
                    </div>
                </b-col>
                <b-col sm="3" md="3" cols="6" v-if="mi_fear_nft">
                    <div class="mx-auto w-75 text-center">
                        <h5 class="w-75 mx-auto margin16_b feerTitle">NFT Barometer</h5>
                        <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                            :inner-radius="96.5" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                            :max="50"
                            :gauge-color="[{offset: 0, color: '#232632'}, { offset: 17, color: '#F6573E'}, { offset: 25, color: '#FD7941'}, { offset: 50, color: '#E7D45D'}, { offset: 75, color: '#7DD75F'}, { offset: 100, color: '#51D868'}]"
                            :scale-interval="0" :transition-duration="0">
                            <div class="rounded-circle" id="marker_1" style="width:8px; height:8px; position: absolute">
                            </div>

                            <div class="inner-text" style="display:block;">
                                <div style="margin-top: 2rem !important;"
                                    :class="{'text-danger':fag.data.fear_greed_index<50,'text-success-green':fag.data.fear_greed_index>=50}">
                                    <span class="d-block feerGreen">{{fag.data.fear_greed_index}}</span>
                                </div>
                                <div class="row" style="margin: 0% 0% 0% 0%;">
                                    <span class="col-3 text-info" style="float:left; margin:auto;"><a
                                            v-b-modal.modal-chart variant="outline-primary"><i
                                                class="bi bi-clock-history darkWhiteText"
                                                style="color:#28c76f;"></i></a>
                                    </span>
                                    <span class="col-6 feerSmallGreen" style="text-align:center;">
                                        {{fag.data.fear_greed_classification}}
                                    </span>
                                    <span class="col-3">

                                    </span>
                                </div>

                            </div>
                        </VueSvgGauge>
                    </div>
                </b-col>
                <b-col sm="3" md="3" cols="6" v-if="mi_fear_btc_in_out">
                    <div class="mx-auto w-75 text-center">
                        <h5 class="w-75 mx-auto margin16_b feerTitle">BTC in/outflow</h5>
                        <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                            :inner-radius="96.5" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                            :max="50"
                            :gauge-color="[{offset: 0, color: '#232632'}, { offset: 17, color: '#F6573E'}, { offset: 25, color: '#FD7941'}, { offset: 50, color: '#E7D45D'}, { offset: 75, color: '#7DD75F'}, { offset: 100, color: '#51D868'}]"
                            :scale-interval="0" :transition-duration="0">
                            <div class="rounded-circle" id="marker_2" style="width:8px; height:8px; position: absolute">
                            </div>
                            <div class="inner-text" style="display:block;">
                                <div style="margin-top: 2rem !important;"
                                    :class="{'text-danger':fag.data.fear_greed_index<50,'text-success-green':fag.data.fear_greed_index>=50}">
                                    <span class="d-block feerGreen">{{fag.data.fear_greed_index}}</span>
                                </div>
                                <div class="row" style="margin: 0% 0% 0% 0%;">
                                    <span class="col-3 text-info" style="float:left; margin:auto;"><a
                                            v-b-modal.modal-chart variant="outline-primary"><i
                                                class="bi bi-clock-history darkWhiteText"
                                                style="color:#28c76f;"></i></a>
                                    </span>
                                    <span class="col-6 feerSmallGreen" style="text-align:center;">
                                        {{fag.data.fear_greed_classification}}
                                    </span>
                                    <span class="col-3">

                                    </span>
                                </div>

                            </div>
                        </VueSvgGauge>
                    </div>
                </b-col>
                <b-col sm="3" md="3" cols="6" v-if="mi_fear_btc_alt">
                    <div class="mx-auto w-75 text-center">
                        <h5 class="w-75 mx-auto margin16_b feerTitle">BTC Outflow</h5>
                        <VueSvgGauge width="60%" class="w-75 mx-auto" :start-angle="-90" :end-angle="90"
                            :inner-radius="96.5" :value="fag.data.fear_greed_index" :separator-step="0" :min="0"
                            :max="50"
                            :gauge-color="[{offset: 0, color: '#232632'}, { offset: 17, color: '#F6573E'},  { offset: 25, color: '#FD7941'}, { offset: 50, color: '#E7D45D'}, { offset: 75, color: '#7DD75F'}, { offset: 100, color: '#51D868'}]"
                            :scale-interval="0" :transition-duration="0">
                            <div class="rounded-circle" id="marker_3" style="width:8px; height:8px; position: absolute">
                            </div>
                            <div class="inner-text" style="display:block;">
                                <div style="margin-top: 2rem !important;"
                                    :class="{'text-danger':fag.data.fear_greed_index<50,'text-success-green':fag.data.fear_greed_index>=50}">
                                    <span class="d-block feerGreen">{{fag.data.fear_greed_index}}</span>
                                </div>
                                <div class="row" style="margin: 0% 0% 0% 0%;">
                                    <span class="col-3 text-info" style="float:left; margin:auto;"><a
                                            v-b-modal.modal-chart variant="outline-primary"><i
                                                class="bi bi-clock-history darkWhiteText"
                                                style="color:#28c76f;"></i></a>
                                    </span>
                                    <span class="col-6 feerSmallGreen" style="text-align:center;">
                                        {{fag.data.fear_greed_classification}}
                                    </span>
                                    <span class="col-3">

                                    </span>
                                </div>

                            </div>
                        </VueSvgGauge>
                    </div>
                </b-col>
            </b-row>
            <!-- end- graph -->
        </b-overlay>
        <div class="body-content-overlay" />
        <!-- search bar and table -->
        <div class="cardBack" style="">
            <div class="searchbar ">
                <b-row>
                    <b-col cols="8" md="6" xl="6">
                        <b-input-group class="input-group-merge SearchInputGroup">
                            <b-form-input v-model="params.filters2" placeholder="Search"
                                class="search-product searchdark" style="border-radius: 20px;" />

                        </b-input-group>
                    </b-col>
                    <b-col cols="4" md="2" xl="4">
                    </b-col>
                    <b-col cols="12" md="4" xl="2">
                        <div class="d-flex jusctify-content-between float-right">

                            <div >
                                <b-button  v-if="favoritised"  style="padding:5px; color:white;"  
                                    v-ripple.400="'rgba(255, 255, 255,1)'" title="My Favorites" variant="flat-success"
                                    class="btn-icon mr-1">
                                    <i
                                            class="fa-solid fa-star" style="font-size:20px; color:#fc6" @click="disableFavorites()"
                                           ></i>
                                           
                                        
                                </b-button>
                                <b-button   v-if="!favoritised" style="padding:5px; color:white;"  
                                    v-ripple.400="'rgba(255, 255, 255,1)'" title="My Favorites" variant="flat-success"
                                    class="btn-icon mr-1">

                                        <i  class="fa-regular fa-star " style="font-size:20px" 
                                             @click="enableFavorites()"></i>
                                </b-button>
                            </div>
                            <div v-b-modal.modal-filters>
                                <b-button style="padding:5px; color:white;" :class="{'bg-danger text-danger':filtered}"
                                    v-ripple.400="'rgba(255, 255, 255,1)'" title="Filter" variant="flat-success"
                                    class="btn-icon mr-1">
                                    <feather-icon icon="FilterIcon" size="20"
                                        class="text-black cursor-pointer darkWhiteText" style="color:#28c76f; " />
                                </b-button>
                            </div>
                            <div>
                                <b-button v-if="!locked" @click="lockedFilter"
                                    style="color:white; padding:5px; width:33px" variant="flat-success"
                                    title="Unlocking" v-ripple.400="'rgba(255, 255, 255,1)'" class="btn-icon mr-1 ">
                                    <feather-icon icon="UnlockIcon" size="20"
                                        class="text-black cursor-pointer darkWhiteText" style="color:#28c76f; " />

                                </b-button>
                                <b-button v-else @click="lockedFilter" style="color:white; padding:5px; width:33px"
                                    title="All Tokens" variant="flat-success" v-ripple.400="'rgba(255, 255, 255,1)'"
                                    class="btn-icon mr-1 ">

                                    <b-img class=" cursor-pointer rounded-full" width="25px" height="25px" fluid
                                        src="/images/static/noun-cryptocurrency-3262833.svg" />
                                </b-button>

                            </div>

                            <div @click="clearFilters(true)">
                                <b-button style="padding:5px; " v-ripple.400="'rgba(255, 255, 255,1)'" title="Refresh"
                                    variant="flat-success" class="btn-icon ml-1">
                                    <feather-icon icon="RefreshCcwIcon" size="20"
                                        class="text-black cursor-pointer darkWhiteText" style="color:#28c76f;" />
                                </b-button>

                            </div>
                            <div class="ml-1" style="padding:5px; color:white;">

                                <b-dropdown size="lg" variant="flat-dark"
                                    style="padding:0px !important; color: white !important;" class="cunningBtn"
                                    id="dropdown-left" no-caret dropright>
                                    <template #button-content>
                                        <feather-icon icon="SlidersIcon" size="20"
                                            class=" text-black cursor-pointer darkWhiteText"
                                            style="color:#28c76f;rotate:-90deg" />
                                    </template>
                                    <b-dropdown-form href="#" class="dropdown-mine">
                                        <div style="font-family: 'Poppins-Light';
                                                font-style: normal;
                                                font-weight: 500;
                                                font-size: 18px;margin-bottom: 20px; margin-top: 20px;"
                                            class="text-center darkWhiteText">
                                            Customise your Dashboard
                                        </div>
                                        <hr style="margin:0px !important;" v-if="params.api_mode == 1">
                                        <template>
                                            <div class="accordion" role="tablist" v-if="params.api_mode == 1">
                                                <app-collapse accordion>
                                                    <app-collapse-item :isVisible="true" title="Market Filters">
                                                        <b-row>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[5].filterColumn"
                                                                        name="cursor-pointer some-checkboxs">
                                                                        Market Cap
                                                                    </b-form-checkbox>
                                                                </div>

                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        name="cursor-pointer some-checkboxs1"
                                                                        v-model="fields[2].filterColumn">
                                                                        Coin Price
                                                                    </b-form-checkbox>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">

                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[0].filterColumn"
                                                                        name="cursor-pointer some-checkboxs2">
                                                                        Rank
                                                                    </b-form-checkbox>

                                                                </div>
                                                            </b-col>
                                                            <!-- <b-col md="6" xl="6">
                                                                <div class="margin20">

                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[1].filterColumn"
                                                                        name="cursor-pointer some-checkboxs2">
                                                                        Name
                                                                    </b-form-checkbox>

                                                                </div>
                                                            </b-col> -->
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[3].filterColumn"
                                                                            name="cursor-pointer some-checkboxs3">

                                                                            Daily Price Change
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>

                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[4].filterColumn"
                                                                            name="cursor-pointer some-checkboxs3">

                                                                            7D %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[8].filterColumn"
                                                                            name="cursor-pointer some-checkboxs3">
                                                                            VOL(24h)
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[17].filterColumn"
                                                                            name="cursor-pointer some-checkboxs4">

                                                                            Circulating Supply
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <!-- <b-col md="6" xl="6"> NotAvail
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"  v-model="fields[2].filterColumn" name="cursor-pointer some-checkboxs5" >
                                                                            Circulating Supply %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col> -->
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[16].filterColumn"
                                                                            name="cursor-pointer some-checkboxs6">
                                                                            Total Supply
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[15].filterColumn"
                                                                            name="cursor-pointer some-checkboxs7">
                                                                            ROI %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[13].filterColumn"
                                                                            name="cursor-pointer some-checkboxs8">
                                                                            ROI in X's
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[14].filterColumn"
                                                                            name="cursor-pointer some-checkboxs9">
                                                                            Category
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <!-- <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"  v-model="fields[2].filterColumn" name="cursor-pointer some-checkboxs10" >
                                                                            
                                                                            Network
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col> -->
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[18].filterColumn"
                                                                            name="cursor-pointer some-checkboxs11">

                                                                            Public Price
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <!-- <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"  v-model="fields[2].filterColumn" name="cursor-pointer some-checkboxs12" >
                                                                            Days in Market
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col> -->
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[6].filterColumn"
                                                                            name="cursor-pointer some-checkboxs13">
                                                                            Description
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>


                                                        </b-row>
                                                    </app-collapse-item>


                                                </app-collapse>

                                            </div>
                                            <hr style="margin:0px !important;" v-if="params.api_mode == 1">
                                            <div class="accordion" role="tablist" v-if="params.api_mode == 1">
                                                <app-collapse accordion>
                                                    <app-collapse-item :isVisible="true" title="SociaL Filters">
                                                        <b-row>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[35].filterColumn"
                                                                        name="cursor-pointer some-checkboxsaa">
                                                                        Social Engagement Change %
                                                                    </b-form-checkbox>
                                                                </div>

                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[34].filterColumn"
                                                                        name="cursor-pointer some-checkboxs1a">

                                                                        Social Mentions Change %
                                                                    </b-form-checkbox>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">

                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[36].filterColumn"
                                                                        name="cursor-pointer some-checkboxs2b">

                                                                        Average Sentiment (1-5)
                                                                    </b-form-checkbox>

                                                                </div>
                                                            </b-col>



                                                        </b-row>
                                                    </app-collapse-item>


                                                </app-collapse>

                                            </div>
                                            <hr style="margin:0px !important;">
                                            <div class="accordion" role="tablist">
                                                <app-collapse accordion>
                                                    <app-collapse-item :isVisible="true" title="Unlocking Filter">
                                                        <b-row>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[20].filterColumn"
                                                                        name="cursor-pointer some-checkboxsc">
                                                                        Total Locked
                                                                    </b-form-checkbox>
                                                                </div>

                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[22].filterColumn"
                                                                        name="cursor-pointer some-checkboxs1c">
                                                                        Unlock Status
                                                                    </b-form-checkbox>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">

                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="fields[25].filterColumn"
                                                                        name="cursor-pointer some-checkboxs2c">
                                                                        Next Unlock Size
                                                                    </b-form-checkbox>

                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[24].filterColumn"
                                                                            name="cursor-pointer some-checkboxs3c">

                                                                            Next Unlock %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[33].filterColumn"
                                                                            name="cursor-pointer some-checkboxs4c">

                                                                            6 Months Unlock Size
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[30].filterColumn"
                                                                            name="cursor-pointer some-checkboxs5c">
                                                                            3 Months Unlock Size
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[29].filterColumn"
                                                                            name="cursor-pointer some-checkboxs6c">
                                                                            3 Months Unlock %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[32].filterColumn"
                                                                            name="cursor-pointer some-checkboxs7c">
                                                                            6 Months Unlock %
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[23].filterColumn"
                                                                            name="cursor-pointer some-checkboxs8c">

                                                                            Next Unlock # of Tokens
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[21].filterColumn"
                                                                            name="cursor-pointer some-checkboxs9">
                                                                            Next Unlock Date
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[26].filterColumn"
                                                                            name="cursor-pointer some-checkboxs9">
                                                                            First VC Unlock
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[27].filterColumn"
                                                                            name="cursor-pointer some-checkboxs9">
                                                                            End VC Unlock
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[31].filterColumn"
                                                                            name="cursor-pointer some-checkboxs9">
                                                                            6 Months Unlock # of Tokens
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="12" xl="12">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="fields[28].filterColumn"
                                                                            name="cursor-pointer some-checkboxs10">

                                                                            3 Months Unlock # of Tokens
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                        </b-row>
                                                    </app-collapse-item>


                                                </app-collapse>

                                            </div>
                                            <hr style="margin:0px !important;" v-if="params.api_mode == 1">
                                            <div class="accordion" role="tablist" v-if="params.api_mode == 1">
                                                <app-collapse accordion>
                                                    <app-collapse-item :isVisible="true" title="Market Indicators">
                                                        <b-row>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="mi_fear_greed"
                                                                        name="cursor-pointer some-checkboxsd">
                                                                        Fear & Greed
                                                                    </b-form-checkbox>
                                                                </div>

                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="mi_fear_nft"
                                                                        name="cursor-pointer some-checkboxs1d">
                                                                        NFT Barometer
                                                                    </b-form-checkbox>
                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">

                                                                    <b-form-checkbox @change="updateFields"
                                                                        v-model="mi_fear_btc_in_out"
                                                                        name="cursor-pointer some-checkboxs2d">
                                                                        Btc Inflow/Outflow
                                                                    </b-form-checkbox>

                                                                </div>
                                                            </b-col>
                                                            <b-col md="6" xl="6">
                                                                <div class="margin20">
                                                                    <div class="">
                                                                        <b-form-checkbox @change="updateFields"
                                                                            v-model="mi_fear_btc_alt"
                                                                            name="cursor-pointer some-checkboxs3d">

                                                                            Btc/Alt Season
                                                                        </b-form-checkbox>
                                                                    </div>
                                                                </div>
                                                            </b-col>
                                                        </b-row>
                                                    </app-collapse-item>


                                                </app-collapse>

                                            </div>
                                        </template>
                                    </b-dropdown-form>

                                </b-dropdown>

                            </div>


                        </div>
                    </b-col>
                </b-row>

            </div>
            <div id="ctable" style="position: relative;">
                <div class="opacityGradient" style="position: absolute;right: 4px; top: 0px;height: 100%;width: 61px;z-index: 3;
                        background: linear-gradient(90deg, rgba(248,248,248, 0) 0%, rgba(248,248,248, 1) 100%);">

                </div>
                <b-overlay :show="isBusy" rounded="sm">

                    <b-table :no-border-collapse="true" tbody-tr-class="cursor-pointer box rounded-pill "
                        :show-empty="showEmpty" :busy="isBusy" :empty-text="emptyText"  class="b-table-1" @row-clicked="detailsModel($event)"
                        style=" white-space: nowrap;" responsive :items="items.data" :fields="visibleFields">
                        <template #table-busy>

                        </template>
                        <!-- <template #table-colgroup="scope">
                            <col
                              v-for="field in scope.fields"
                              :key="field.key"
                              :style="{ width: field.key === 'empty'?'-' : '250px' }"
                            > <col>
                          </template> -->
                        <template #empty="scope">
                            <h4>{{ scope.emptyText }}</h4>
                        </template>

                        <template #head()="scope">
                            <div class="text-nowrap cursor-pointer text-center" style=""
                                @click="sortingCols(scope.field.key)">
                                <div v-if="scope.label" class="d-flex justify-content-center text-capitalize">
                                    <span> {{ scope.label }} </span>
                                    <span class="my-auto d-inline">
                                        <feather-icon icon="TriangleIcon" size="8"
                                            style="rotate:180deg;margin-left: 5px; margin-top: -9px; "
                                            :class="{'text-danger':params.sort[1] =='asc'&& params.sort[0] ==scope.field.key}" />
                                        <!-- <feather-icon icon="ChevronDownIcon" size="8"
                                            :class="{'text-danger':params.sort[1] =='desc'&& params.sort[0] ==scope.field.key}"
                                            class="align-middle d-block" />  -->
                                    </span>
                                </div>
                            </div>
                        </template>

                        <template #cell(coin_platform)="data">
                            <div class="" v-html="getPlatformTags(data.value)"></div>
                            <div class="" v-ripple.400="'rgba(113, 102, 240, 0.15)'" variant="outline-success"
                                v-if="checkSeemore(data.value)"
                                v-b-tooltip.hover.bottom="platformTagsSeemore(data.value)">
                                <span>
                                    <small class="text-sm"> See more...</small>
                                </span></div>

                        </template>
                        <template #cell(market_cap_rank)="data">
                            <div class="d-flex justify-center" style="justify-content: center !important;">
                                <div class="d-flex c">
                                    <div class="mx-1">
                                        <feather-icon icon="StarIcon" size="22" />
                                    </div>
                                    <div style="padding-top:3px">{{ toInterNationalNumber(data.value?data.value:0) }}
                                    </div>
                                </div>
                            </div>
                        </template>

                        <template #cell(coin_description)="data">
                            <div class="d-flex text-center" v-if="data.value" v-html="data.value.substring(0,20)">

                            </div>
                        </template>

                        <template #cell(name)="data">
                            <div class="d-flex justify-content-start ml-2">
                                <div class="d-flex c" v-if="fields[0].filterColumn">
                                    <div class="m-auto">
                                        <i v-if="checkFavoriteList(data.index,data.item.coin_id,data.item.symbol)"
                                            class="fa-solid fa-star" style="font-size:20px; color:#fc6"
                                            @click.stop.prevent="manageFavorite(data.index,data.item.coin_id,data.item.symbol,data.item.name)"></i>

                                        <i v-else class="fa-regular fa-star " style="font-size:20px"
                                            @click.stop.prevent="manageFavorite(data.index,data.item.coin_id,data.item.symbol,data.item.name)"></i>
                                        <!-- <feather-icon icon="StarIcon" size="22" /> -->
                                    </div>
                                    <div style="padding-top:3px" class="my-auto mx-1">
                                        {{ toInterNationalNumber(data.item.market_cap_rank?data.item.market_cap_rank:0) }}
                                    </div>
                                </div>
                                <div style="text-align: center;" class="d-flex justify-content-center">

                                    <div style="" class="my-auto">
                                        <b-avatar class="text-center mr-1" :src="data.item.image" />
                                    </div>
                                    <div class="" v-b-tooltip.hover.bottom="data.value">

                                        <div class="text-nowrap text-truncate"
                                            style="float: left; max-width: 100px; font-weight: 600;">
                                            <b>{{ data.value }}</b>
                                        </div>
                                        <br />
                                        <div class="text-nowrap text-truncate text-left"
                                            style="float: left; max-width: 100px; width: 100px;  opacity: 0.8;">
                                            {{ data.item.symbol }}
                                        </div>


                                    </div>

                                    <div class="btn-primary my-auto" style="display:inline-block;  float: right; padding: 2px 12px 2px 12px;
                                        font-family: 'Poppins'; height: 21px; margin-right: auto;
                                        font-style: normal; border-radius: 16px !important; 
                                        font-weight: 400;
                                        font-size: 11px;">
                                        Buy

                                    </div>

                                </div>
                            </div>
                        </template>


                        <!-- buy button -->
                        <!-- <template #cell()="scope">
                                <div style="text-align: center;" class="d-flex justify-content-start">
                                        <b-button
                                            v-ripple.400="'rgba(30, 30, 30, 0.15)'"
                                            variant="outline-dark"
                                            style="background-color: white; color:black;"
                                            pill
                                            >
                                            Buy
                                        </b-button>
                                </div>
                            </template> -->
                        <!-- end of button -->
                        <template #cell(seed_price)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;" class="">

                                {{twenty4HConversation(data.value)}} <span v-if="data.value">$</span>
                            </div>
                        </template>
                        <template #cell(roi_seed)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex justify-content-start">
                                {{twenty4HConversation(data.value)}} <span v-if="data.value">X</span>
                            </div>
                        </template>
                        <template #cell(total_locked)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                {{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(next_unlock_date_text)="data">
                            <div v-if="data.value" style="text-align: center;" class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{data.value}}
                                <!-- <div v-if="data.item.next_unlock_date">
                                    <vac :end-time="getTimeStamp(data.item.next_unlock_date)">
                                        <template v-slot:process="{ timeObj }">
                                            <span>{{ `${timeObj.d}d - ${timeObj.h} : ${timeObj.m} : ${timeObj.s}` }}</span>
                                        </template>
                                        <template v-slot:finish>
                                            <span></span>
                                        </template>
                                    </vac>
                                </div> -->
                            </div>
                            <div v-else-if="data.item.next_unlock_date" style="text-align: center;"
                                class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{dateFormat3(data.item.next_unlock_date)}}
                                <br />
                                <vac :end-time="getTimeStamp(data.item.next_unlock_date)">
                                    <template v-slot:process="{ timeObj }">
                                        <span>{{ `${timeObj.d}d - ${timeObj.h} : ${timeObj.m} : ${timeObj.s}` }}</span>
                                    </template>
                                    <template v-slot:finish>
                                        <span></span>
                                    </template>
                                </vac>
                            </div>
                        </template>
                        <template #cell(next_unlock_status)="data">
                            <div style="text-align: center;" class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{ data.value }}
                            </div>
                        </template>
                        <template #cell(next_unlock_number_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                {{twenty4HConversation(data.value)}}
                            </div>

                        </template>
                        <template #cell(circulating_supply)="data">
                            <div v-if="data.value" style="text-align: center;" class="">
                                {{twenty4HConversation(data.value)}}
                            </div>

                        </template>
                        <template #cell(coin_category)="data">
                            <div v-if="data.value" style="text-align: center;" class="">
                                <span>{{data.value}}</span>
                            </div>

                        </template>
                        <template #cell(next_unlock_percent_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                {{twenty4HConversation(data.value)}} <span v-if="data.value"> %</span>
                            </div>
                        </template>
                        <template #cell(next_unlock_size)="data">
                            <div style="text-align: center;" class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{ data.value }}
                            </div>
                        </template>
                        <template #cell(roi_times)="data">
                            <div style="text-align: center;" class="">
                                {{ toInterNationalNumber(data.value) }} <span v-if="data.value">X</span>
                            </div>
                        </template>
                        <template #cell(first_vc_unlock)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else style="text-align: center;" class="d-flex2 justify-content-start">
                                {{dateFormat2(data.value)}}
                            </div>
                        </template>

                        <template #cell(end_vc_unlock)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else style="text-align: center;" class="d-flex2 justify-content-start">
                                {{dateFormat2(data.value)}}
                            </div>
                        </template>
                        <template #cell(three_months_unlock_number_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                {{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(three_months_unlock_percent_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                {{twenty4HConversation(data.value)}}<span v-if="data.value">%</span>
                            </div>
                        </template>
                        <template #cell(three_months_unlock_size)="data">
                            <div style="text-align: center;" class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{ data.value }}
                            </div>
                        </template>

                        <template #cell(six_months_unlock_number_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                <span v-if="data.value">$</span>{{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(six_months_unlock_percent_of_tokens)="data">
                            <div v-if="checkUserPlan(data.item.market_cap_rank)" style="text-align: center;"
                                class="d-flex2 justify-content-start blurry-text">
                                {{data.value}}
                            </div>
                            <div v-else-if="data.value" style="text-align: center;"
                                class="d-flex2 justify-content-start">
                                <span v-if="data.value">$</span>{{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(six_months_unlock_size)="data">
                            <div style="text-align: center;" class="d-flex2 justify-content-start"
                                :class="{'blurry-text' : checkUserPlan(data.item.market_cap_rank)}">
                                {{ data.value }}
                            </div>
                        </template>

                        <template #cell(current_price)="data">
                            <div v-if="data.value" class="text-center m-auto"
                                :class="{ 'redFlash1': data.item.price_change_percentage_24h < 0,'greenFlash1': data.item.price_change_percentage_24h >= 0 ,'greenFlash':data.item.flash == 1,'redFlash ':data.item.flash ==2,'whiteFlash':data.item.flash ==3  }"
                                style="width: 100px;">
                                ${{priceConversation(data.value)}}</div>
                        </template>
                        <template #cell(market_cap)="data">
                            <div v-if="data.value" class="text-center mx-2" style="">
                                ${{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(high_24h)="data">
                            <div v-if="data.value && data.value !=''" class="text-center" style="">
                                ${{twenty4HConversation(data.value)}}
                            </div>
                        </template>
                        <template #cell(low_24h)="data">
                            <div v-if="data.value &&  data.value !=''" class="text-center m-auto" style="">
                                ${{twenty4HConversation(data.value)}}
                            </div>
                        </template>

                        <template #cell(price_change_percentage_24h)="data">
                            <div v-if="data.value">
                                <span v-if="data.value>= 0" class="text-success-green"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else class="text-danger" style="">{{ twenty4HConversation(data.value) }}
                                    %</span>
                            </div>
                        </template>
                        <template #cell(price_change_percentage_7d_in_currency)="data">
                            <div v-if="data.value">
                                <span v-if="data.value>= 0" class="text-success-green"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else class="text-danger" style="">{{ twenty4HConversation(data.value) }}
                                    %</span>
                            </div>
                        </template>
                        <template #cell(roi_percentage)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success-green"
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else-if="data.value" class="text-danger"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span></div>
                        </template>
                        <template #cell(total_supply_percent)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success-green"
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else-if="data.value" class="text-danger"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span></div>
                        </template>
                        <template #cell(ath)="data">
                            <div v-if="data.value">
                                <span style=""><span v-if="data.value">$</span>{{twenty4HConversation(data.value)}}
                                </span>
                            </div>
                        </template>
                        <template #cell(atl)="data">
                            <div v-if="data.value">
                                <span style=""><span
                                        v-if="data.value">$</span>{{twenty4HConversation(data.value)}}</span>
                            </div>
                        </template>
                        <template #cell(social_mentions_change)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success-green"
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else-if="data.value!=null" class="text-danger"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span></div>
                        </template>
                        <template #cell(social_engagement_change)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success-green"
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else-if="data.value!=null" class="text-danger"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span></div>
                        </template>
                        <template #cell(average_sentiment_change)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class="text-success-green"
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span>
                                <span v-else-if="data.value!=null" class="text-danger"
                                    style="">{{ twenty4HConversation(data.value) }}
                                    <span v-if="data.value"> %</span></span></div>
                        </template>
                        <template #cell(average_sentiment)="data">
                            <div v-if="data.value"> <span v-if="data.value>= 0 " class=""
                                    @click="sortingCols(data.value)" style="">{{ twenty4HConversation(data.value) }}
                                </span>
                            </div>
                        </template>
                        <template #cell()="data">
                            <div class="text-center" style="">
                                <span v-if="checkString(data.value)" class="text-nowrap">{{ data.value }}</span>
                                <span class="text-nowrap">{{ toInterNationalNumber(data.value) }}</span>
                            </div>
                        </template>
                    </b-table>
                </b-overlay>

            </div>
            <div class="mx-2 mb-2">
                <b-row>
                    <b-col cols="12" sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-start">
                    </b-col>
                    <!-- Pagination -->
                    <b-col cols="12" sm="6"
                        class="d-flex align-items-center justify-content-center justify-content-sm-end">

                        <b-pagination id="pagination" v-model="Cpagpage" :total-rows="items.total"
                            :per-page="items.per_page" first-number last-number class="mb-0 mt-1 mt-sm-0"
                            prev-class="prev-item" next-class="next-item"
                            style="background-color:transaprent !important;">
                            <template #prev-text style="background-color:transaprent !important;">
                                <feather-icon icon="ChevronLeftIcon" size="18"
                                    style="background-color:transaprent !important;" />
                            </template>
                            <template #next-text style="background-color:transaprent !important;">
                                <feather-icon icon="ChevronRightIcon" size="18"
                                    style="background-color:transaprent !important;" />
                            </template>
                        </b-pagination>

                    </b-col>

                </b-row>
            </div>
        </div>
        <!-- end search and table -->
        <b-modal id="modal-chart" ok-only ok-title="Close" :hide-footer="true" centered size="lg"
            title="Fear Greed Index History">
            <vue-apex-charts class="full" width="100%" :dataLabels="true" type="line" :options="chartOptions"
                :series="series"></vue-apex-charts>
        </b-modal>
        <b-modal id="modal-filters" :hide-footer="true" size="lg" title="" style="border-radius: 30px;">
            <template>
                <b-row style="margin:0px 0px 24px 0px;">

                    <b-col>
                        <b-dropdown size="lg" variant="flat-secondary" style="padding:0px !important;"
                            id="dropdown-left1" ref="dropdownpreset" no-caret
                            class="cunningDrop cunningDrop2 preset-dropdown">
                            <template #button-content>
                                <div class="d-flex justify-content-between preset-button-style">
                                    <div v-if="selectedPreset" class="" style="font-size:1rem; padding-left: 28px;">
                                        {{ selectedPresetData.preset_name }}
                                    </div>
                                    <div v-else class="" style="font-size:1rem; padding-left: 28px;">
                                        Preset Filter
                                    </div>
                                    <feather-icon icon="ChevronDownIcon" class="cursor-pointer darkWhiteText" size="20"
                                        style="margin-right: 8px;" />
                                </div>
                            </template>
                            <b-dropdown-form href="#" class="preset-form dropdown-mine  " name="dropdownform2"
                                style="z-index:999;">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="text-secondary cursor-pointer px-2 text-capitalize"
                                            style="white-space: nowrap;overflow: hidden; text-overflow: ellipsis; "
                                            @click="clearPreset()">
                                            Preset Filter
                                        </div>
                                        <feather-icon icon="ChevronUpIcon" class="cursor-pointer darkWhiteText"
                                            size="20" style="" />
                                    </div>
                                </div>
                                <div class="" v-for="(preset,index) in presetFiltersapp1" :key="index"
                                    style="display:flex; padding: 4px;">
                                    <div @click="selectPreset(preset)"
                                        class="darkWhiteText cursor-pointer px-2 text-capitalize"
                                        style="white-space: nowrap;overflow: hidden; text-overflow: ellipsis;">
                                        {{preset.preset_name}}
                                    </div>
                                </div>
                                <hr v-if="presetFiltersapp2.length>0" />
                                <div style="margin-left:24px">
                                    <h5 class="text-secondary" v-if="presetFiltersapp2.length>0">My Filters</h5>
                                </div>

                                <div class=" d-flex justify-content-between" v-for="(preset,index) in presetFiltersapp2"
                                    :key="preset.preset_name+index" style="display:flex; padding: 4px;">
                                    <div @click="selectPreset(preset)"
                                        class="darkWhiteText cursor-pointer px-2 text-capitalize" style="white-space: nowrap; 
                                        overflow: hidden;
                                        text-overflow: ellipsis;">
                                        {{preset.preset_name}} (Custom Filter)
                                    </div>
                                    <div class="cursor-pointer">
                                        <feather-icon icon="Trash2Icon" size="16" @click="deletePreset(preset.id)" />
                                    </div>
                                </div>
                            </b-dropdown-form>


                        </b-dropdown>
                    </b-col>
                  
                    <b-col class="m-auto">
                        <b-button v-ripple.400="'rgb(31, 103, 211)'" style="    margin-right: 10px !important;"
                            v-if="selectedPreset && checkDefault(selectedPreset)" @click="savePresetFilter"
                            title="Save preset" variant="primary" class="btn-icon">
                            <feather-icon icon="SaveIcon" size="16" />
                        </b-button>
                        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            v-if="selectedPreset && checkDefault(selectedPreset)" @click="deletePreset(selectedPreset)"
                            title="Delete preset" variant="primary" class="btn-icon">
                            <feather-icon icon="Trash2Icon" size="16" />
                        </b-button>


                    </b-col>
                </b-row>
                <b-row>
                    <b-col v-if="params.favoritesMode == 1" class="d-flex">
                        <p >Note: You are filtering your favorite coins only! </p> <p class="text-primary cursor-pointer ml-1" @click="exitfavorites">Click here to filter all coins</p>
    
                        </b-col>
                </b-row>
                <hr style="padding:0px; margin:0px 0px 10px 0px;">
                <div class="accordion" role="tablist">
                    <app-collapse accordion style="padding:0px;">
                        <app-collapse-item :isVisible="all_coins_mode" title="Market Data Filters">
                            <b-row>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="mb-2">
                                        <b-form-group label="Market Cap">
                                            <div class="d-flex">
                                                <cleave id="min_market_cap" v-model="filterKey.min_market_cap"
                                                    class="form-control" :raw="false" :options="NumberFormaVal"
                                                    placeholder="min" />

                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave id="max_market_cap" v-model="filterKey.max_market_cap"
                                                    class="form-control" :raw="false" :options="NumberFormaVal"
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Circulating Supply">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_circulating_supply" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_circulating_supply" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Market Cap. Rank">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_market_cap_rank" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_market_cap_rank" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="">
                                        <b-form-group label="ROI %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_roi_percentage" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_roi_percentage" v-numeric-only
                                                    placeholder="max" />
                                            </div>

                                        </b-form-group>

                                        <vue-slider v-model="value1" :direction="direction" class="mb-2" />
                                    </div>
                                    <div class="">
                                        <b-form-group label="Daily Price Change (%)"
                                            label-for="price_change_percentage_24h">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    name="price_change_percentage_24h" v-numeric-only
                                                    v-model="filterKey.min_price_change_percentage_24h"
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_price_change_percentage_24h" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value2" :direction="direction" class="mb-2" />
                                    </div>
                                    <div class="">
                                        <b-form-group label="Total Supply (%)">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_total_supply_percent" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_total_supply_percent" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value3" :direction="direction" class="mb-2" />
                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Public ROI">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_roi_seed" v-numeric-only placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_roi_seed" v-numeric-only placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="">
                                        <b-form-group label="Keywords" label-for="">
                                            <div class="d-flex">
                                                <b-form-input v-model="filterKey.keywords" placeholder="key words" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="mb-2">
                                        <b-form-group label="Token Price">
                                            <div class="d-flex">
                                                <cleave id="min_market_cap" v-model="filterKey.min_current_price"
                                                    class="form-control" :raw="false" :options="NumberFormaVal"
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave id="max_market_cap" v-model="filterKey.max_current_price"
                                                    class="form-control" :raw="false" :options="NumberFormaVal"
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Total Supply">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_total_supply" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_total_supply" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Trade Volume">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_trading_volume" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_trading_volume" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="ROI in X's">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_roi_times" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_roi_times" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Days in Market">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_genesis_date" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_genesis_date" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Public Price">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_seed_price" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_seed_price" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Platform" label-for="">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.coin_platform"
                                                    :options="platforms" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Category" label-for="">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.coin_category"
                                                    :options="categories" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                </b-col>

                            </b-row>
                        </app-collapse-item>
                        <app-collapse-item title="Social Sentiments">
                            <b-row>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="">
                                        <b-form-group label="Sentiment Change %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_average_sentiment_change" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_average_sentiment_change" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value4" :direction="direction" class="mb-2" />
                                    </div>
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                </b-col>

                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="">
                                        <b-form-group label="Social Mentions Change %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_social_mentions_change" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_social_mentions_change" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value5" :direction="direction" class="mb-2" />
                                    </div>
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="">
                                        <b-form-group label="Social Engagement Change %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_social_engagement_change" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_social_engagement_change" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value6" :direction="direction" class="mb-2" />
                                    </div>
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="">
                                        <b-form-group label="Average Sentiment (1-5)">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_average_sentiment" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_average_sentiment" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider :max="5" :min="1" v-model="value7" :direction="direction"
                                            class="mb-2 oneToFive" />
                                    </div>
                                </b-col>

                            </b-row>
                        </app-collapse-item>
                        <app-collapse-item title="Unlocking" :isVisible="unlocking_mode">
                            <b-row>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="mb-2">
                                        <b-form-group label="Total Locked">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_total_locked" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_total_locked" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Next Unlock # of Tokens">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_next_unlock_number_of_tokens" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_next_unlock_number_of_tokens" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Next Unlock Size">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.next_unlock_size"
                                                    :options="nextUnlockSize" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="Next Unlock Date">
                                            <div class="d-flex">
                                                <!-- <b-form-select id="" v-model="filterKey.next_unlock_size"
                                                    :options="nextUnlockSize" /> -->
                                                <flat-pickr v-model="filterKey.next_unlock_date"
                                                    placeholder="Select date in range" class="form-control"
                                                    input-class="md-input" :config="{ mode: 'range'}" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                    <div class="">
                                        <b-form-group label="3 Months Unlock %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_three_months_unlock_percent_of_tokens"
                                                    v-numeric-only placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_three_months_unlock_percent_of_tokens"
                                                    v-numeric-only placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value8" :direction="direction" class="mb-2" />
                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="6 Months Unlock # of Tokens">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_six_months_unlock_number_of_tokens"
                                                    v-numeric-only placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_six_months_unlock_number_of_tokens"
                                                    v-numeric-only placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="">
                                        <b-form-group label="6 Months Unlock Size">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.six_months_unlock_size"
                                                    :options="nextUnlockSize" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                </b-col>
                                <b-col md="6" xl="6" style="padding:0px 32px 0px 32px;">
                                    <div class="mb-2">
                                        <b-form-group label="Unlock Status">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.next_unlock_status"
                                                    :options="unlockStatusCoins" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                    <div class="">
                                        <b-form-group label="Next Unlock %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_next_unlock_percent_of_tokens" v-numeric-only
                                                    placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_next_unlock_percent_of_tokens" v-numeric-only
                                                    placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value9" :direction="direction" class="mb-2" />
                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="3 Months Unlock # of Tokens">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_three_months_unlock_number_of_tokens"
                                                    v-numeric-only placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_three_months_unlock_number_of_tokens"
                                                    v-numeric-only placeholder="max" />
                                            </div>
                                        </b-form-group>

                                    </div>
                                    <div class="mb-2">
                                        <b-form-group label="3 Months Unlock Size">
                                            <div class="d-flex">
                                                <b-form-select id="" v-model="filterKey.three_months_unlock_size"
                                                    :options="nextUnlockSize" />
                                            </div>
                                        </b-form-group>
                                    </div>
                                    <div class="">
                                        <b-form-group label="6 Months Unlock %">
                                            <div class="d-flex">
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.min_six_months_unlock_percent_of_tokens"
                                                    v-numeric-only placeholder="min" />
                                                <span>
                                                    <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                                        style="margin:10px 6px 0 0px" />
                                                </span>
                                                <cleave :options="NumberFormaVal" class="form-control"
                                                    v-model="filterKey.max_six_months_unlock_percent_of_tokens"
                                                    v-numeric-only placeholder="max" />
                                            </div>
                                        </b-form-group>
                                        <vue-slider v-model="value10" :direction="direction" class="mb-2" />
                                    </div>
                                </b-col>

                            </b-row>
                        </app-collapse-item>
                    </app-collapse>

                </div>
            </template>
            <div class="d-flex justify-content-between max-block"
                style="margin-top:50px; margin-bottom:50px; margin-left: 88px; margin-right: 88px;">
                <b-button class="darkWhiteBackground darkBlackText rounded-lg text-[16px]" size="md"
                    v-b-modal.modal-preset-create v-ripple.400="'rgba(113, 12, 240, 0.15)'" variant="outline-primary">
                    Add new preset
                </b-button>

                <b-button class="darkWhiteBackground darkBlackText rounded-lg text-[16px]" @click="filterCoins(true)"
                    v-ripple.400="'rgba(113, 8, 150, 0.15)'" variant="outline-primary">
                    Apply filters</b-button>

                <b-button class="darkWhiteText darkWhiteBorder rounded-lg text-[16px]" @click="clearFilters(true)"
                    v-ripple.400="'rgba(113, 12, 240, 0.15)'" variant="outline-primary">Clear filter</b-button>
            </div>
        </b-modal>
        <b-modal id="modal-details" :hide-footer="true" centered>
            <template>
                <div slot="modal-title">

                </div>
                <!-- <app-collapse accordion> -->
                <b-overlay :show="!detailsModalLoaded" rounded="sm">
                    <div class="details-modal-container" v-if="detailsModalLoaded">
                        <div class="w-full justify-content-between d-flex" style="margin-top: 10px; margin-left: 10px;">
                            <div class="d-inline">
                                <div class="rank_slot darkWhiteText" style="margin-bottom: 8px;font-family: 'Poppins'; opacity: 0.6 !important;
                                            font-style: normal;
                                            font-weight: 300;
                                            font-size: 12px;
                                            ">Rank #{{toInterNationalNumber(activeData.market_cap_rank)}}</div>
                                <div class="d-flex" style="margin-top:11px;">
                                    <div class="d-flex m-auto">
                                        <b-avatar class="bg-light mr-1" v-if="activeData.image" :src="activeData.image">
                                        </b-avatar>
                                        <span class="marginx1 m-auto a darkWhiteText" style="font-family: 'Poppins';   font-size: 20px;  font-style: normal;  font-weight: 400;
                                                        width: 105px;
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;
                                                        overflow: hidden;" data-toggle="tooltip" data-placement="top"
                                            :title="activeData.name"
                                            v-if="activeData.name && activeData.name.length > 8 ">
                                            {{activeData.name}}


                                        </span>
                                        <span class="marginx1 m-auto b darkWhiteText mr-3"
                                            :class="{'w-[105px]':activeData.name && activeData.name.length > 8}" style="font-family: 'Poppins';
                                                        font-size: 20px; 
                                                        font-style: normal;
                                                        font-weight: 400;
                                                        
                                                        text-overflow: ellipsis;
                                                        white-space: nowrap;
                                                        overflow: hidden;" v-else>
                                            {{activeData.name}}


                                        </span>

                                        <span class="marginx1 m-auto darkWhiteText mx-2" style="font-family: 'Poppins';
                                                        font-size: 14px; position: relative;
                                                        font-style: normal; opacity: 0.7;
                                                        font-weight: 300; margin-right: 40px !important;">
                                            <div style="position: absolute; top:-29px; left:4px">
                                                &nbsp; {{activeData.symbol}}
                                            </div>
                                        </span>

                                    </div>
                                    <div class="d-flex ml-[10px] mb-auto mr-auto mt-auto" style="margin-left:10px"
                                        :class="{'ml-[30px]':activeData.name && activeData.name.length > 8}">
                                        <div class="d-flex">
                                            <span class=""
                                                :class="{'redFlash1': activeData.price_change_percentage_24h < 0,'greenFlash1': activeData.price_change_percentage_24h >= 0 ,'greenFlash':activeData.flash == 1,'redFlash':activeData.flash ==2,'whiteFlash':activeData.flash ==3}"
                                                style="font-family: 'Poppins-Light'; font-style: normal;font-weight: 400; font-size: 20px;"
                                                v-if="activeData.current_price && activeData.current_price>= 0">${{ roundData(activeData.current_price) }}
                                            </span>
                                        </div>
                                        <div class="d-flex m-auto">
                                            <span
                                                v-if="activeData.price_change_percentage_24h && activeData.price_change_percentage_24h>= 0"
                                                class="btn-success d-flex  marginx1"
                                                style="font-family: 'Poppins-Light';
                                                        font-style: normal;
                                                        font-weight: 300;
                                                        font-size: 12px; margin-top: 2px;border-radius:5px; padding:0px 5px">
                                                <div style="display: inline; margin:auto;">
                                                    <feather-icon size="20" icon="ChevronUpIcon" />
                                                </div>
                                                <span>{{ roundData(activeData.price_change_percentage_24h) }}%</span>

                                            </span>
                                            <span v-else-if="activeData.price_change_percentage_24h"
                                                style="font-size:12px; font-weight: 300; margin-top: 2px;border-radius:5px; padding:0px 5px"
                                                class="btn-danger d-flex marginx1">
                                                <div style="display: inline; margin:auto;">
                                                    <feather-icon size="20" icon="ChevronDownIcon" />
                                                </div>
                                                <span>{{ roundData(activeData.price_change_percentage_24h) }}%</span>

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-50 d-inline" style="margin-right:20px;">
                                <div class="bg-theme rounded d-inline" style="float: right;"
                                    v-if="activeData.contract_address && activeData.contract_address.length>0">

                                    <div style="margin-top:-2px">
                                        <div class="my-auto darkWhiteText" style="margin-bottom: 8px !important; margin-right: 4px;padding-left:10px; font-family: 'Poppins-Light';
                                                    font-style: normal;
                                                    font-weight: 300;
                                                    font-size: 12px;
                                                ">Contract </div>


                                        <b-dropdown size="lg" variant="flat-secondary" style="padding:0px !important;"
                                            id="dropdown-left1" no-caret class="cunningDrop">
                                            <template #button-content>
                                                <div class="darkBackgroundBlack"
                                                    v-for="(address,index) in activeData.contract_address.slice(0, 1)"
                                                    :key="index"
                                                    style="display:block; padding: 2px; border-radius: 20px;">
                                                    <div class="flex">

                                                        <b-img v-if="activeData.image" :src="activeData.image" fluid
                                                            alt="Responsive image" style="margin-right:5px; height:30px;     position: relative;
                                                                    bottom: 4px;" />
                                                        <div style="font-family: 'Poppins-Light'; display:inline-block;
                                                                    font-style: normal;    position: relative;
                                                                    top: 4px;
                                                                    font-weight: 500;
                                                                    font-size: 14px;
                                                                    line-height: 14px; width:90px;white-space: nowrap; 
                                                                    text-align: start;
                                                                    overflow: hidden;
                                                                    text-overflow: ellipsis;">
                                                            <div style="white-space: nowrap; width:90px;  overflow: hidden;
                                                                text-overflow: ellipsis;"
                                                                class="darkWhiteText text-capitalize">
                                                                {{address.platform}}
                                                            </div>
                                                            <div style="white-space: nowrap; width:90px;  overflow: hidden;
                                                                text-overflow: ellipsis;" class="text-secondary ">
                                                                {{address.contract_address}}
                                                            </div>
                                                        </div>
                                                        <div style="display:inline-block; float:right; margin-top:-3px">

                                                            <b-button size="sm" class="ml-1"
                                                                v-clipboard:copy="address.contract_address"
                                                                style="margin-right:13px; cursor:pointer; border: none !important;"
                                                                v-clipboard:success="onCopy" v-clipboard:error="onError"
                                                                v-ripple.400="'rgba(113, 12, 240, 0.15)'"
                                                                variant="outline-primary" pill>
                                                                <i
                                                                    class="fa-regular fa-copy cursor-pointer darkWhiteText fa-lg m-1"></i>
                                                                <!-- <feather-icon icon="CopyIcon"
                                                                            class="cursor-pointer darkWhiteText" size="20" /> -->
                                                            </b-button>
                                                            <img src='/images/static/metamask.png' class="img-fluid"
                                                                alt="metamask"
                                                                style="cursor:pointer; width:23px; margin-right:13px;"
                                                                @click="say('say')">
                                                            <feather-icon icon="ChevronDownIcon"
                                                                class="cursor-pointer darkWhiteText" size="20"
                                                                style="margin-right:13px; margin-bottom: 6px;" />

                                                        </div>

                                                    </div>


                                                </div>

                                            </template>
                                            <b-dropdown-form href="#"
                                                class="cunningDrop dropdown-mine darkBackgroundBlack"
                                                name="dropdownform2" style="z-index:999;">
                                                <div class="darkBackgroundBlack"
                                                    v-for="(address,index) in activeData.contract_address" :key="index"
                                                    style="display:flex; padding: 4px;">
                                                    <b-img v-if="activeData.image" :src="activeData.image" fluid
                                                        alt="Responsive image" style="margin-right:5px; height:30px;" />
                                                    <div class="" style="font-family: 'Poppins-Light'; display:inline-block; font-style: normal;
                                                                        font-weight: 500;
                                                                        font-size: 14px;
                                                                        line-height: 14px;
                                                                        ">
                                                        <div class="darkWhiteText text-capitalize" style="white-space: nowrap; width:90px;
                                                                        overflow: hidden;
                                                                        text-overflow: ellipsis;">
                                                            {{address.platform}}
                                                        </div>
                                                        <div class=" text-secondary" style="white-space: nowrap; width:90px;
                                                                        overflow: hidden;
                                                                        text-overflow: ellipsis;">
                                                            {{address.contract_address}}
                                                        </div>

                                                    </div>
                                                    <div style="display:inline-block; float:right;">


                                                        <b-button size="sm" class="ml-1"
                                                            v-clipboard:copy="address.contract_address"
                                                            style="margin-right:13px; cursor:pointer; border: none !important;"
                                                            v-clipboard:success="onCopy" v-clipboard:error="onError"
                                                            v-ripple.400="'rgba(113, 12, 240, 0.15)'"
                                                            variant="outline-primary" pill>
                                                            <i
                                                                class="fa-regular fa-copy cursor-pointer darkWhiteText fa-xl m-1"></i>
                                                        </b-button>
                                                        <img src='/images/static/metamask.png' class="img-fluid"
                                                            alt="metamask" style="cursor:pointer; width:23px;"
                                                            @click="say('hello')">

                                                    </div>


                                                </div>
                                            </b-dropdown-form>

                                        </b-dropdown>
                                        <!-- <b-form-select v-model="selectedContract">
                                                    <b-form-select-option :value="null" selected>Select</b-form-select-option>
                                                    <b-form-select-option v-for="(address,index) in activeData.contract_address"
                                                        :key="index" :>
                                                        {{ address.platform }}
                                                    </b-form-select-option>
                                                </b-form-select> -->
                                    </div>
                                    <!-- <div v-if="selectedContract" class="d-flex mt-1 justify-content-end">
                                                <div class="text-nowrap text-truncate" style="width:200px">{{selectedContract}}
                                                </div>
                                                <b-button size="sm" class="ml-1" v-clipboard:copy="selectedContract"
                                                    v-clipboard:success="onCopy" v-clipboard:error="onError"
                                                    v-ripple.400="'rgba(113, 12, 240, 0.15)'" variant="outline-primary" pill>Copy!
                                                </b-button>
    
                                            </div> -->


                                </div>
                            </div>
                        </div>
                        <app-collapse>
                            <app-collapse-item v-if="activeData.sparkline_in_7d&& activeData.sparkline_in_7d.length>0
                                    || activeData.roi_times ||activeData.round_price && activeData.round_price !=0 && activeData.current_price&& activeData.current_price !=0
                                    || activeData.total_volume
                                    ||activeData.market_cap
                                    ||activeData.total_supply_percent" :isVisible="true" title="Market Data"
                                class="open w-100">
                                <b-card no-body>
                                    <b-card-body style="margin-left: 10px; margin-top: 19px;">
                                        <b-row>

                                            <b-col md="10" sm="8" class="text-center sparlineChat mb-1"
                                                style="margin-left: -40px;"
                                                v-if="activeData.sparkline_in_7d&& activeData.sparkline_in_7d.length>0">
                                                <!-- <h5> 7 Days</h5> -->
                                                <div class="position-absolute w-100" style="z-index:99">

                                                    <b-tabs content-class=""
                                                        class="graph_tab graph_tab-1 float-left w-50"
                                                        style="font-family: Poppins-Light;font-style: normal;font-weight: 400;font-size: 10px;">
                                                        <b-tab active title="Price">
                                                            <div></div>
                                                        </b-tab>
                                                        <b-tab title="MC">
                                                            <div></div>
                                                        </b-tab>
                                                    </b-tabs>
                                                    <div class="d-inline-flex float-right"
                                                        style="padding-right: 40px !important;">
                                                        <b-tabs content-class="" class="graph_tab my-auto"
                                                            style="font-family: Poppins-Light;font-style: normal;font-weight: 400;font-size: 10px;">
                                                            <b-tab active title="1D">
                                                                <div></div>
                                                            </b-tab>
                                                            <b-tab title="7D">
                                                                <div></div>
                                                            </b-tab>
                                                            <b-tab title="1M">
                                                                <div></div>
                                                            </b-tab>
                                                            <b-tab title="3M">
                                                                <div></div>
                                                            </b-tab>
                                                            <b-tab title="1Y">
                                                                <div></div>
                                                            </b-tab>
                                                            <b-tab title="ALL">
                                                                <div></div>
                                                            </b-tab>
                                                        </b-tabs>
                                                        <div style="width:20px">
                                                            <feather-icon size='12' icon='CalendarIcon' />
                                                        </div>
                                                    </div>
                                                </div>
                                                <vue-apex-charts class="full" width="100%" :dataLabels="true"
                                                    type="area" height="290" :options="seven_DaysChart"
                                                    :series="seven_DaysChartseries">
                                                </vue-apex-charts>
                                                <!-- <sparkline width="300" height="150">
                                                        <sparklineLine :data="activeData.sparkline_in_7d"
                                                            :limit="activeData.sparkline_in_7d?activeData.sparkline_in_7d.length:1000"
                                                            :styles="spLineStyles" />
                                                    </sparkline> -->
                                            </b-col>
                                            <b-col md="2" sm="4" style=" 
                                                    padding-left: 0px !important;
                                                    justify-content: space-between;
                                                    flex-direction: column;">
                                                <div v-if="activeData.total_volume" style="margin-bottom: 10px;">
                                                    <span
                                                        style="font-family: 'Poppins-Light';font-style: normal;font-weight: 300;font-size: 12px;opacity: 0.5;">
                                                        Volume</span>
                                                    <div class="" style="font-size:16px; font-weight: 600;">
                                                        <span
                                                            style="font-family: 'Poppins-Light';font-style: normal;font-weight: 400;font-size: 15px;">${{ toInterNationalNumber(activeData.total_volume) }}</span>
                                                    </div>
                                                </div>
                                                <div v-if="activeData.market_cap" style="margin-bottom: 10px;">
                                                    <span
                                                        style="font-family: 'Poppins-Light';font-style: normal;font-weight: 300;font-size: 12px;opacity: 0.5;">
                                                        Market Cap</span>
                                                    <div class="" style="font-size:16px; font-weight: 600;">
                                                        <span
                                                            style="font-family: 'Poppins-Light';font-style: normal;font-weight: 400;font-size: 15px;">${{ toInterNationalNumber(activeData.market_cap) }}</span>
                                                    </div>
                                                </div>
                                                <div style="margin-bottom: 10px;"
                                                    v-if="activeData.roi_times ||activeData.round_price && activeData.round_price !=0 && activeData.current_price&& activeData.current_price !=0">
                                                    <span
                                                        style="font-family: 'Poppins-Light';font-style: normal;font-weight: 300;font-size: 12px;opacity: 0.5;">
                                                        X's from launch</span>
                                                    <div class="" style="font-size:16px; font-weight: 600;">
                                                        <span
                                                            style="font-family: 'Poppins-Light';font-style: normal;font-weight: 400;font-size: 15px;"
                                                            v-if="activeData.roi_times">{{ xfromlunch(activeData.roi_times,'roi_times') }}X</span>
                                                        <span
                                                            style="font-family: 'Poppins-Light';font-style: normal;font-weight: 400;font-size: 15px;"
                                                            v-else-if="activeData.round_price && activeData.round_price !=0 && activeData.current_price&& activeData.current_price !=0 ">{{ xfromlunch(activeData.current_price,activeData.round_price) }}X</span>
                                                    </div>
                                                </div>
                                                <div v-if="activeData.total_supply_percent"
                                                    style="margin-bottom: 10px;">
                                                    <span
                                                        style="font-family: 'Poppins-Light';font-style: normal;font-weight: 300;font-size: 12px;opacity: 0.5;">
                                                        Total Supply:</span>
                                                    <div class="" style="font-size:16px; font-weight: 600;">
                                                        <span
                                                            style="font-family: 'Poppins-Light';font-style: normal;font-weight: 400;font-size: 15px;">{{ activeData.total_supply_percent }}
                                                            %</span> </div>
                                                </div>
                                                <div class="float-left">
                                                    <button class="fs-6 "
                                                        style="border-radius: 10px; font-size: 12px; font-weight: 400; font-family: 'Poppins-Light'; font-style: normal; padding:6px 11px;">Price
                                                        Prediction</button>
                                                </div>
                                            </b-col>

                                        </b-row>
                                        <b-row>
                                            <b-col class="p-0">
                                                <p class="poppins-font chart-desc" v-html="activeData.coin_description">

                                                </p>
                                            </b-col>
                                        </b-row>

                                    </b-card-body>
                                </b-card>
                            </app-collapse-item>
                            <app-collapse-item title="Social Data" class="w-100">
                                <b-card no-body class="mb-1">
                                    <b-card-body>

                                        <div class="d-flex flex-wrap justify-content-start">
                                            <div v-if="activeData.website && activeData.website != '' " cols="1" md="2"
                                                lg="2" sm="2" class="radius_gradient" style="width:110px">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.website" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/website.png'" fluid
                                                            class="w-50" alt="Responsive image" />
                                                    </a>
                                                    <div class="soicalLable soicalLable-2">
                                                        Website
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.twitter && activeData.twitter != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.twitter" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/twitter.png'" fluid
                                                            class="w-50" alt="Responsive image" />
                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.twitter_followers">
                                                        {{kFormatter(activeData.twitter_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>
                                                        Twitter
                                                    </div>
                                                </b-card>
                                            </div>

                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.telegram && activeData.telegram != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.telegram" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/telegram.png'" fluid
                                                            class="w-50" alt="Responsive image" />

                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.telegram_members">
                                                        {{kFormatter(activeData.telegram_members)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>
                                                        Telegram
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.discord && activeData.discord != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.discord" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/discord.png'" fluid
                                                            class="w-50" alt="Responsive image" />
                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.medium_followers">
                                                        {{kFormatter(activeData.medium_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>Discord
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.medium && activeData.medium != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.medium" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/medium.png'" fluid
                                                            class="w-50" alt="Responsive image" />

                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.medium_followers">
                                                        {{kFormatter(activeData.medium_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>Medium
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.reddit && activeData.reddit != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.reddit" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/reddit.png'" fluid
                                                            class="w-50" alt="Responsive image" />

                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.reddit_followers">
                                                        {{kFormatter(activeData.reddit_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>Reddit
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient" style="width:110px"
                                                v-if="activeData.whitepaper && activeData.whitepaper != '' ">
                                                <b-card title=""
                                                    class="mx-auto innerCard text-center str_grey_gradient whitepaper-card"
                                                    style="max-width:200px; ">
                                                    <a :href="activeData.whitepaper" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/whitepaper.png'" fluid
                                                            class="w-50 bg-light" alt="Responsive image" />

                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.whitepaper_followers">
                                                        {{kFormatter(activeData.whitepaper_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>Whitepaper
                                                    </div>
                                                </b-card>
                                            </div>
                                            <div class="radius_gradient " style="width:110px"
                                                v-if="activeData.github && activeData.github != '' ">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <a :href="activeData.github" target="_blank" class="d-block"
                                                        style="margin-top:20px; margin-bottom:10px;">
                                                        <b-img rounded :src="'/images/static/github.png'" fluid
                                                            class="w-50" alt="Responsive image" />
                                                    </a>
                                                    <div class="soicalLable soicalLable-2"
                                                        v-if="activeData.github_followers">
                                                        {{kFormatter(activeData.github_followers)}}
                                                    </div>
                                                    <div class="soicalLable soicalLable-2" v-else>Github
                                                    </div>
                                                </b-card>
                                            </div>
                                        </div>
                                        <div
                                            class="text-center mt-1 mb-1 justify-content-start d-flex flex-wrap socialData">


                                            <div class="radius_gradient cursor-pointer"
                                                v-b-tooltip.hover.bottom="'Social Score'" style="width:110px;"
                                                v-if="activeData.average_sentiment">
                                                <b-card title=""
                                                    class="mx-auto  innerCard text-center str_grey_gradient"
                                                    style="max-width:120px;">

                                                    <div class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;">
                                                        {{ calculate_social_score(activeData) }}/10</div>

                                                    <div class="soicalLable sl2 darkWhiteText lableText">Social Score
                                                    </div>

                                                </b-card>
                                            </div>
                                            <div class="radius_gradient cursor-pointer" style="width:110px;"
                                                v-b-tooltip.hover.bottom="'Social Mentions'"
                                                v-if="activeData.social_mentions_change">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <div class="justify-content-center text-nowrap socialText2 text-success-green "
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-if="activeData.social_mentions_change>=0">
                                                        +{{roundData(activeData.social_mentions_change)}} %
                                                    </div>
                                                    <div class="justify-content-center text-nowrap socialText2 text-danger "
                                                        style="margin-top: 10px; margin-bottom: 12px;" v-else>
                                                        {{roundData(activeData.social_mentions_change)}} %
                                                    </div>
                                                    <div class="soicalLable sl2 darkWhiteText lableText">Social Mentions
                                                    </div>

                                                </b-card>
                                            </div>

                                            <div class="radius_gradient cursor-pointer" style="width:110px;"
                                                v-b-tooltip.hover.bottom="'Average Sentiment'"
                                                v-if="activeData.average_sentiment">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <div class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-if="userData.currentPlan == 'free'">
                                                        <feather-icon icon="LockIcon" size="30" style="" />
                                                    </div>
                                                    <div v-else class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;">
                                                        {{roundData(activeData.average_sentiment)}}</div>

                                                    <div class="soicalLable sl2 darkWhiteText lableText">Average
                                                        Sentiment
                                                    </div>

                                                </b-card>
                                            </div>

                                            <div class="radius_gradient cursor-pointer" style="width:110px;"
                                                v-b-tooltip.hover.bottom="'Social Engagement'"
                                                v-if="activeData.social_engagement">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <div class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-if="userData.currentPlan == 'free'">
                                                        <feather-icon icon="LockIcon" size="30" style="" />
                                                    </div>
                                                    <div class="justify-content-center text-nowrap socialText2 text-success-green"
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-else-if="activeData.social_engagement_change>=0">
                                                        +{{roundData(activeData.social_engagement_change)}} %</div>
                                                    <div class="justify-content-center text-nowrap socialText2  text-danger"
                                                        style="margin-top: 10px; margin-bottom: 12px;" v-else>
                                                        {{roundData(activeData.social_engagement_change)}} %</div>
                                                    <div class="soicalLable sl2 darkWhiteText lableText">Social
                                                        Engagement
                                                    </div>

                                                </b-card>
                                            </div>
                                            <div class="radius_gradient cursor-pointer" style="width:110px;"
                                                v-b-tooltip.hover.bottom="'Bearish Sentiment'">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <div class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-if="userData.currentPlan == 'free'">
                                                        <feather-icon icon="LockIcon" size="30" style="" />
                                                    </div>
                                                    <div class="justify-content-center text-nowrap socialText2"
                                                        style="margin-top: 10px; margin-bottom: 12px;" v-else>2</div>
                                                    <div class="soicalLable sl2 darkWhiteText lableText">Bearish
                                                        Sentiment
                                                    </div>

                                                </b-card>
                                            </div>

                                            <div class="radius_gradient cursor-pointer" style="width:110px;"
                                                v-b-tooltip.hover.bottom="'Average Sentiment change  '"
                                                v-if="activeData.average_sentiment_change">
                                                <b-card title="" class="mx-auto innerCard text-center str_grey_gradient"
                                                    style="max-width:200px;">
                                                    <div class="justify-content-center text-nowrap socialText2 "
                                                        style="margin-top: 10px; margin-bottom: 12px;"
                                                        v-if="roundData(activeData.average_sentiment_change)>=0">
                                                        +{{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                        %</div>
                                                    <div class="justify-content-center text-nowrap socialText2 text-danger"
                                                        style="margin-top: 10px; margin-bottom: 12px;" v-else>
                                                        {{roundData(activeData.average_sentiment_change)?roundData(activeData.average_sentiment_change):0}}
                                                        %</div>
                                                    <div class="soicalLable sl2 darkWhiteText lableText">Average
                                                        Sentiment
                                                        change
                                                    </div>

                                                </b-card>
                                            </div>

                                        </div>
                                    </b-card-body>
                                </b-card>
                            </app-collapse-item>
                            <app-collapse-item class="w-100" title="Unlocking Data" v-if="activeData.next_unlock_date_text || supplyChart.series.length >0 ||activeData.next_unlock_status || 
                                    activeData.first_vc_unlock
                                    ||activeData.end_vc_unlock
                                    ||activeData.next_unlock_number_of_tokens
                                    ||activeData.next_unlock_size
                                    ||activeData.next_unlock_percent_of_tokens
                                    ||activeData.seed_price
                                    ||activeData.roi_seed
                                    ||activeData.three_months_unlock_number_of_tokens
                                    ||activeData.three_months_unlock_percent_of_tokens
                                    ||activeData.three_months_unlock_size
                                    ||activeData.six_months_unlock_number_of_tokens
                                    ||activeData.six_months_unlock_percent_of_tokens
                                    ||activeData.six_months_unlock_size
                                    ||activeData.total_supply_percent ">
                                <div class="container d-flex" style="padding:0px;">
                                    <div class="d-inline" v-if="activeData.next_unlock_date_text"
                                        style="width:20%; font-family: 'Poppins-Light'; margin-right: 24px;  font-style: normal;  font-weight: 400; font-size: 12px;">
                                        <span style="opacity: 0.5;">Next Unlock Date</span><br>
                                        <span>{{ activeData.next_unlock_date_text}}</span><br>
                                    </div>
                                    <div class="d-inline" v-else-if="activeData.next_unlock_date"
                                        style="width:20%; font-family: 'Poppins-Light'; margin-right: 24px;  font-style: normal;  font-weight: 400; font-size: 12px;">
                                        <span style="opacity: 0.5;">Next Unlock Date</span><br>
                                        <span>{{ getDateAndTime(activeData.next_unlock_date,'date') }}</span><br>
                                        <span
                                            style="opacity: 0.5;">{{ getDateAndTime(activeData.next_unlock_date,'time') }}</span>
                                    </div>
                                    <div v-if="!activeData.next_unlock_date_text && activeData.next_unlock_date"
                                        class="d-inline-flex justify-content-between" style="">
                                        <div class="d-iline" style="max-width:65px">
                                            <div class="radius_gradient" style="border-radius:10px">
                                                <div class="str_green_gradient text-center m-auto vertical-items-center"
                                                    style="width:64px; height:64px; border-radius: 10px; background: black !important;">
                                                    <span
                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 26px; color: #2BFF4D"
                                                        v-if="activeData.next_unlock_percent_of_tokens">{{ roundData2(activeData.next_unlock_percent_of_tokens,1) }}%</span><br>
                                                    <span
                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 14px; color: #2BFF4D">{{ roundData2(activeData.next_unlock_percent_of_tokens/1000000,2)  }}mil</span>
                                                </div>
                                            </div>
                                        </div>
                                        <vac :end-time="getTimeStamp(activeData.next_unlock_date)">
                                            <template v-slot:process="{ timeObj }">
                                                <div class="d-flex">
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px; height:49px; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">{{ timeObj.d }}</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>D</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">{{ timeObj.h }}</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>H</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">{{ timeObj.m }}</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>M</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">{{ timeObj.s }}</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>S</div>
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-slot:finish>
                                                <div class="d-flex">
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px; height:49px; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">0</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>D</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">00</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>H</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">00</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>M</div>
                                                    </div>
                                                    <div class="d-iline text-center" style="margin-left: 12px;">
                                                        <div style="max-width:50px">
                                                            <div class="radius_gradient" style="border-radius:10px">
                                                                <div class="str_green_gradient text-center"
                                                                    style="width:49px ; height:49px ; border-radius: 10px;">
                                                                    <span
                                                                        style="font-family: monospace;font-style: normal;font-weight: 400;font-size: 25px; color: #2BFF4D">00</span><br>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>S</div>
                                                    </div>
                                                </div>
                                            </template>
                                        </vac>
                                    </div>
                                    <div v-if="activeData.next_unlock_date_text || activeData.next_unlock_date"
                                        class="d-inline ml-2 mt-1" style="border-radius: 10px; margin-left: 45px;">

                                        <button v-if="notified == true" @click="notifyMe(activeData.symbol,'none')"
                                            class="rounded-pill px-2 " style=" padding: 8px; font-size: 14px;">
                                            <feather-icon size="15" icon="BellIcon" /> Remove Notification</button>
                                        <div v-if="notified == true" style="font-size:12px">Will be notified:
                                            {{ notifyList(notifiedType) }} the unlock</div>
                                        <b-dropdown
                                            v-if="validateDateRange(activeData.next_unlock_date_text , activeData.next_unlock_date)"
                                            size="lg" variant="flat-secondary" style="padding:0px !important;"
                                            id="notify-dropdown" no-caret class="cunningDrop-notify">
                                            <template #button-content class="p-0 text-left">
                                                <button v-if="notified != true" class="rounded-pill px-2 "
                                                    style=" padding: 8px; font-size: 14px;">
                                                    <feather-icon size="15" icon="BellIcon" /> Notify Me</button>


                                            </template>
                                            <b-dropdown-form href="#" v-if="notified != true"
                                                class="cunningDrop-notify-form dropdown-mine darkBackgroundBlack "
                                                name="dropdownform2" style="z-index:999;">
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'1-month-before',)"
                                                    @click="notifyMe(activeData.symbol,'1-month-before')">1 Month before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'2-weeks-before')"
                                                    @click="notifyMe(activeData.symbol,'2-weeks-before')">2 weeks before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'1-week-before')"
                                                    @click="notifyMe(activeData.symbol,'1-week-before')">1 week before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'2-days-before')"
                                                    @click="notifyMe(activeData.symbol,'2-days-before')">2 days before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'12-hours-before')"
                                                    @click="notifyMe(activeData.symbol,'12-hours-before')">12 hours
                                                    before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    v-if="checkdateinertval(activeData.next_unlock_date,activeData.next_unlock_date_text,'10-min-before')"
                                                    @click="notifyMe(activeData.symbol,'10-min-before')">10
                                                    minutes before
                                                </b-dropdown-item>
                                                <b-dropdown-item href="#"
                                                    @click="notifyMe(activeData.symbol,'on-time')">
                                                    On-time</b-dropdown-item>
                                            </b-dropdown-form>

                                        </b-dropdown>
                                        <b-dropdown v-else size="lg" variant="flat-secondary"
                                            style="padding:0px !important;" id="notify-dropdown" no-caret
                                            class="cunningDrop-notify">
                                            <template #button-content class="p-0">
                                                <button v-if="notified != true" class="rounded-pill px-2 "
                                                    style=" padding: 8px; font-size: 14px; background-color: gray;">
                                                    <feather-icon size="15" icon="BellIcon" /> Notify Me</button>
                                            </template>

                                        </b-dropdown>

                                        <!-- <button v-if="notified != true" class="rounded-pill px-2" style="padding:6px"
                                                @click="notifyMe(activeData.symbol)">
                                                <feather-icon size="15" icon="BellIcon" /> Notify Me</button>
                                            <button v-else class="rounded-pill px-2" style="padding:6px"
                                                @click="notifyMe(activeData.symbol)">
                                                <feather-icon size="15" icon="BellIcon" /> Remove Notification</button> -->
                                    </div>
                                </div>
                                <b-card no-body class="mb-1">
                                    <b-card-body style=" margin-top: 19px;">
                                        <b-row class="">
                                            <!-- <b-col cols="12" md="6" class="mb-1" xl="6"
                                                        v-if="activeData.next_unlock_date_text">
                                                        <div class="">
                                                            <div class="mr-1">Next Unlock Date: </div>
                                                            <div style="font-weight:600" class=""
                                                                :class="{'blurry-text' :checkUserPlan(activeData.market_cap_rank)}">
                                                                {{activeData.next_unlock_date_text}}</div>
                                                        </div>
                                                    </b-col> -->
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.next_unlock_status">
                                                <div class="">
                                                    <div class="mr-1">Next Unlock Status: </div>
                                                    <div style="font-weight:600" class=""
                                                        :class="{'blurry-text' :checkUserPlan(activeData.market_cap_rank)}">
                                                        {{activeData.next_unlock_status}}</div>
                                                </div>
                                            </b-col>

                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.first_vc_unlock">
                                                <div class="mr-1">First VC Unlock: </div>
                                                <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                    style="font-weight:600" class="blurry-text">
                                                    {{activeData.first_vc_unlock}}
                                                </div>
                                                <div v-else style="font-weight:600">
                                                    {{dateFormat(activeData.first_vc_unlock)}}
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6" v-if="activeData.end_vc_unlock">
                                                <div class="mr-1">End VC Unlock: </div>
                                                <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                    style="font-weight:600" class="blurry-text">
                                                    {{activeData.end_vc_unlock}}
                                                </div>
                                                <div v-else style="font-weight:600">
                                                    {{dateFormat(activeData.end_vc_unlock)}}
                                                </div>


                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.next_unlock_number_of_tokens">
                                                <div class="mr-1">Next Unlock Number Of Tokens: </div>
                                                <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                    style="font-weight:600" class="blurry-text">
                                                    {{activeData.next_unlock_number_of_tokens}}</div>
                                                <div v-else style="font-weight:600">
                                                    {{toInterNationalNumber(activeData.next_unlock_number_of_tokens)}}
                                                </div>
                                            </b-col>

                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.next_unlock_percent_of_tokens">
                                                <div class="">
                                                    <div class="mr-1">Next Unlock Percent Of Tokens: </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.next_unlock_percent_of_tokens }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{roundData(activeData.next_unlock_percent_of_tokens)}}
                                                        %</div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.next_unlock_size">
                                                <div class="mr-1">Next Unlock Size: </div>
                                                <div class="" style="font-weight:600"
                                                    :class="{'blurry-text' :checkUserPlan(activeData.market_cap_rank)}">
                                                    {{activeData.next_unlock_size}}</div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6" v-if="activeData.seed_price">
                                                <div class="">
                                                    <div class="mr-1">Seed Price: </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.seed_price }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{toInterNationalNumber(activeData.seed_price)}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6" v-if="activeData.roi_seed">
                                                <div class="">
                                                    <div class="mr-1">ROI Seed: </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.roi_seed }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        ${{activeData.roi_seed}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6" v-if="activeData.total_locked">
                                                <div class="">
                                                    <div class="mr-1">Total Locked: </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.total_locked }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{toInterNationalNumber(activeData.total_locked)}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.three_months_unlock_number_of_tokens">
                                                <div class="">
                                                    <div class="mr-1">3 Months Unlock # of Tokens </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.three_months_unlock_number_of_tokens }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{toInterNationalNumber(activeData.three_months_unlock_number_of_tokens)}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.three_months_unlock_percent_of_tokens">
                                                <div class="">
                                                    <div class="mr-1">3 Months Unlock Tokens % </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.three_months_unlock_percent_of_tokens }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{roundData(activeData.three_months_unlock_percent_of_tokens)}}%
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.three_months_unlock_size">
                                                <div class="">
                                                    <div class="mr-1">3 Months Unlock Tokens % </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.three_months_unlock_size }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{activeData.three_months_unlock_size}}
                                                    </div>
                                                </div>
                                            </b-col>

                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.six_months_unlock_number_of_tokens">
                                                <div class="">
                                                    <div class="mr-1">6 Months Unlock # of Tokens </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.six_months_unlock_number_of_tokens }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{toInterNationalNumber(activeData.six_months_unlock_number_of_tokens)}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.six_months_unlock_percent_of_tokens">
                                                <div class="">
                                                    <div class="mr-1">6 Months Unlock Tokens % </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.six_months_unlock_percent_of_tokens }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{roundData(activeData.six_months_unlock_percent_of_tokens)}}%
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.six_months_unlock_size">
                                                <div class="">
                                                    <div class="mr-1">6 Months Unlock Tokens % </div>
                                                    <div v-if="checkUserPlan(activeData.market_cap_rank)"
                                                        style="font-weight:600" class="blurry-text">
                                                        {{ activeData.six_months_unlock_size }}
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{activeData.six_months_unlock_size}}
                                                    </div>
                                                </div>
                                            </b-col>
                                            <b-col cols="12" md="6" class="mb-1" xl="6"
                                                v-if="activeData.total_supply_percent">
                                                <div class="">
                                                    <div class="mr-1">Total Supply %</div>
                                                    <div v-if="checkUserPlan(activeData.total_supply_percent)"
                                                        style="font-weight:600" class="">
                                                        {{ activeData.total_supply_percent}} %
                                                    </div>
                                                    <div style="font-weight:600" v-else>
                                                        {{activeData.total_supply_percent}}%
                                                    </div>
                                                </div>
                                            </b-col>

                                            <b-col cols="12" md="12">
                                                <span class="mr-1">Supply chart: </span>
                                                <div>

                                                    <vue-apex-charts type="pie" height="300"
                                                        :options="supplyChart.chartOptions"
                                                        :series="supplyChart.series" />
                                                </div>
                                            </b-col>
                                            <b-col v-if="   vestingDataChart.xaxis.categories.length>0">
                                                <span class="mr-1">Vesting Chart: </span>


                                                <vue-apex-charts class="full" width="100%" :dataLabels="true"
                                                    type="area" height="290" :options="vestingDataChart"
                                                    :series="vestingDataSerice">
                                                </vue-apex-charts>
                                            </b-col>

                                        </b-row>

                                    </b-card-body>
                                </b-card>
                            </app-collapse-item>
                            <app-collapse-item class="w-100" v-if="TradeHistoryseries[0].data.length>0"
                                title="Trading Volume History">
                                <div>
                                    <vue-apex-charts class="full" width="100%" :dataLabels="true" type="line"
                                        height="290" :options="TradeHistoryOptions" :series="TradeHistoryseries">
                                    </vue-apex-charts>
                                </div>
                            </app-collapse-item>

                        </app-collapse>
                    </div>
                    <div class="details-modal-container" :class="{'loadingModal':!detailsModalLoaded}"
                        v-if="!detailsModalLoaded">
                        <div class="w-full justify-content-between d-flex  h-[70vh]"
                            style="margin-top: 10px; margin-left: 10px;">
                        </div>
                    </div>
                </b-overlay>
            </template>
        </b-modal>

        <b-modal id="modal-preset-create" :hide-footer="true" :hide-header="true" v-if="activeData" centered size="md"
            title="" style="background: transparent !important;">
            <div style="border-radius:10px;">
                <template>
                    <div style="font-family: 'Poppins-Light'; padding:20px; margin-top:10px;
                            font-style: normal;
                            font-weight: 500;
                            font-size: 20px;
                            line-height: 14px;">
                        Filter Preset Name:
                    </div>

                    <div style="margin:0px 28px 0px 28px;">
                        <b-row>
                            <b-col cols="12" style="margin-bottom:16px;">
                                <b-form-input v-model="presetName" />
                                <small class="text-danger" v-if="checkExist(presetName)">Preset filter with given name
                                    already exists! Please give different name.!</small>
                            </b-col>
                            <b-col cols="12" style="margin-bottom:20px;">
                                <b-button class="darkBlackText darkWhiteBackground"
                                    :disabled="!presetName || presetName.trim().length<=0 || checkExist(presetName)"
                                    size="md" @click="createPresetFilter" v-ripple.400="'rgba(11, 12, 240, 0.15)'"
                                    style="float:right;" variant="outline-primary" pill>Create
                                </b-button>
                            </b-col>
                        </b-row>
                    </div>
                </template>

            </div>


        </b-modal>

    </div>
</template>

<script>
    import {
        BTable,
        BTabs,
        BTab,
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
        BDropdownForm,
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
        BOverlay,
        VBPopover,
        VBTooltip
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import axios from '@axios'
    import {
        VueSvgGauge
    } from 'vue-svg-gauge';
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
    import store from '@/store/index'

    import {
        getUserData
    } from '@/auth/utils'
    import Cleave from 'vue-cleave-component'
    // eslint-disable-next-line import/no-extraneous-dependencies
    import 'cleave.js/dist/addons/cleave-phone.us'
    import 'bootstrap-icons/font/bootstrap-icons';
    import 'bootstrap-icons/font/bootstrap-icons.css';
    import flatPickr from 'vue-flatpickr-component'
    export default {
        components: {
            BTable,
            BTabs,
            BFormCheckbox,
            BTab,
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
            BDropdownForm,
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
            VueSlider,
            VBPopover,
            Cleave,
            flatPickr

        },
        data() {
            return {
                oBarMinValue: 10,
                oBarMaxValue: 90,
                NumberFormaVal: {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                },
                stickyHeader: true,
                true: false,
                loaded: false,
                loadedData: false,
                fields: fieldsData,
                items: [],
                favorites: [],
                pricesWs: null,
                coinsStr: '',
                Cpagpage: 1,
                sortKey: '',
                sortBy: '',
                isBusy: true,
                showEmpty:false,
                emptyText: 'There are no records to show',
                locked: false,
                value_2: [0, 50],
                params: {
                    filters: [],
                    filters2: "",
                    sort: ["market_cap_rank", "asc"],
                    api_mode: 1,
                    favoritesMode: 0,
                    perpage: 50,
                },
                perPageOptions: [5, 6, 8, 9, 10, 20, 30, 50, 100],
                fag: {
                    data: {
                        fear_greed_index: 0,
                        fear_greed_classification: ''
                    }
                },
                selectedContract: null,
                spLineStyles: {
                    stroke: '#c7361c',

                },
                chartOptions: {

                    fill: {
                        colors: ['#F44336', '#E91E63', '#9C27B0']
                    },

                    chart: {
                        id: 'history-chart'
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#78909C',
                            }
                        },

                    },

                    xaxis: {
                        categories: [],
                        type: 'datetime',
                        tickPlacement: 'between',
                        labels: {
                            show: true,
                            rotateAlways: false,
                            maxHeight: 120,
                            style: {
                                colors: '#78909C',
                                fontSize: '12px',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 400,
                                cssClass: 'apexcharts-xaxis-label',
                            },
                            offsetX: 0,
                            offsetY: 0,

                        },
                    },
                    tooltip: {
                        style: {
                            colors: '#78909C',

                        },
                        shared: false,
                        x: {
                            format: "dd.MM.yyyy"
                        }
                    },
                    colors: ['#fca503'],

                },
                TradeHistoryOptions: {
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#78909C',
                            }
                        },

                    },
                    chart: {
                        id: 'trading-history',
                        height: 290,
                        background: '#54b9eb'
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#78909C',
                            }
                        },
                        categories: [],
                        type: 'datetime',
                    },

                    colors: ['#54b9eb'],
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        lineCap: 'butt',
                        width: 1,
                        dashArray: 0,
                        labels: {
                            show: true,
                            hideOverlappingLabels: true,
                        }
                    },
                    tooltip: {
                        style: {
                            colors: '#78909C',

                        },
                        shared: false,
                        x: {
                            format: "dd.MM.yyyy HH:mm"
                        }
                    },

                },
                seven_DaysChartseries: [{
                    name: '7 Days History',
                    data: []
                }],
                seven_DaysChart: {

                    chart: {
                        toolbar: {
                            show: false,
                        },
                        id: '7days-history',
                        height: 290,
                        foreColor: 'black'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#50DC5F'],
                    fill: {
                        shade: 'dark',
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            gradientToColors: ['#50DC5F 30%'],
                            stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        axisBorder: {
                            show: true,
                            color: '#78909C',
                            offsetX: 0,
                            offsetY: 0
                        },
                        labels: {
                            show: true,
                            style: {
                                colors: '#78909C',
                            },
                            x: {
                                format: "dd.MM.yyyy HH:mm"
                            }
                        },
                        categories: [],
                        type: 'datetime',
                    },

                    grid: {
                        show: true,
                        borderColor: '#424244',
                        strokeDashArray: 0,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        row: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        column: {
                            colors: undefined,
                            opacity: 0.5
                        },

                    },
                    yaxis: {
                        axisBorder: {
                            show: true,
                            color: '#78909C',
                            offsetX: 0,
                            offsetY: 0
                        },
                        type: "value",
                        labels: {
                            show: true,
                            style: {
                                colors: '#78909C',
                            },
                            formatter: function (value) {
                                return value.toFixed(2);
                            }
                        },
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        lineCap: 'butt',
                        width: 2,
                        dashArray: 0,
                        labels: {
                            show: true,
                            hideOverlappingLabels: true,
                        }
                    },
                    tooltip: {
                        style: {
                            colors: '#78909C',

                        },
                        shared: false,
                        y: {
                            formatter: function (value) {
                                return new Intl.NumberFormat('en-US', {
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 15,
                                }).format(value);
                            }
                        },
                        x: {
                            format: "dd.MM.yyyy HH:mm"
                        }

                    },

                },
                vestingDataSerice: [{
                    name: '7 Days History',
                    data: []
                }],
                vestingDataChart: {

                    chart: {
                        toolbar: {
                            show: false,
                        },
                        id: '7days-history',
                        height: 290,
                        foreColor: 'black',
                        stacked: true,
                    },
                    dataLabels: {
                        enabled: false
                    },
                    colors: ['#50DC5F', '#9351db', '#51b8db', '#0e181c', '#718187', '#e5a0bd', '#8ca837', '#bcf21a',
                        '#d35a2a', '#f4e111'
                    ],

                    fill: {
                        // shade: 'dark',
                        // type: 'gradient',
                        gradient: {
                            // shadeIntensity: 1,
                            // opacityFrom: 0.7,
                            // gradientToColors: ['#50DC5F 30%'],
                            // stops: [0, 90, 100]
                        }
                    },
                    xaxis: {
                        axisBorder: {
                            show: true,
                            color: '#78909C',
                            offsetX: 0,
                            offsetY: 0
                        },
                        labels: {
                            show: true,
                            style: {
                                colors: '#78909C',
                            },
                            x: {
                                format: "dd.MM.yyyy HH:mm"
                            }
                        },
                        categories: [],
                        type: 'datetime',
                    },

                    grid: {
                        show: true,
                        borderColor: '#424244',
                        strokeDashArray: 0,
                        position: 'back',
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                        yaxis: {
                            lines: {
                                show: true
                            }
                        },
                        row: {
                            colors: undefined,
                            opacity: 0.5
                        },
                        column: {
                            colors: undefined,
                            opacity: 0.5
                        },

                    },
                    yaxis: {
                        axisBorder: {
                            show: true,
                            color: '#78909C',
                            offsetX: 0,
                            offsetY: 0
                        },
                        type: "value",
                        labels: {
                            show: true,
                            style: {
                                colors: '#78909C',
                            },
                            formatter: function (value) {
                                return value.toFixed(0);
                            }
                        },
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        lineCap: 'butt',
                        width: 2,
                        dashArray: 0,
                        labels: {
                            show: true,
                            hideOverlappingLabels: true,
                        }
                    },
                    tooltip: {
                        // style: {
                        //     colors: '#78909C',

                        // },
                        // shared: false,
                        // y: {
                        //     formatter: function (value) {
                        //         return new Intl.NumberFormat('en-US', {
                        //             minimumFractionDigits: 0,
                        //             maximumFractionDigits: 15,
                        //         }).format(value);
                        //     }
                        // },
                        // x: {
                        //     format: "dd.MM.yyyy HH:mm"
                        // }
                        x: {
                            show: true,
                            format: 'dd MMM yyyy',
                            formatter: undefined,
                        },

                    },

                },

                supplyChart: {
                    series: [],

                    chartOptions: {
                        tooltip: {
                            enabled: true,
                            custom: function ({
                                series,
                                seriesIndex,
                                dataPointIndex,
                                w
                            }) {
                                let total = 0;
                                for (let x of series) {
                                    total += x;
                                }
                                let selected = series[seriesIndex]
                                return w.config.labels[seriesIndex] + ": " + selected + "(" + (selected / total *
                                    100).toFixed(2) + "%)";
                            }
                        },
                        chart: {
                            width: 300,
                            type: 'pie',
                        },
                        legend: {
                            show: true,
                            position: 'bottom',
                            fontSize: '14px',
                            fontFamily: 'Montserrat',
                            colors: '#00d4bd',
                            labels: {
                                show: true,
                                colors: '#78909C',
                            },
                        },


                        colors: [
                            '#00d4bd',
                            '#826bf8',
                            '#2b9bf4',
                            '#FFA1A1',
                        ],
                        dataLabels: {
                            enabled: true,
                            formatter(val) {
                                // eslint-disable-next-line radix
                                return `${parseInt(val)}%`
                            },
                        },

                        labels: ['Locked', 'Unlocked', 'Next Unlock'],
                        responsive: [{
                                breakpoint: 992,
                                options: {
                                    chart: {
                                        height: 380,
                                    },
                                    legend: {
                                        position: 'bottom',
                                    },
                                },
                            },

                        ],
                    },
                },
                series: [{
                    name: 'Fear Greed Index',
                    data: []
                }],

                TradeHistoryseries: [{
                    name: 'Trading Volume',
                    data: []
                }],
                searchKey: null,
                filterKey: filterFields,
                filtered: false,
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
                        value: 'big',
                        text: 'BIG'
                    },
                ],
                activeData: {
                    notified: false,
                },
                notified: false,
                fagLoad: false,
                userData: null,
                presetName: null,
                presetFilters: [],
                selectedPreset: null,
                selectedPresetData: null,
                mi_fear_greed: true,
                mi_fear_nft: true,
                mi_fear_btc_in_out: true,
                mi_fear_btc_alt: true,
                column_form: {
                    table_fields: [],
                    market_indicators: [],
                },
                loadedFields: {},
                all_coins_mode: true,
                unlocking_mode: false,
                //slider value

                // filterKey.min_market_cap,
                // filterKey.max_market_cap,
                // filterKey.min_current_price,
                // filterKey.max_current_price,
                // filterKey.min_circulating_supply,
                // filterKey.max_circulating_supply,
                // filterKey.min_total_supply,
                // filterKey.max_total_supply,
                // filterKey.min_market_cap_rank,
                // filterKey.max_market_cap_rank,
                // filterKey.min_trading_volume,
                // filterKey.max_trading_volume,
                // filterKey.min_roi_percentage,
                // filterKey.max_roi_percentage,
                // filterKey.min_roi_times,
                // filterKey.max_roi_times,
                // filterKey.min_price_change_percentage_24h,
                // filterKey.max_price_change_percentage_24h,
                // filterKey.min_genesis_date,
                // filterKey.max_genesis_date,
                // filterKey.min_total_supply_percent,
                // filterKey.max_total_supply_percent,
                // filterKey.min_seed_price,
                // filterKey.max_seed_price,
                // filterKey.min_roi_seed,
                // filterKey.max_roi_seed,
                // filterKey.coin_platform,
                // filterKey.keywords,
                // filterKey.coin_category,
                // filterKey.min_average_sentiment_change,
                // filterKey.max_average_sentiment_change,
                // filterKey.min_social_mentions_change,
                // filterKey.max_social_mentions_change,
                // filterKey.min_social_engagement_change,
                // filterKey.max_social_engagement_change,
                // filterKey.min_average_sentiment,
                // filterKey.max_average_sentiment,
                // filterKey.min_total_locked,
                // filterKey.max_total_locked,
                // filterKey.next_unlock_status,
                // filterKey.min_next_unlock_number_of_tokens,
                // filterKey.max_next_unlock_number_of_tokens,
                // filterKey.min_next_unlock_percent_of_tokens,
                // filterKey.max_next_unlock_percent_of_tokens,
                // filterKey.next_unlock_size,
                // filterKey.min_three_months_unlock_number_of_tokens,
                // filterKey.max_three_months_unlock_number_of_tokens,
                // filterKey.min_three_months_unlock_percent_of_tokens,
                // filterKey.max_three_months_unlock_percent_of_tokens,
                // filterKey.three_months_unlock_size,
                // filterKey.min_six_months_unlock_number_of_tokens,
                // filterKey.max_six_months_unlock_number_of_tokens,
                // filterKey.min_six_months_unlock_percent_of_tokens,
                // filterKey.max_six_months_unlock_percent_of_tokens,
                // filterKey.six_months_unlock_size,

                ldot: 25,
                rdot: 75,

                ldot1: 25,
                rdot1: 75,

                ldot2: 25,
                rdot2: 75,

                ldot3: 25,
                rdot3: 75,

                ldot4: 25,
                rdot4: 75,

                ldot5: 25,
                rdot5: 75,

                ldot6: 25,
                rdot6: 75,

                ldot7: 1,
                rdot7: 5,

                ldot8: 25,
                rdot8: 75,

                ldot9: 25,
                rdot9: 75,

                ldot10: 25,
                rdot10: 75,
                dir: 'ltr',


                notifiedType: '',
                detailsModalLoaded: false,
                favoritised:false,
                emptyTextVal:'There are no records to show'
                //end

            }

        },
        directives: {
            'b-modal': VBModal,
            'b-toggle': VBToggle,
            'b-popover': VBPopover,
            'b-tooltip': VBPopover,
            Ripple,

        },
        methods: {
            closeDropDown() {

                this.$refs.dropdownpreset.hide(true)
            },
            check(str) {

                if (str.length > 8) return true;
                else false;
            },

            say(message) {
                alert("Please connect your metamask")
            },
            manageFavorite(index, coin_id, symbol,name) {

                axios.post('api/manage-favorites', {
                    coin_id: coin_id,
                    symbol: symbol
                }).then(res => {

                    if (res.data.status == true && res.data.favorite == 'added') {
                        this.favorites.push(res.data.favorites)
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: ''+name+' added to your favorite list',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                     })

                    } else if (res.data.status == true && res.data.favorite == 'removed') {
                    
                        let i = this.favorites.findIndex((item) => {
                            return item.coinid == coin_id && item.coin_symbol == symbol
                        })
                        if (i > -1) {
                          
                            this.favorites.splice(i, 1);
                           if(this.params.favoritesMode == 1)
                           {
                            let j = this.items.data.findIndex((item) => {
                                    return item.coin_id == coin_id && item.symbol == symbol
                                })
                                this.items.data.splice(j, 1);
                           }
                            this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: ''+name+' removed from your favorites list',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                     })
                        }

                    }

                })

            },
            enableFavorites()
            {
                this.params.favoritesMode = 1;
                this.loadCoins(false);
                this.favoritised = true;
            },
            disableFavorites()
            {
                this.params.favoritesMode = 0;
                this.loadCoins(false);
                this.favoritised = false;
            },
            exitfavorites()
            {
                this.params.favoritesMode = 0;
                this.favoritised = false;
                this.loadCoins(true);
            },
            checkFavoriteList(index, coin_id, symbol) {
                var exists = this.favorites.some(function (field) {
                    if (field.coin_symbol == symbol && field.coinid == coin_id) {
                        return true;
                    }
                });

                if (exists) {
                    return true;
                } else {
                    return false;
                }
            },
            // update_oBarValues(e) {
            //     filterKey.min_market_cap = e.minValue;
            //     filterKey.max_market_cap = e.maxValue;
            // },
            loadCoins(filterModalClose) {
                if(!filterModalClose)
                {
                    this.$bvModal.hide('modal-filters');
                }
                this.isBusy = true;
                this.showEmpty = false;
                this.loadedData = false;
                axios.post('api/get_coins?page=' + this.Cpagpage, JSON.stringify(this.params)).then(res => {
                    if (res.data.tokens.data) {
                        this.items = res.data.tokens;
                        this.favorites = res.data.favorites;
                        this.loadedData = true;
                        setTimeout(() => {
                        }, 2000);
                    }
                    this.isBusy = false;

                    this.showEmpty = true;

                    if(this.params.favoritesMode == 1)
                    {
                        this.emptyText ="There are no favorites in your list yet";
                    }else{
                        this.emptyText ="There are no records to show";
                    }
                    this.isBusy = false;

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
                            // var d = new Date(parseInt(element.timestamp) * 1000);
                            // let date = d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
                            // array.unshift(date);
                            // this.chartOptions.xaxis.categories = array;
                            this.series[0].data.unshift([parseInt(element.timestamp) * 1000,
                                parseInt(
                                    element.value)
                            ])

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
                var moreTags = "";
                const tagsArray = val.split("|");
                var index = 0;
                for (index = 0; index <= 1; index++) {
                    if (index == 1) break;
                    if (tagsArray[index] != undefined && tagsArray[index] != "")
                        tags = tags +
                        ' <div class="d-block " style="margin-bottom:1px;"><span class="" style="padding:5px; font-size:14px;">' +
                        tagsArray[index] + '</span></div>';
                }
                return tags;
            },
            checkSeemore(val) {
                const tagsArray = val.split("|");

                if (tagsArray.length > 2) {
                    return true;

                }
                return false;
            },
            platformTagsSeemore(val) {
                var tags = "";
                const tagsArray = val.split("|");
                for (let index = 0; index <= tagsArray.length; index++) {
                    if (tagsArray[index] != undefined && tagsArray[index] != "")
                        tags = tags +
                        tagsArray[index] + ", ";
                }
                tags = tags.trim().replace(/,*$/, '');
                return tags;

            },
            roundData(val) {
                if (val) {
                    return this.toInterNationalNumber(parseFloat(val).toFixed(2));
                }
            },
            roundData2(val, len) {
                if (val) {
                    return parseFloat(val).toFixed(len);
                }
            },
            dateFormat2(val) {
                let d = new Date(val)
                if (!isNaN(d)) {
                    return d.getDate() + '.' + (d.getMonth() + 1) + '.' + d.getFullYear();
                }
            },
            dateFormat3(val) {
                if (val != null) {
                    let d = new Date(val)
                    if (!isNaN(d)) {
                        return [d.getMonth() + 1,
                            d.getDate(),
                            d.getFullYear()
                        ].join('.') + ' ' + [d.getHours() == 0 ? '00' : d.getHours(),
                            d.getMinutes() == 0 ? '00' : d.getMinutes(),
                            d.getSeconds() == 0 ? '00' : d.getSeconds()
                        ].join(':');
                    }
                }

            },
            getTimeStamp(data) {
                let d = new Date(data);
                if (data != null && !isNaN(d)) {
                    return d.getTime();
                } else {
                    return new Date().getTime();;
                }
            },
            notifyMe(symbol, type) {

                axios.post('api/notify-unlock-token', {
                    symbol: symbol,
                    type: type
                }).then(res => {

                    if (res.data.status == true) {
                        if (res.data.notification == 'sent') {
                            this.notified = true;
                        } else {
                            this.notified = false;
                        }
                        this.notifiedType = type;
                    }

                })


            },
            notifyList(item) {
                switch (item) {
                    case '1-month-before':
                        return '1 month before'
                        break;
                    case '2-weeks-before':
                        return '2 weeks before'
                        break;
                    case '1-week-before':
                        return '1 week before'
                        break;
                    case '2-days-before':
                        return '2 days before'
                        break;
                    case '12-hours-before':
                        return '12 hours before'
                        break;
                    case '10-min-before':
                        return '10 minutes before'
                        break;
                    case 'on-time':
                        return 'On time'
                        break;
                    default:
                        break;
                }
            },
            checkdateinertval(date, date_text, type) {
                let realDate;
                var d1 = new Date();

                if (date) {
                    realDate = date;
                } else if (date_text) {
                    let textMonth = date_text.slice(date_text.lastIndexOf(' ') + 1);
                    let reaStrDate = textMonth + " 1, " + d1.getFullYear() + " 00:00:00";
                    realDate = new Date(reaStrDate);
                }
                var d2 = new Date(realDate);
                var Difference_In_Time = d2.getTime() - d1.getTime();
                var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                var diff = (Difference_In_Time) / 1000;
                diff /= 60;
                let Difference_In_Time_In_Minutes = Math.abs(Math.round(diff));
                if (type == '1-month-before') {

                    if (Difference_In_Days >= 30) {
                        return true;
                    } else {
                        return false
                    }
                }
                if (type == '2-weeks-before') {

                    if (Difference_In_Days >= 14) {
                        return true;
                    } else {
                        return false
                    }
                } else if (type == '1-week-before') {
                    if (Difference_In_Days >= 7) {
                        return true;
                    } else {
                        return false
                    }
                } else if (type == '2-days-before') {

                    if (Difference_In_Days >= 2) {
                        return true;
                    } else {
                        return false
                    }
                } else if (type == '12-hours-before') {

                    if (Difference_In_Time_In_Minutes >= 720) {
                        return true;
                    } else {
                        return false
                    }
                } else if (type == '10-min-before') {

                    if (Difference_In_Time_In_Minutes >= 10) {
                        return true;
                    } else {
                        return false
                    }
                } else if (type == 'on-time') {
                    return true
                } else {
                    return false
                }

            },
            validateDateRange(date_text, date) {
                let realDate;
                var d1 = new Date();
                if (date != null) {
                    realDate = date;
                } else if (date_text != null) {
                    let textMonth = date_text.slice(date_text.lastIndexOf(' ') + 1);
                    let reaStrDate = textMonth + " 1, " + d1.getFullYear() + " 00:00:00";
                    realDate = new Date(reaStrDate);

                } else {
                    return false
                }
                var d2 = new Date(realDate);
                if (d2.getTime() > d1.getTime()) {
                    return true;
                } else {
                    return false;
                }

            },
            getDateAndTime(date, type) {

                if (date != null) {
                    let d = new Date(date)
                    const monthNames = ["Jan", "Feb", "March", "April", "May", "June",
                        "July", "Aug", "Sep", "Oct", "Nov", "Dec"
                    ];
                    if (!isNaN(d)) {
                        if (type == 'date') {
                            return [
                                d.getDate(), monthNames[d.getMonth()],
                                d.getFullYear()
                            ].join(' ');
                        } else if (type == 'time') {
                            return [d.getHours() == 0 ? '00' : d.getHours(),
                                d.getMinutes() == 0 ? '00' : d.getMinutes(),
                                d.getSeconds() == 0 ? '00' : d.getSeconds(),
                            ].join(':');
                        }
                    }
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
            toInterNationalNumber(val) {
                if (val)
                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
            },
            priceConversation(val) {

                if (1 > parseInt(val)) {
                    return parseFloat(val).toFixed(6);
                } else {
                    val = parseFloat(val).toFixed(2);
                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
                }

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

                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(checkval);
                }

            },
            checkUserPlan(val) {
                if (this.userData.currentPlan == 'free' && val < 1 || this.userData.currentPlan == 'free' &&
                    val >=
                    5) {
                    return true;
                } else {
                    return false;
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



                this.loadCoins(false);
            },
            widthSetting(index) {
                if (this.visibleFields[this.visibleFields.length - 1].index == index) {
                    return true;
                } else {
                    return false;
                }
            },
            filterCoins(refresh_flag) {
                this.filtered = true;
                this.isBusy = true;
                this.params.filters = [];
                if (this.filterKey.min_market_cap) {
                    this.params.filters.push(["market_cap", ">=", this.filterKey.min_market_cap.replaceAll(",",
                        "")]);
                }
                if (this.filterKey.max_market_cap) {
                    this.params.filters.push(["market_cap", "<=", this.filterKey.max_market_cap.replaceAll(",",
                        "")]);
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
                    this.params.filters.push(["circulating_supply", ">=", this.filterKey
                        .min_circulating_supply
                    ]);
                }
                if (this.filterKey.max_circulating_supply) {
                    this.params.filters.push(["circulating_supply", "<=", this.filterKey
                        .max_circulating_supply
                    ]);
                }
                if (this.filterKey.coin_category && this.filterKey.coin_category != '') {
                    this.params.filters.push(["coin_category", "like", "%" + this.filterKey.coin_category +
                        "%"
                    ]);
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
                    this.params.filters.push(["coin_description", "like", "%'" + this.filterKey.keywords +
                        "'%"
                    ]);
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
                    this.params.filters.push(["total_supply_percent", ">=", this.filterKey
                        .min_total_supply_percent
                    ]);
                }

                if (this.filterKey.max_total_supply_percent) {
                    this.params.filters.push(["total_supply_percent", "<=", this.filterKey
                        .max_total_supply_percent
                    ]);
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
                    this.params.filters.push(["next_unlock_size", "like", "%" + this.filterKey
                        .next_unlock_size + "%"
                    ]);
                }

                if (this.filterKey.next_unlock_date) {
                    let dates = this.filterKey.next_unlock_date.split(" to ");
                    this.params.filters.push(["next_unlock_date", ">=", dates[0]]);
                    this.params.filters.push(["next_unlock_date", "<=", dates[1]]);
                    // this.params.filters.push(["next_unlock_date BETWEEN "+dates[0]+" AND "+dates[1]+""]);
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
                    this.loadCoins(false);
                } else {
                    this.isBusy = false;
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
                    this.isBusy = true;
                    this.loadCoins(false);
                    this.selectedPreset = null;
                    this.selectedPresetData = null;

                } else {
                    this.isBusy = false;

                }
                this.filtered = false;
            },
            async detailsModel(item) {
                this.detailsModalLoaded = false;
                this.$bvModal.show('modal-details');

                this.notified = false;
                this.selectedContract = null;
                this.supplyChart.series = [];
                this.TradeHistoryOptions.xaxis.categories = [];
                this.vestingDataChart.xaxis.categories = [];
                this.seven_DaysChartseries[0].data = [];
                this.vestingDataSerice = [];
                let sparklines = item.sparkline_in_7d.split("|").map(Number);
                sparklines = sparklines.slice(0, -1);

                for (let i = 0; i < 7; i++) {
                    for (let j = 0; j <= 23; j++) {
                        var d = new Date();
                        d.setUTCHours(0, 0, 0, 0);
                        d.setDate(d.getDate() - i);
                        d.setHours(d.getHours() - j);
                        this.seven_DaysChart.xaxis.categories.unshift(d.getTime());
                    }
                }
                this.seven_DaysChartseries[0].data = sparklines;
                if (typeof item.contract_address == 'string') {
                    item.contract_address = JSON.parse(item.contract_address);
                }

                this.activeData = item;
                await axios.post('api/check-coin-notified', {
                        symbol: item.symbol,
                    })
                    .then(res => {
                        if (res.data.notification == 'sent') {
                            this.notified = true;
                            this.notifiedType = res.data.item.data.type;
                        } else {
                            this.notified = false;
                        }
                    })

                await axios.post('api/get_trading_volume_history', {
                        coin_id: item.coin_id,
                        symbol: item.symbol
                    })
                    .then(res => {
                        this.TradeHistoryOptions.xaxis.categories = [];
                        this.TradeHistoryseries[0].data = [];
                        if (res.data[0] && res.data[0].trading_volume_history_json) {
                            this.activeData.trading_volume_history_json = JSON.parse(res.data[0]
                                .trading_volume_history_json);
                            if (this.activeData.trading_volume_history_json.total_volumes) {
                                this.activeData.trading_volume_history_json.total_volumes.forEach(
                                    element => {
                                        this.TradeHistoryseries[0].data.push([parseInt(element[0]),
                                            parseInt(
                                                element[1])
                                        ])
                                    })
                            }


                        }
                        if (this.activeData.max_supply != null || this.activeData.circulating_supply !=
                            null ||
                            this
                            .activeData.next_unlock_number_of_tokens != null ||
                            this.activeData.three_months_unlock_number_of_tokens != null && this
                            .activeData
                            .six_months_unlock_number_of_tokens != null) {
                            var ms = parseFloat(this.activeData.max_supply);
                            if (isNaN(ms))
                                ms = 0.0;
                            var cs = parseFloat(this.activeData.circulating_supply);
                            if (isNaN(cs))
                                cs = 0.0;

                            var nt = parseFloat(this.activeData.next_unlock_number_of_tokens);
                            if (isNaN(nt))
                                nt = 0.0;
                            var val1 = Math.max(ms - cs - nt, 0.0);
                            var val2 = cs;
                            var val3 = nt;
                            this.supplyChart.series = [val1, val2, val3];

                        }


                    })
                //vesting Chart 
                if (item.vesting_chart) {
                    let vestingData = JSON.parse(item.vesting_chart);
                    let keys = Object.keys(vestingData[0])
                    var filteredArray = keys.filter(function (e) {
                        return e !== 'name'
                    })
                    //   filteredArray.forEach((element,index) => {
                    //     this.vestingDataSerice[index] = {};
                    //     this.vestingDataSerice[index].name = element;
                    //     this.vestingDataSerice[index].data = [];
                    //   });
                    //   vestingData.forEach((element,index) => {
                    //     console.log(element);
                    //  });
                    let dataval = [];
                    filteredArray.forEach((element, index) => {
                        this.vestingDataSerice[index] = {};
                        this.vestingDataSerice[index].name = element;
                        let oData = vestingData.map(item => item[element]);
                        this.vestingDataSerice[index].data = oData;
                    });

                    vestingData.forEach(element => {
                        const date = new Date(element.name);
                        const timestamp = date.getTime();
                        this.vestingDataChart.xaxis.categories.push(timestamp);
                    });
                    //   console.log(this.vestingDataSerice);
                }
                this.detailsModalLoaded = true;

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
                let dta = this.items;
                this.pricesWs.onmessage = function (msg) {
                    let coinFetched = JSON.parse(msg.data);
                    let objKeys = Object.keys(coinFetched);

                    objKeys.forEach(element => {
                        let index = thisScope.items.data.findIndex(x => x.coin_id == element)
                        if (thisScope.items.data[index]) {
                            let oldVal = thisScope.items.data[index].current_price;
                            thisScope.items.data[index].current_price = coinFetched[element];
                            if (oldVal < coinFetched[element]) {
                                thisScope.items.data[index].flash = 1;
                                setTimeout(() => {
                                    if(thisScope.items.data[index])
                                    {
                                    thisScope.items.data[index].flash = 3;

                                    }
                                }, 1000);

                            } else {
                                thisScope.items.data[index].flash = 2;
                                setTimeout(() => {
                                     if(thisScope.items.data[index])
                                    {
                                    thisScope.items.data[index].flash = 3;
                                    }
                                }, 1000);
                            }
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
            checkString(val) {
                if (typeof val == 'string') {
                    return true;
                }
                return false;
            },
            kFormatter(num) {
                return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' :
                    Math
                    .sign(
                        num) * Math.abs(num)
            },
            lockedFilter() {
                if (this.params.api_mode == 2) {
                    this.params.api_mode = 1;
                    this.locked = false;
                    this.all_coins_mode = true;
                    this.unlocking_mode = false;
                } else {
                    this.locked = true;
                    this.params.api_mode = 2;
                    this.all_coins_mode = false;
                    this.unlocking_mode = true;
                }
                this.loadFileds();
                this.loadCoins(false);
            },
            async createPresetFilter() {
                await this.filterCoins(false);

                let presetPayload = {
                    filters: this.params.filters,
                    filters2: this.params.filters2,
                    filter_name: this.presetName
                }

                axios.post('api/create_preset_filter', JSON.stringify(presetPayload)).then(res => {
                    if (res) {
                        this.presetFilters = res.data;
                        let updated_val = res.data.filter(field => {
                            return field.preset_name == this.presetName
                        })

                        this.selectedPreset = updated_val[0].id;
                        this.selectedPresetData = updated_val[0];
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


            },
            async savePresetFilter() {
                await this.filterCoins(false);
                let index = this.presetFilters.map(item => item.id).indexOf(this.selectedPreset);
                this.presetName = this.presetFilters[index].preset_name
                let presetPayload = {
                    filters: this.params.filters,
                    filters2: this.params.filters2,
                    filter_name: this.presetName
                }

                axios.post('api/create_preset_filter', JSON.stringify(presetPayload)).then(res => {
                    if (res) {
                        this.presetFilters = res.data;

                        let updated_val = res.data.filter(field => {
                            return field.preset_name == this.presetName
                        })

                        this.selectedPreset = updated_val[0].id;
                        this.presetName = "";
                        this.$bvModal.hide('modal-preset-create');
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Preset has been updated',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                    }

                })


            },
            checkDefault(val) {
                let index = this.presetFilters.map(item => item.id).indexOf(val);
                var retVal = this.presetFilters[index].default;
                if (retVal == 1) {
                    return false;
                } else {
                    return true;
                }
            },
            checkExist(val) {
                if (val && val.trim().length > 0) {
                    let checkval = this.presetFilters.filter(field => {
                        return field.preset_name == val
                    })
                    if (checkval.length > 0) {
                        return true;
                    } else {
                        return false
                    }

                }
                return false;
            },
            deletePreset(id) {
                if (id == null || id == undefined) {
                    id = this.selectedPreset;
                }
                axios.post('api/delete_preset_filter', {
                    preset_id: id
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
                        if (element[0] == "coin_platform" || element[0] ==
                            "coin_category" ||
                            element[0] ==
                            "three_months_unlock_size" || element[0] ==
                            "next_unlock_size" ||
                            element[0] ==
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

            },
            selectPreset(preset) {
                this.selectedPresetData = preset;
                this.selectedPreset = preset.id;
                this.closeDropDown();

            },
            clearPreset() {
                this.selectedPreset = null
                this.closeDropDown();
            },
            updateFields() {
                let mode = 'all';
                if (this.params.api_mode != 1) {
                    mode = 'unlock';
                }

                this.column_form.table_fields = [];
                this.column_form.market_indicators = [];
                if (this.params.api_mode == 1) {
                    this.fields.forEach(element => {
                        if (element.canHide == true) {
                            if (element.filterColumn == true) {
                                this.column_form.table_fields.push(element.key)
                            }
                        }

                    });
                } else {
                    this.fields.forEach(element => {
                        if (element.visible == 3 || element.canHide == true && element
                            .visible == 2) {
                            if (element.filterColumn == true) {
                                this.column_form.table_fields.push(element.key)
                            }
                        }

                    });
                }
                if (this.mi_fear_greed == true) {
                    this.column_form.market_indicators.push('mi_fear_greed')
                }
                if (this.mi_fear_nft == true) {
                    this.column_form.market_indicators.push('mi_fear_nft')
                }
                if (this.mi_fear_btc_in_out == true) {
                    this.column_form.market_indicators.push('mi_fear_btc_in_out')
                }
                if (this.mi_fear_btc_alt == true) {
                    this.column_form.market_indicators.push('mi_fear_btc_alt')
                }

                let log = JSON.stringify(this.column_form);
                axios.post('api/update-visible-fields', {
                    fields: JSON.stringify(this.column_form),
                    mode: mode
                }).then(res => {
                    if (res.data.status == true) {
                        this.loadedFields = res.data.fields
                    }
                })


            },
            loadFileds() {
                let mode = 'all';
                if (this.params.api_mode != 1) {
                    mode = 'unlock';
                }
                axios.post('api/load-visible-fileds', {
                    mode: mode
                }).then(res => {
                    if (res.data.status == true) {
                        this.loadedFields = res.data.fields;

                        if (this.params.api_mode != 1) {
                            this.fields[0].filterColumn = true;
                            this.fields[20].filterColumn = false;
                            this.fields[21].filterColumn = false;
                            this.fields[26].filterColumn = false;
                            this.fields[27].filterColumn = false;
                            this.fields[22].filterColumn = false;
                            this.fields[23].filterColumn = false;
                            this.fields[24].filterColumn = false;
                            this.fields[25].filterColumn = false;
                            this.fields[26].filterColumn = false;
                            this.fields[27].filterColumn = false;
                            this.fields[28].filterColumn = false;
                            this.fields[29].filterColumn = false;
                            this.fields[30].filterColumn = false;
                            this.fields[31].filterColumn = false;
                            this.fields[32].filterColumn = false;
                            this.fields[33].filterColumn = false;

                        } else {
                            this.fields[0].filterColumn = false;
                            this.fields[20].filterColumn = true;

                            this.fields[22].filterColumn = true;
                            this.fields[23].filterColumn = true;
                            this.fields[24].filterColumn = true;
                            this.fields[25].filterColumn = true;

                            this.fields[28].filterColumn = true;
                            this.fields[29].filterColumn = true;
                            this.fields[30].filterColumn = true;
                            this.fields[31].filterColumn = true;
                            this.fields[32].filterColumn = true;
                            this.fields[33].filterColumn = true;

                        }
                        this.fields[38].filterColumn = true;
                        this.fields.forEach(element => {
                            if (this.loadedFields.table_fields.includes(element
                                    .key)) {
                                element.filterColumn = true;
                            } else {
                                if (element.canHide) {
                                    element.filterColumn = false;
                                }
                            }
                        });


                        if (this.loadedFields.market_indicators.includes('mi_fear_greed')) {
                            this.mi_fear_greed = true;
                        } else {
                            this.mi_fear_greed = false;
                        }
                        if (this.loadedFields.market_indicators.includes('mi_fear_nft')) {
                            this.mi_fear_nft = true;
                        } else {
                            this.mi_fear_nft = false;
                        }
                        if (this.loadedFields.market_indicators.includes(
                                'mi_fear_btc_in_out')) {
                            this.mi_fear_btc_in_out = true;
                        } else {
                            this.mi_fear_btc_in_out = false;
                        }
                        if (this.loadedFields.market_indicators.includes(
                                'mi_fear_btc_alt')) {
                            this.mi_fear_btc_alt = true;
                        } else {
                            this.mi_fear_btc_alt = false;
                        }

                    } else {

                        if (this.params.api_mode == 1) {
                            this.fields[0].filterColumn = true;
                            this.fields[1].filterColumn = true;
                            this.fields[20].filterColumn = false;
                            this.fields[21].filterColumn = false;
                            this.fields[26].filterColumn = false;
                            this.fields[27].filterColumn = false;
                            this.fields[22].filterColumn = false;
                            this.fields[23].filterColumn = false;
                            this.fields[24].filterColumn = false;
                            this.fields[25].filterColumn = false;
                            this.fields[28].filterColumn = false;
                            this.fields[29].filterColumn = false;
                            this.fields[30].filterColumn = false;
                            this.fields[31].filterColumn = false;
                            this.fields[32].filterColumn = false;
                            this.fields[33].filterColumn = false;

                        } else {
                            this.fields[0].filterColumn = true;
                            this.fields[1].filterColumn = true;
                            this.fields[20].filterColumn = true;
                            this.fields[21].filterColumn = true;
                            this.fields[26].filterColumn = true;
                            this.fields[27].filterColumn = true;
                            this.fields[22].filterColumn = true;
                            this.fields[23].filterColumn = true;
                            this.fields[24].filterColumn = true;
                            this.fields[25].filterColumn = true;
                            this.fields[28].filterColumn = true;
                            this.fields[29].filterColumn = true;
                            this.fields[30].filterColumn = true;
                            this.fields[31].filterColumn = true;
                            this.fields[32].filterColumn = true;
                            this.fields[33].filterColumn = true;

                        }
                        this.fields[38].filterColumn = true;
                    }
                })
            }


        },
        computed: {
            visibleFields() {
                if (this.params.api_mode == 1) {
                    return this.fields.filter(field => {
                        return field.visible == 1 && field.filterColumn == true && field.key !=
                            'market_cap_rank' || field.visible == 2 && field
                            .filterColumn == true && field.key != 'market_cap_rank' || field.visible == 3 &&
                            field.filterColumn == true && field.key != 'market_cap_rank';
                    })
                } else {
                    return this.fields.filter(field => {
                        return field.visible == 2 && field.filterColumn == true && field.key !=
                            'market_cap_rank' || field.visible == 3 && field
                            .filterColumn == true && field.key != 'market_cap_rank';
                    })
                }
            },
            value: {
                get() {
                    return [this.ldot, this.rdot]
                },
                set([ldot, rdot]) {
                    this.ldot = ldot
                    this.rdot = rdot
                },
            },
            value1: {
                get() {
                    return [this.filterKey.min_roi_percentage, this.filterKey.max_roi_percentage]
                },
                set([ldot1, rdot1]) {
                    this.filterKey.min_roi_percentage = ldot1
                    this.filterKey.max_roi_percentage = rdot1
                },
            },
            value2: {
                get() {
                    return [this.filterKey.min_price_change_percentage_24h, this.filterKey
                        .max_price_change_percentage_24h
                    ]
                },
                set([ldot2, rdot2]) {
                    this.filterKey.min_price_change_percentage_24h = ldot2
                    this.filterKey.max_price_change_percentage_24h = rdot2
                },
            },
            value3: {
                get() {
                    return [this.filterKey.min_total_supply_percent, this.filterKey.max_total_supply_percent]
                },
                set([ldot3, rdot3]) {
                    this.filterKey.min_total_supply_percent = ldot3
                    this.filterKey.max_total_supply_percent = rdot3
                },
            },
            value4: {
                get() {
                    return [this.filterKey.min_average_sentiment_change, this.filterKey
                        .max_average_sentiment_change
                    ]
                },
                set([ldot4, rdot4]) {
                    this.filterKey.min_average_sentiment_change = ldot4
                    this.filterKey.max_average_sentiment_change = rdot4
                },
            },
            value5: {
                get() {
                    return [this.filterKey.min_social_mentions_change, this.filterKey
                        .max_social_mentions_change
                    ]
                },
                set([ldot5, rdot5]) {
                    this.filterKey.min_social_mentions_change = ldot5
                    this.filterKey.max_social_mentions_change = rdot5
                },
            },
            value6: {
                get() {
                    return [this.filterKey.min_social_engagement_change, this.filterKey
                        .max_social_engagement_change
                    ]
                },
                set([ldot6, rdot6]) {
                    this.filterKey.min_social_engagement_change = ldot6
                    this.filterKey.max_social_engagement_change = rdot6
                },
            },
            value7: {
                get() {
                    return [this.filterKey.min_average_sentiment, this.filterKey.min_average_sentiment]
                },
                set([ldot7, rdot7]) {
                    this.filterKey.min_average_sentiment = ldot7
                    this.filterKey.min_average_sentiment = rdot7
                },
            },
            value8: {
                get() {
                    return [this.filterKey.min_three_months_unlock_percent_of_tokens, this.filterKey
                        .max_three_months_unlock_percent_of_tokens
                    ]
                },
                set([ldot8, rdot8]) {
                    this.filterKey.min_three_months_unlock_percent_of_tokens = ldot8
                    this.filterKey.max_three_months_unlock_percent_of_tokens = rdot8
                },
            },
            value9: {
                get() {
                    return [this.filterKey.min_next_unlock_percent_of_tokens, this.filterKey
                        .max_next_unlock_percent_of_tokens
                    ]
                },
                set([ldot9, rdot9]) {
                    this.filterKey.min_next_unlock_percent_of_tokens = ldot9
                    this.filterKey.max_next_unlock_percent_of_tokens = rdot9
                },
            },
            value10: {
                get() {
                    return [this.filterKey.min_six_months_unlock_percent_of_tokens, this.filterKey
                        .max_six_months_unlock_percent_of_tokens
                    ]
                },
                set([ldot10, rdot10]) {
                    this.filterKey.min_six_months_unlock_percent_of_tokens = ldot10
                    this.filterKey.max_six_months_unlock_percent_of_tokens = rdot10
                },

            },
            presetFiltersapp1() {
                return this.presetFilters.filter(filter => {
                    return filter.default == 1
                })
            },
            presetFiltersapp2() {
                return this.presetFilters.filter(filter => {
                    return filter.default != 1
                })
            },


            direction() {
                if (store.state.appConfig.isRTL) {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.dir = 'rtl'
                    return this.dir
                }
                // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                this.dir = 'ltr'
                return this.dir
            },

        },
        mounted() {
            this.loadFileds();
            this.loadCoins(false);
            this.loadFag();
            this.loadPresetFilters();
            if (this.$route.query.type == 'extention') {
                document.body.classList.add('AppExtentionMode')
            }
        },
        created() {
            this.userData = getUserData()
        },
        watch: {
            'Cpagpage': function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.loadCoins(false)
                }
            },
            'params.filters2': function (newVal, oldVal) {
                if (oldVal != newVal && newVal.trim().length == 0 || newVal.trim().length >= 3) {
                    this.Cpagpage = 1;
                    this.loadCoins(false)
                }
            },
            'loadedData': function (n, o) {
                if (this.loadedData == true) {

                    this.liveCoinFetch();
                }

            },
            'selectedPreset': function (n, o) {
                this.loadSelectedPresetFilter();

            },
            'params.perpage': function (n, o) {
                this.Cpagpage = 1
                this.loadCoins(false)
            }
        },

        updated() {
            var meter_array = document.querySelectorAll('g path:not(:first-child)');
            for (let index = 0; index < meter_array.length; index++) {
                var element = meter_array[index];
                let path_array = element.getAttribute('d').split(' ');
                if (document.getElementById("marker_" + index) != null) {
                    document.getElementById("marker_" + index).style.background = "#b6e7b6";
                    document.getElementById("marker_" + index).style.boxShadow = "0px 0px 7px 3.5px #0f0";
                    if (Number(path_array[9]) > 100) {
                        document.getElementById("marker_" + index).style.left = Number(path_array[9]) - 6 + "px";
                        document.getElementById("marker_" + index).style.top = Number(path_array[10]) - 4 + "px";
                    } else {
                        document.getElementById("marker_" + index).style.left = Number(path_array[9]) - 6 + "px";
                        document.getElementById("marker_" + index).style.top = Number(path_array[10]) + "px";
                    }
                }
            }
        }
    }

</script>
<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-slider.scss';

</style>
<style>
    .model-desc {
        color: #757094 !important;
    }

    .model-desc a {
        color: #757094 !important;
    }

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

    #dashboard .b-table-1 {
        overflow-y: auto !important;
        max-height: 56vh;

    }

    #dashboard .b-table-1 tr {
        height: 60px;
    }

    #dashboard .b-table-1:hover {
        overflow-x: scroll !important;
    }

    #dashboard td {
        text-align: center;
    }

    #dashboard .b-table-1::-webkit-scrollbar {
        height: 2px;

    }

    #dashboard .b-table-1:hover::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        cursor: pointer;
    }



    #ctable .b-overlay-wrap.position-relative:hover {
        margin-right: -4px;

    }

    #dashboard .b-table-1::-webkit-scrollbar-corner {
        background: rgba(0, 0, 0, 0);
        z-index: 999;
    }

    #dashboard .b-table-1::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.3);
        background-color: #ffffff;

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
        font-family: 'Poppins-Light';
        font-weight: 300;

    }

    #dashboard table th {
        padding-left: 18px !important;
        padding-right: 15px !important;
        font-size: 12px;
        font-weight: 300;
        font-family: 'Poppins';
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

    @media only screen and (max-width: 992px) {
        .max-block {
            display: block !important;
        }
    }

    .sparlineChat svg {
        height: 100%;
        width: 100%
    }

    .soicalLable {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 500;
        font-size: 10px;
        opacity: 0.8;
        margin: auto;
    }

    .sl2 {
        font-size: 12px;
    }

    .blurry-text {
        text-shadow: 0 0 32px white;
        color: transparent;
    }

    .popover {
        border-radius: 50px;
    }

    .popover-body {
        background: linear-gradient(172deg, rgba(39, 179, 62, 0.3) 10.11%, rgba(0, 0, 0, 0) 20.06%), rgba(9, 9, 9, 0.725);
        border-radius: 20px;
    }

    .popover .arrow {
        color: gray;
    }

    .blurry-text {
        text-shadow: 0px -2px 5px #d13e3e;
    }

    .rank_slot {
        top: 36px;
        right: 189px;
        z-index: 999;
    }

    .apexcharts-tooltip {
        background: #f3f3f3;
        color: #78909C;
    }


    .greenFlash {
        color: #6BBE84 !important;

    }

    .redFlash {
        color: #ea5455 !important;

    }

    .whiteFlash {
        color: #ffffff !important;

    }

    .greenFlash1 {
        color: #6BBE84;

    }

    .redFlash1 {
        color: #ea5455;

    }

    .marginx1 {
        margin: 0 8px 0 8px
    }

    .margin16_b {
        margin-bottom: 16px;
    }

    .feerGreen {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 600;
        font-size: 35px;
        text-align: center;
        color: #6BD863;
    }

    .feerSmallGreen {
        font-family: 'Poppins-Light';
        font-style: normal;
        text-align: center;
        color: #6BD863;
        font-size: 20px;
        padding: 0;
        white-space: nowrap;
    }

    thead tr th {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 300;
        font-size: 12px;
    }

    tbody tr {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 15px;
        background: linear-gradient(172deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07);
        position: relative;
    }

    [class*=collapse-] .collapse-title {
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        opacity: 0.7;
    }

    /* tbody tr:before {
        content: "";
        z-index: 3;
        position: absolute;
        top: -1px;
        left: 10px;
        background: linear-gradient(90deg, rgba(35,34,40, 0) 0%, rgba(35,34,40, 1) 100%);
        width: 100%;
        height: 2px;
   
    } */

    tbody tr:has(td:not(:first-child)) {
        box-shadow: inset 1px 2px 1px 0px rgb(82, 243, 109);
    }


    table {
        border-collapse: separate;
        border-spacing: 0 7px !important;
    }

    td {
        border: solid 0px #000000;
        padding: 15px;
    }

    tr td:first-child {
        border-top-left-radius: 50em;
        border-bottom-left-radius: 50em;
    }

    tr td:last-child {
        border-top-right-radius: 50em;
        border-bottom-right-radius: 50em;
    }

    #pagination button span {
        background-color: transparent !important;
    }

    .greenGradient {
        margin-right: 10px;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-radius: 20px;
        background: linear-gradient(169deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 50.06%), rgba(255, 255, 255, 0.07);
    }

    .margin20 {
        margin: 10px;
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 16px !important;
    }

    .cunningBtn>button {
        color: white !important;
        padding: 0px !important;
    }

    .cunningBtn>ul {

        min-width: 500px !important;
        /* border:1px solid rgba(43, 255, 77, 1); */
        border-radius: 10px;
    }

    .cunningBtn .dropdown-menu {
        max-height: 2000px;
    }

    .cunningDrop .dropdown-menu.show {
        max-height: 275px !important;
    }

    .dropdown-menu {
        border-radius: 20px;
        max-height: 500px;
        overflow: auto;
    }


    /* .card {
        padding: 0px;
    }

    .card-body{
        padding: 0px;
    } */

    #dropdown-left1__BV_toggle_ {
        padding: 0px !important;


    }

    #dropdown-left1__BV_toggle_:hover {
        background: none;
    }

    .cunningDrop>ul {
        background: none;
    }

    .cunningDrop>form {
        padding: 7px 30px 10px 0px;
    }

    .graph_tab {
        font-size: 10px;
    }

    .graph_tab a {
        padding: inherit !important;
        margin-right: 1rem;
        padding-bottom: 3px !important;
    }

    g path:not(:first-child) {
        filter: transparent;
    }

    .socialText {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
    }

    .socialText2 {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
    }

    .apexcharts-menu-open {
        background: black;
    }

    .modal-content {
        border-radius: 30px;
    }

    .modal-header {
        border-radius: 30px;
    }

    .modal-body {
        border-radius: 30px;
    }

    body.dark-layout .modal-content div ul li.cunningDrop {
        background: #0A070E !important;
        padding-right: 15px;
    }

    body .modal-content div ul li.cunningDrop {
        background: rgb(248, 248, 248);
    }

    body.dark-layout .modal-content div ul:has(li.cunningDrop) {
        padding: 0px;
    }

    .oneToFive .vue-slider-rail {
        height: 15px !important;
        background: url(/images/static/slider_5.png) !important;
        background-color: transparent !important;
        background-size: cover !important;
    }

    .oneToFive .vue-slider-process {
        top: 3px !important;
        left: 0%;
        width: 100%;
        transition-property: width, left;
        transition-duration: 0.5s;
    }

    .text-success-green {
        color: #6BBE84
    }

    #modal-preset-create___BV_modal_body_ {
        background: linear-gradient(146.03deg, rgba(43, 255, 77, 1) -102%, rgb(44, 43, 49) 21.77%), white !important;
    }

    #modal-preset-create___BV_modal_content_ {
        padding: 1px;
        border-radius: 30px;
        background: linear-gradient(146.03deg, rgba(0, 255, 0, 1) 7%, rgba(255, 255, 255, 0) 50%) !important;
    }

    body.dark-layout .graph_tab-1 ul {
        justify-content: normal !important;
        margin-left: 87px !important;
    }

    .poppins-font {
        font-family: 'Poppins-Light'
    }

    .chart-desc,
    .chart-desc a {
        color: gray !important;
    }

    .dark-layout .chart-desc,
    .dark-layout .chart-desc a {
        color: white !important;
    }

    .socialText2 {
        height: 33px;
    }

    .soicalLable.darkWhiteText.lableText {
        height: 32px;
    }

    .preset-button-style {
        background-color: #333237;
        padding: 10px !important;
        border-radius: 22px;

    }

    .preset-dropdown {
        width: 88%;
        background-color: #333237;
    }

    .preset-dropdown ul {
        top: -58px !important;
        width: 100%;
    }

    .dark-layout .preset-form form {
        background-color: #333237 !important;
    }

    .socialData .innerCard card-body {
        padding: 5px;
    }

    .socialData .innerCard .radius_gradient {
        max-width: 140px
    }

    #modal-details .modal-dialog {
        max-width: 900px !important;
    }

    .soicalLable-2 {
        font-size: 15px;
        height: 30px;
    }

    .cunningDrop2 {
        border-radius: 20px !important;
    }

    .cunningDrop2 button {
        border-radius: 21px;
        background: linear-gradient(142deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07);
        box-shadow: inset 1px 1px 1px 0px rgb(52 215 80);
        border-radius: 20px;
    }

    .cunningDrop2 button .preset-button-style {
        background-color: transparent !important;
    }

    .cunningDrop2 .preset-form form {

        border-radius: 21px;
        background: linear-gradient(142deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07) !important;
        box-shadow: inset 1px 1px 1px 0px rgb(52 215 80);
        border-radius: 20px;
    }

    #modal-details___BV_modal_header_ {
        z-index: 999;
        position: absolute;
        top: 0;
        right: 12px;
        background: transparent !important;
    }

    .details-modal-container {
        max-height: 94vh;
        overflow-y: auto;
        padding: 0.8rem 1.4rem;

    }

    #modal-details___BV_modal_body_ {
        padding: 0;
    }

    .details-modal-container {
        max-height: 94vh;
        overflow-y: auto;
        padding: 0.8rem 1.4rem;

    }

    #modal-details___BV_modal_body_ {
        padding: 0;
    }

    .cunningDrop-notify-form {
        border-radius: 19px !important;
        z-index: 999 !important;
        background: linear-gradient(156deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07) !important;
        box-shadow: inset 1px 1px 2px 0px rgb(52 215 80) !important;
    }

    /* modal-preset-create___BV_modal_content_ */

    /* .oneToFive .vue-slider-dot{
        width: 14px;
        height: 14px;
        transform: translate(-50%, -50%);
        top: 80% !important;
        left: 0%;
        transition: left 0.5s ease 0s;
    } */
    #notify-dropdown__BV_toggle_ {
        padding: 0 !important;
        text-align: start;
    }

    .cunningDrop-notify:hover {
        background: transparent;
    }

    .dark-layout .apexcharts-legend-text {
        color: white !important;
    }

    .loadingModal {
        height: 80vh !important;
    }

    #modal-details___BV_modal_content_ .b-overlay {
        height: 80vh !important;
    }

    .whitepaper-card .card-body {
        padding-left: 0.5rem !important;
        padding-right: 0.5rem !important;
    }

    .AppExtentionMode #dashboard .b-table-1 {
        overflow-y: auto !important;
        margin: 0;
        max-height: 48vh;

    }

    .AppExtentionMode .cardBack {
        padding: 1px 16px !important;
    }

    .cardBack {
        padding: 1px 16px;
        box-shadow: 0px 0px 20px rgba(19, 20, 37, 0.5);
        backdrop-filter: blur(7.5px);
        border-radius: 30px;
    }

    .AppExtentionMode .DashboardHeader {
        margin-bottom: 10px !important;
    }

    .DashboardHeader {
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .AppExtentionMode .FGCharts {
        margin-bottom: 0px !important;
    }

    .FGCharts {
        margin-bottom: 25px;
    }

    #dashboard .b-table-1 thead tr {
        height: 30px;
    }

    .AppExtentionMode .HeaderTopBar {
        margin-bottom: -2px !important;
    }

    .AppExtentionMode .topbarDiv {
        z-index: 999;
        position: absolute;
        top: -23px;
        left: -60px
    }

    .HeaderTopBar {
        margin-bottom: 1rem;
    }

    .AppExtentionMode .topbarDiv .greyLetter {
        font-size: 12px !important;
    }

    .AppExtentionMode .topbarDiv .whiteLetter {
        font-size: 13px !important;
    }

    .AppExtentionMode .topbarDiv i.bi.bi-triangle-fill {
        font-size: 10px;
    }

    .SearchInputGroup {
        margin-bottom: 0px !important;
    }

    .topbarDiv .TriangleIcon {
        margin-left: 10px;
        margin-right: 10px;
    }

    .AppExtentionMode .topbarDiv .TriangleIcon {
        margin-left: 3px;
        margin-right: 3px;
    }

    .AppExtentionMode .topbarDiv .Dominance {
        margin-top: 4px !important;
    }


    .searchbar {
        margin-top: 1rem;
    }

    .table>tbody>tr>td {
        max-width: 300px;
    }

</style>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
