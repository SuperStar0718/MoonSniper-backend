<template>
    <div id="alerts">
        <div class="darkWhiteText" style="font-family: 'Poppins';
        font-style: normal;
        font-weight: 600;
        font-size: 24px;
        margin-top: 26px;
        margin-bottom: 26px;
        text-align: center;
        ">
        Alerts
    </div>
        <div class="body-content-overlay" />
        <!-- search bar and table -->
        <div class="cardBack" style="
        padding: 20px;
        box-shadow: 0px 0px 20px rgba(19, 20, 37, 0.5);
        backdrop-filter: blur(7.5px);
        border-radius: 30px; ">

            <div id="ctable" style="position: relative">
                <div class="opacityGradient" style="
                    position: absolute;
                    right: 4px;
                    top: 0px;
                    height: 100%;
                    width: 61px;
                    z-index: 3;
                    background: linear-gradient( 90deg,
                    rgba(248, 248, 248, 0) 0%,
                    rgba(248, 248, 248, 1) 100% );">
                </div>
                <b-overlay :show="isBusy" rounded="sm">
                    <b-table :no-border-collapse="true" tbody-tr-class="cursor-pointer box rounded-pill " show-empty
                        class="b-table-alerts" style=" white-space: nowrap;" responsive :items="items.data" :fields="fields">
                        <template #cell(alert_name)="data">
                            <div class="" v-html="data.item.data.name"></div>

                        </template>
                        <template #cell(coin_name)="data" >
                            <div v-if="data.item.type == 'App\\Notifications\\NotifyCoinAlert'" class="" v-html="data.item.data.coin_name"></div>
                            <div v-else class="" v-html="data.item.data.name"></div>

                        </template>
                        <template #cell(priority)="data">
                            <div v-if="data.item.type == 'App\\Notifications\\NotifyCoinAlert'" class="text-capitalize" v-html="data.item.data.priority"></div>
                            <div v-else class="" >High</div>
                        </template>
                        <template #cell(conditions)="data">
                            <div v-if="data.item.type == 'App\\Notifications\\NotifyCoinAlert'"  class="">

                                <div v-if="data.item.data.min_price != null && data.item.data.max_price!= null">
                                    <div>
                                        Price: Below {{ data.item.data.min_price }}$ or Above {{ data.item.data.max_price }}$
                                    </div>
                                </div>
                                <div v-else-if="data.item.data.min_price!= null && data.item.data.max_price == null">
                                    Price: Below {{ data.item.data.min_price}}$
                                </div>
                                <div  v-else-if="data.item.data.min_price== null && data.item.data.max_price != null">
                                    Price: Above {{ data.item.data.max_price}}$
                                </div>
                                
                                <div v-if="data.item.data.min_tradingper24h != null && data.item.data.max_tradingper24h!= null">
                                    <div>
                                        Volume: Below {{ data.item.data.min_tradingper24h }} % or
                                       Above {{ data.item.data.max_tradingper24h }} %
                                    </div>
                                </div>
                                <div v-else-if="data.item.data.min_tradingper24h!= null && data.item.data.max_tradingper24h == null">
                                    Volume: Below {{ data.item.data.min_tradingper24h}}%
                                </div>
                                <div  v-else-if="data.item.data.min_tradingper24h== null && data.item.data.max_tradingper24h != null">
                                    Volume: Above {{ data.item.data.max_tradingper24h}}%
                                </div>
                               
                                <div v-if="data.item.data.min_roipercentage != null && data.item.data.max_roipercentage!= null">
                                    <div>
                                        ROI%: Below {{ data.item.data.min_roipercentage }}% or
                                        Above {{ data.item.data.max_roipercentage }} %
                                    </div>
                                </div>
                                <div v-else-if="data.item.data.min_roipercentage!= null && data.item.data.max_roipercentage == null">
                                    ROI%: Below {{ data.item.data.min_roipercentage}}%
                                </div>
                                <div  v-else-if="data.item.data.min_roipercentage== null && data.item.data.max_roipercentage != null">
                                    ROI%: Above {{ data.item.data.max_roipercentage}}%
                                </div>
                                
                                
                                <div style="white-space: initial;"  v-if="data.item.data.min_marketcap != null && data.item.data.max_marketcap!= null">
                                    
                                        Market Cap: Below {{ data.item.data.min_marketcap }}$ or
                                        Above {{ data.item.data.max_marketcap }}$
                                    </div>
                                    <div style="white-space: initial;"  v-else-if="data.item.data.min_marketcap!= null && data.item.data.max_marketcap == null">
                                         Market Cap: Below {{ data.item.data.min_marketcap}}$
                                    </div>
                                    <div style="white-space: initial;"  v-else-if="data.item.data.min_marketcap== null && data.item.data.max_marketcap != null">
                                         Market Cap:  Above {{ data.item.data.max_marketcap}}$
                                    </div>
                                    <div v-if="data.item.data.min_nextunlock != null && data.item.data.max_nextunlock!= null">
                                    
                                        Next unlock: Below{{ data.item.data.min_nextunlock }}% or
                                        Above {{ data.item.data.max_nextunlock }}%
                                    </div>
                                    <div v-else-if="data.item.data.min_nextunlock!= null && data.item.data.max_nextunlock == null">
                                         Next unlock: Below {{ data.item.data.min_nextunlock}}%
                                    </div>
                                    <div  v-else-if="data.item.data.min_nextunlock== null && data.item.data.max_nextunlock != null">
                                         Next unlock:  Above {{ data.item.data.max_nextunlock}}%
                                    </div>
                                    <div v-if="data.item.data.min_socialsentiments != null && data.item.data.max_socialsentiments!= null">
                                    
                                        24H Social Sentiment:Below {{ data.item.data.min_socialsentiments }}% or
                                       Above {{ data.item.data.max_socialsentiments }}%
                                    </div>
                                    <div v-else-if="data.item.data.min_socialsentiments!= null && data.item.data.max_socialsentiments == null">
                                         24H Social Sentiment: Below {{ data.item.data.min_socialsentiments}}%
                                    </div>
                                    <div  v-else-if="data.item.data.min_socialsentiments== null && data.item.data.max_socialsentiments != null">
                                         24H Social Sentiment:  Above {{ data.item.data.max_socialsentiments}}%
                                    </div>
                                    
                               



                            </div>
                            <div v-else class="" >
                            {{ formatStr(data.item.data.type) }} unlock
                            </div>

                        </template>
                        <template #cell(actionButton)="data">
                            <div class="actionButton">
                                <b-dropdown bottom text="..." ref="dropdown">
                                    <div class="p-1" style="background: white;border-radius: 20px; color:#000">
                                        <b-dropdown-item class="" v-if="data.item.type == 'App\\Notifications\\NotifyCoinAlert'" style="" @click="editNotification(data.item)">
                                            Edit
                                        </b-dropdown-item>
                                        <b-dropdown-item class="" style="" @click="deleteNotification(data.item.id)">
                                            Delete
                                        </b-dropdown-item>
                                    </div>
                                </b-dropdown>
                            </div>

                        </template>
                    </b-table>
                </b-overlay>
                <div class="p">
                    <b-row>
                        <!-- Pagination -->
                        <b-col cols="12"
                            class="d-flex align-items-center justify-content-center justify-content-around">
                            <div>
                                <span class="" v-if="!isBusy"> Showing {{ items.from }} to {{ items.to }} of
                                    {{ items.total }}</span>
                            </div>
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
                            <div>
                                <span>
                                    <select v-model="Cpagpage" v-if="!isBusy">
                                        <option v-for="(item,index) in items.last_page" :key="index">
                                            {{ index+1 }}
                                        </option>
                                    </select>
                                </span>
                            </div>
                        </b-col>

                    </b-row>
                </div>
            </div>
            <b-modal id="modal-notifications" ok-only ok-title="Close" :hide-footer="true" centered size="lg"
                :title="'Edit alert for: '+activeData.coin_name" @hidden="onModalHidden">
                <div class="">
                    <template>
                        <b-overlay :show="!NotificationModal" rounded="sm">
                            <div class="details-modal-container" v-if="NotificationModal">
                                <div class="d-flex flex-wrap justify-content-around">
                                    <div class="d-flex">
                                        <label style="white-space: nowrap;margin: auto;">Alert Name: &nbsp;</label>
                                        <input class="form-control" type="text" v-model="alertForm.name" :class="{ titlereq: titleReq }">
                                        <small v-if="titleReq" class="text-danger"><i>Name is required</i></small>
                                    </div>
                                    <div class="d-flex">
                                        <label style="white-space: nowrap;margin: auto;">Priority: &nbsp;</label>
                                        <b-form-select id="" v-model="alertForm.priority" :options="alertPriorities" />
                                    </div>

                                </div>
                                <div class=" p-2">
                                    <NotificationRangePrice v-if="coinData.current_price != null" :current_price="coinData.current_price" :value="alertData.price" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="Price" :item="1" :valueData="coinData" />
                                     <NotificationRangeROI v-if="coinData.price_change_percentage_24h != null" :valueData="coinData"  :value="alertData.tradingper24h" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="24H trading %" :item="2" />
                                     <NotificationRangeROI v-if="coinData.roi_percentage != null" :valueData="coinData" :value="alertData.roipercentage" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="ROI in %" :item="3" />
                                     <NotificationRangePrice  v-if="coinData.market_cap != null"  :valueData="coinData" :value="alertData.marketcap" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="Market cap" :item="4" />
                                    <NotificationRangeNextUnlock v-if="coinData.next_unlock_percent_of_tokens != null" :valueData="coinData" :value="alertData.nextunlock" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="Next unlock" :item="5" />
                                    <NotificationRange v-if="coinData.average_sentiment_change != null" :valueData="coinData" :value="alertData.socialsentiments" @updateNotificationFilter="updateNotificationFilter($event)"
                                    modal="Social sentiments %" :item="6" />
                                    

                                </div>
                                <div class="d-flex justify-content-center">
                                    <div>
                                        <b-button class="darkWhiteBackground darkBlackText rounded-lg text-[16px]"
                                            size="md" 
                                            variant="outline-primary" @click="updateAlert()" >
                                            Update Alert 
                                        </b-button>
                                    </div>
                                    <div style="margin-top:8px;margin-left:8px">
                                        The alert will be sent if all conditions of the filter are met.
                                    </div>
                                </div>

                            </div>

                        </b-overlay>
                    </template>

                </div>

            </b-modal>
        </div>
        <!-- end search and table -->
    </div>
</template>

<script>
    import NotificationRangePrice from './NotificationRangePrice.vue';
    import NotificationRangeROI from './NotificationRangeROI.vue';
    import NotificationRangeNextUnlock from './NotificationRangeNextUnlock.vue';
    import {
        BRow,
        BCol,
        BOverlay,
        BTable,
        BDropdown,
        BDropdownItem,
        BPagination,BFormSelect,BButton
    } from 'bootstrap-vue'
    import axios from '@axios'
    import fieldsData from './fields'
    import NotificationRange from './NotificationRange.vue';
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    export default {
        components: {
            BRow,
            BCol,
            BOverlay,
            BTable,
            BDropdown,
            BDropdownItem,
            BPagination,
            BFormSelect,BButton,ToastificationContent,
            NotificationRange,
            NotificationRangePrice,
            NotificationRangeROI,
            NotificationRangeNextUnlock

        },
        data() {
            return {
                isBusy: false,
                fields: fieldsData,
                items: [],
                titleReq:false,
                Cpagpage: 1,
                alertData: {
                    price: ['', '','',''],
                    tradingper24h: ['', ''],
                    roipercentage: ['', ''],
                    marketcap: ['', '','', ''],
                    nextunlock: ['', ''],
                    socialsentiments: ['', ''],
                },
                alertForm: {
                    priority: 'medium',
                    min_price: null,
                    max_price: null,
                    max_price_percentage: null,
                    min_price_percentage: null,
                    min_tradingper24h: null,
                    max_tradingper24h: null,
                    min_roipercentage: null,
                    max_roipercentage: null,
                    min_marketcap: null,
                    max_marketcap: null,
                    min_marketcap_percentage: null,
                    max_marketcap_percentage: null,
                    min_nextunlock: null,
                    max_nextunlock: null,
                    min_socialsentiments: null,
                    max_socialsentiments: null,

                },
                alertPriorities: [{
                        text: 'Low',
                        value: 'Low'
                    },
                    {
                        text: 'Medium',
                        value: 'Medium'
                    },
                    {
                        text: 'High',
                        value: 'High'
                    },
                ],
                NotificationModal: false,
                activeData: [],
                activeNotify:[],
                coinData:{},
                AddalertDisable:true,
                livePriceInterval:null
            }
            
        },
       
        created() {
            // data

        },
        methods: {
            loadCoins() {
                this.isBusy = true;
                axios.get('api/load-user-alerts?page=' + this.Cpagpage)
                    .then(res => {
                        this.items = res.data.data;
                    });

                this.isBusy = false;
            },
            deleteNotification(id) {
                axios.post('api/delete-alert', {
                        id: id
                    })
                    .then(response => {
                        if (response.status) {

                            this.loadCoins();

                        } else {

                        }
                    })

            },
            formatStr(str){
                const convertedStr = str.replace(/-/g, ' ');
                return convertedStr;
            },
            editNotification(item) {
                this.alertForm.name = null;
                 this.alertForm.priority = null;
                this.alertForm.min_price = null;
                 this.alertForm.max_price = null;
                 this.alertForm.min_price_percentage = null;
                 this.alertForm.max_price_percentage = null;
                 this.alertForm.min_tradingper24h = null;
                 this.alertForm.max_tradingper24h = null;
                 this.alertForm.min_roipercentage = null;
                 this.alertForm.max_roipercentage = null;
                 this.alertForm.max_marketcap = null;
                 this.alertForm.min_marketcap = null;
                 this.alertForm.max_marketcap_roipercentag = null;
                 this.alertForm.min_marketcap_roipercentag= null;
                 this.alertForm.min_nextunlock = null;
                 this.alertForm.max_nextunlock = null;
                 this.alertForm.min_socialsentiments = null;
                 this.alertForm.max_socialsentiments = null;
                 this.alertData ={
                    price: ['', '','', ''],
                    tradingper24h: ['', ''],
                    roipercentage: ['', ''],
                    marketcap: ['', '','', ''],
                    nextunlock: ['', ''],
                    socialsentiments: ['', ''],
                }

                this.activeData = item.data;
               this.activeNotify = item;

               this.alertData.price[0] = this.activeData.min_price?this.activeData.min_price:'';
               this.alertData.price[1] = this.activeData.max_price?this.activeData.max_price:'';
               this.alertData.price[2] = this.activeData.min_price_percentage?this.activeData.min_price_percentage:'';
               this.alertData.price[3] = this.activeData.max_price_percentage?this.activeData.max_price_percentage:'';
               this.alertData.tradingper24h[0] = this.activeData.min_tradingper24h?this.activeData.min_tradingper24h:'';
               this.alertData.tradingper24h[1] = this.activeData.max_tradingper24h?this.activeData.max_tradingper24h:'';
               this.alertData.roipercentage[0] = this.activeData.min_roipercentage?this.activeData.min_roipercentage:'';
               this.alertData.roipercentage[1] = this.activeData.max_roipercentage?this.activeData.max_roipercentage:'';
               this.alertData.marketcap[0] = this.activeData.min_marketcap?this.activeData.min_marketcap:'';
               this.alertData.marketcap[1] = this.activeData.max_marketcap?this.activeData.max_marketcap:'';
               this.alertData.marketcap[2] = this.activeData.min_marketcap_percentage?this.activeData.min_marketcap_percentage:'';
               this.alertData.marketcap[3] = this.activeData.max_marketcap_percentage?this.activeData.max_marketcap_percentage:'';
               this.alertData.nextunlock[0] = this.activeData.min_nextunlock?this.activeData.min_nextunlock:'';
               this.alertData.nextunlock[1] = this.activeData.max_nextunlock?this.activeData.max_nextunlock:'';
               this.alertData.socialsentiments[0] = this.activeData.min_socialsentiments?this.activeData.min_socialsentiments:'';
               this.alertData.socialsentiments[1] = this.activeData.max_socialsentiments?this.activeData.max_socialsentiments:'';
               this.alertForm.name = this.activeData.name;
               this.alertForm.priority = this.activeData.priority;
               this.loadCoinData();
          
             
               this.NotificationModal = true;
               this.$bvModal.show('modal-notifications');
               this.fetchLiveCoinPrice();

            },
            updateNotificationFilter(evt)
            {
                if(evt[1] == 1)
                {
                    this.alertForm.min_price_percentage = evt[0][0];
                    this.alertForm.max_price_percentage = evt[0][1];
                    this.alertForm.min_price = evt[2][0];
                    this.alertForm.max_price = evt[2][1];
                }else if(evt[1] == 2)
                {
                    this.alertForm.min_tradingper24h = evt[0][0];
                    this.alertForm.max_tradingper24h = evt[0][1];
                }else if(evt[1] == 3)
                {
                    this.alertForm.min_roipercentage = evt[0][0];
                    this.alertForm.max_roipercentage = evt[0][1];
                }else if(evt[1] == 4)
                {
                    this.alertForm.min_marketcap_percentage = evt[0][0];
                    this.alertForm.max_marketcap_percentage = evt[0][1];
                    this.alertForm.min_marketcap = evt[2][0];
                    this.alertForm.max_marketcap = evt[2][1];
                }else if(evt[1] == 5)
                {
                    this.alertForm.min_nextunlock = evt[0][0];
                    this.alertForm.max_nextunlock = evt[0][1];
                }else if(evt[1] == 6)
                {
                    this.alertForm.min_socialsentiments = evt[0][0];
                    this.alertForm.max_socialsentiments = evt[0][1];
                }
                // this.updateAddalertDisable();
            },
            loadCoinData()
            {
                let params = {
                    coinid: this.activeData.coin_id,
                    symbol: this.activeData.symbol,
                }
                axios.post('api/load-alert-coin-data',params)
                   .then(res => {
                        if(res.data.status == true){

                            this.coinData = res.data.data;
                        }
                   });
            },  
            livecoinprice()
            {
                this.pricesWs = new WebSocket('wss://ws.coincap.io/prices?assets=' + this.activeData.coin_id+ ',')
                let thisScope = this;
                this.pricesWs.onmessage = function (msg) {
                    let coinFetched = JSON.parse(msg.data);
                    let objKeys = Object.keys(coinFetched);
                    objKeys.forEach(element => {
                        let oldVal = thisScope.activeData.current_price;
                        thisScope.activeData.current_price = coinFetched[element];
                        thisScope.coinData.current_price = coinFetched[element];
                    });


                }
            },
            updateAlert()
            {
                if(!this.alertForm.name || this.alertForm.name.trim() == '')
                {
                    this.titleReq = true;
                    return 0;
                }
                this.alertForm.coin_id = this.activeData.coin_id;
                this.alertForm.symbol = this.activeData.symbol;
                this.alertForm.coin_name = this.activeData.coin_name;
                this.alertForm.id = this.activeNotify.id;
                
                axios.post('api/update-alert',this.alertForm)
               
                .then(res => {
                    this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'An alert updated successfully',
                                    icon: 'CheckCircleIcon',
                                    variant: 'success',
                                },
                            })
                    this.alertForm.coin_id = null;
                    this.alertForm.symbol = null;
                    this.alertForm.coin_name = null;
                    this.alertForm.priority = 'Medium';
                    this.alertForm.name = '';
                    this.alertData.price = [null,null,null,null];
                    this.alertData.tradingper24h =[null,null];
                    this.alertData.roipercentage =[null,null];
                    this.alertData.marketcap =[null,null,null,null];
                    this.alertData.nextunlock =[null,null];
                    this.alertData.socialsentiments =[null,null];
                    this.alertForm.min_price = null;
                    this.alertForm.max_price = null;
                    this.alertForm.min_tradingper24h = null;
                    this.alertForm.max_tradingper24h = null;
                    this.alertForm.min_roipercentage = null;
                    this.alertForm.max_roipercentage = null;
                    this.alertForm.min_marketcap = null;
                    this.alertForm.max_marketcap = null;
                    this.alertForm.min_nextunlock = null;
                    this.alertForm.max_nextunlock = null;
                    this.alertForm.min_socialsentiments = null;
                    this.alertForm.max_socialsentiments = null;
                    this.NotificationModal = false;
                    this.$bvModal.hide('modal-notifications');
                    this.loadCoins();
                });
            },
            updateAddalertDisable()
            {
                if(this.AddalertDisable)
                {
                    return 0;
                }
                if(this.alertForm.min_price != null|| this.alertForm.max_price != null||
                    this.alertForm.min_tradingper24h != null|| this.alertForm.max_tradingper24h != null||
                    this.alertForm.min_roipercentage != null|| this.alertForm.max_roipercentage != null||
                    this.alertForm.min_marketcap != null|| this.alertForm.max_marketcap != null||
                    this.alertForm.min_nextunlock != null|| this.alertForm.max_nextunlock != null||
                    this.alertForm.min_socialsentiments != null|| this.alertForm.max_socialsentiments != null 
                
                ){
                   this.AddalertDisable = false;
                }else{
                    this.AddalertDisable = true;
                }
            },
            fetchLiveCoinPrice() {
                // this.livecoinprice();
                // return;
                if (this.livePriceInterval) {
                    clearInterval(this.livePriceInterval)
                }
                const body = document.querySelector('body');
                if (body && body.hasAttribute('app_installed_true')) {
                    window.postMessage({
                            type: "get_data",
                            coinsStr: this.activeData.coin_id
                        }, function (response) {
                        });
                   this.livePriceInterval= setInterval(() => {
                        window.postMessage({
                            type: "get_data",
                            coinsStr: this.activeData.coin_id
                        }, function (response) {
                        });
                    }, 10000);
                } else {
                    this.livecoinprice();
                }
            },
            onModalHidden(){
                if (this.livePriceInterval) {
                    clearInterval(this.livePriceInterval)
                }
            }
        },
        beforeDestroy(){
           this.onModalHidden();
        },
        mounted() {
            this.isBusy = true;
           this.loadCoins();
            this.isBusy = false;
            let vm = this;
            window.addEventListener("message", function (event) {
                if (event.data.type === "return_price_to_site") {
                    let objKeys = Object.keys(event.data.coinsStr.message);
                    objKeys.forEach(element => {
                        vm.activeData.current_price =  event.data.coinsStr.message[element].usd;
                        vm.coinData.current_price =  event.data.coinsStr.message[element].usd;
                          vm.$set(vm.activeData, 'current_price', event.data.coinsStr.message[
                                element].usd);
                                vm.$set(vm.coinData, 'current_price', event.data.coinsStr.message[
                                element].usd);
                    });
                }
            });

     
        },
        watch: {
            'Cpagpage': function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.loadCoins(false)
                }
            },
            'alertForm.name': function (newVal, oldVal) {
                if (oldVal && newVal) {
                        this.titleReq = false;
                }
            },
        }

    }

</script>
<style>
   #alerts tbody tr:has(td:not(:first-child)) {
        box-shadow: inset 1px 2px 1px 0px rgb(82 243 109);
    }

    #alerts  tbody tr {
        background: linear-gradient(172deg, rgba(43, 255, 77, 0.3) 3.11%, rgba(0, 0, 0, 0) 20.06%), rgba(255, 255, 255, 0.07);
    }

    #alerts tbody tr {
        font-family: 'Poppins-Light';
        font-style: normal;
        font-weight: 400;
        font-size: 15px;
        position: relative;
    }

    #alerts  tr td:first-child {
        border-top-left-radius: 50em;
        border-bottom-left-radius: 50em;
    }

    #alerts  .actionButton .dropdown-toggle {
        background: transparent !important;
        border: none !important;
        color: white !important;
        font-size: 25px;
        margin: auto;
        padding: 0;
        text-align: center;
    }

    #alerts .actionButton .dropdown-toggle::after {
        display: none !important;
    }

    #alerts .actionButton .dropdown-item {
        color: #000000 !important;
    }

    #alerts .action-menu {
        margin-bottom: 2px;
        padding: 5px;
        border-radius: 5px;
    }

    #alerts .action-menu:hover {
        background: rgb(217, 212, 212) !important;

    }
    #alerts  .titlereq{
        border-color: #ad2020 !important;
    }
    #alerts .b-table-alerts table{
    border-spacing: 0px 4px !important;
    }
   .AppExtensionMode  #modal-notifications  .modal-dialog{
        max-width: 748px !important;
    }
    .AppExtensionMode  #modal-notifications  .modal-body{
        padding: 0.8rem 0rem;
    }
</style>
<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-slider.scss';

</style>