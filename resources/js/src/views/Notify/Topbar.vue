<template>
    <div class="mx-auto topbarDiv" style="">
        <div class="HeaderTopBar">
            <div class="d-flex topHeader-flexing">
                <div class="d-flex mx-auto justify-content-center Topbar-items" style="">
                    <div class="my-auto greyLetter" style="margin-right:4px;">MC:</div>
                    <div class="my-auto whiteLetter" v-if="loaded">{{todaysMc != null?todaysMc:'-'}}</div>
                    <div v-if="todaysMcChange >0" style="" class="TriangleIcon ">
                        <i class="bi bi-triangle-fill" style="color:#6BBE83;"></i>
                    </div>
                    <div v-else style="" class="TriangleIcon rotate-180">
                        <i class="bi bi-triangle-fill " style="color:#ea5455;"></i>
                    </div>
                    <div v-if="todaysMcChange >0" style="color:#6BBE83;">
                        +{{todaysMcChange}}%
                    </div>
                    <div v-else style="color:#ea5455;">
                        {{todaysMcChange}}%
                    </div>
                </div>
                <div class="d-flex mx-auto justify-content-center Topbar-items" style="">
                    <div class="my-auto greyLetter" style="margin-right:4px;">Vol(24h):</div>
                    <div class="my-auto whiteLetter" v-if="loaded"> {{todaysVol?todaysVol:'-'}}</div>
                    <div v-if="todaysVolChange >0" style="" class="TriangleIcon ">
                        <i class="bi bi-triangle-fill" style="color:#6BBE83;"></i>
                    </div>
                    <div v-else style="" class="TriangleIcon rotate-180">
                        <i class="bi bi-triangle-fill " style="color:#ea5455;"></i>
                    </div>
                    <div v-if="todaysVolChange >0" style="color:#6BBE83;">
                        +{{todaysVolChange}}%
                    </div>
                    <div v-else style="color:#ea5455;">
                        {{todaysVolChange}}%
                    </div>
                </div>
                <div class="d-flex mx-auto justify-content-center Topbar-items Topbar-items2" style="">
                    <div class="my-auto greyLetter Dominance" style="margin-right:4px;">Dominance:</div>
                    <div class="my-auto d-flex justify-content-between whiteLetter" v-if="loaded">
                        <div style="margin:0 4px 0 0px; white-space:nowrap;"> {{fag.data.btc_dom}}
                        </div>
                        <div style="margin:0 4px 0 0px; white-space:nowrap;">{{fag.data.eth_dom}}</div>
                    </div>

                </div>
                <div class="d-flex mx-auto justify-content-center " style="padding-left:5px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                        class="bi bi-fuel-pump-diesel my-auto" viewBox="0 0 16 16">
                        <path
                            d="M3.5 2a.5.5 0 0 0-.5.5v5a.5.5 0 0 0 .5.5h5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-5ZM4 14V9h1.796c.5 0 .913.098 1.237.293.325.195.567.479.725.85.161.371.242.82.242 1.344 0 .528-.08.98-.242 1.355a1.805 1.805 0 0 1-.732.861c-.324.198-.734.297-1.23.297H4Zm1.666-4.194h-.692v3.385h.692c.229 0 .427-.035.595-.103a.986.986 0 0 0 .412-.315c.108-.142.188-.318.241-.528.056-.21.083-.456.083-.74 0-.376-.048-.69-.144-.94a1.11 1.11 0 0 0-.436-.569c-.195-.127-.445-.19-.75-.19Z" />
                        <path
                            d="M3 0a2 2 0 0 0-2 2v13H.5a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1H11v-4a1 1 0 0 1 1 1v.5a1.5 1.5 0 0 0 3 0V8h.5a.5.5 0 0 0 .5-.5V4.324c0-.616 0-1.426-.294-2.081a1.969 1.969 0 0 0-.794-.907C14.534 1.111 14.064 1 13.5 1a.5.5 0 0 0 0 1c.436 0 .716.086.9.195a.97.97 0 0 1 .394.458c.147.328.19.746.201 1.222H13.5a.5.5 0 0 0-.5.5V7.5a.5.5 0 0 0 .5.5h.5v4.5a.5.5 0 0 1-1 0V12a2 2 0 0 0-2-2V2a2 2 0 0 0-2-2H3Zm7 2v13H2V2a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1Z" />
                    </svg>
                    <div class="my-auto greyLetter" style="margin-right:8px; margin-left:4px;">ETH Gas:</div>
                    <div class="my-auto d-flex justify-content-between cursor-pointer">
                        <div style="margin:0 8px 0 4px" class="whiteLetter"
                            v-b-tooltip.hover.bottom.html="ethGasPriceTooltip" v-if="loaded">
                            {{ethGas.ProposeGasPrice}} GWEI
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from '@axios';
import { VBPopover,
        
    } from 'bootstrap-vue';
export default {
    directives: {
            'b-tooltip': VBPopover,

        },
    data(){
        return{
            loaded:false,
            todaysMc: 0,
                todaysMcChange: 0,
                todaysVol: 0,
                todaysVolChange: 0,
                weeklyMcAndVolume:[],
                fag: {
                    data: {
                        fear_greed_index: 0,
                        fear_greed_classification: '',
                        nftindex: 0,
                        inoutper: 0,
                        inoutvalue: 0,
                        inoutperOval: 0,
                        btcflowDif: 0,


                    },
                    btcflow: [],
                },
                ethGas: {
                    SafeGasPrice: null,
                    ProposeGasPrice: null,
                    FastGasPrice: null,
                },
        }
    },
    methods:{
        loadMarketCap() {
                axios.
                get('/api/load-marketcap-values')
                    .then(res => {
                        if (res.data.status) {
                            this.weeklyMcAndVolume = res.data;
                            this.todaysMc = this.toInterNationalNumber(res.data.mcValues.stats[7][1].toFixed(0));
                            let A = res.data.mcValues.stats[7][1];
                            let B = res.data.mcValues.stats[6][1];
                            this.todaysMcChange = 100 * ((A - B) / ((A + B) / 2));
                            this.todaysMcChange = this.todaysMcChange.toFixed(2);

                            this.todaysVol = this.toInterNationalNumber(res.data.mcValues.total_volumes[7][1]
                                .toFixed(0));
                            let C = res.data.mcValues.total_volumes[7][1];
                            let D = res.data.mcValues.total_volumes[6][1];
                            this.todaysVolChange = 100 * ((C - D) / ((C + D) / 2));
                            this.todaysVolChange = this.todaysVolChange.toFixed(2);
                        }
                    })

            },
            ethGasPriceTooltip() {
                let html = '';
                return html = `<div>
                            <div class="d-flex">
                                <span>
                                    Fast:
                                </span>
                                <span>
                                     &nbsp; ${this.ethGas.FastGasPrice} GWEI
                                </span>
                                </div>
                                <div class="d-flex">
                                <span>
                                    Standard:
                                </span>
                                <span>
                                     &nbsp; ${this.ethGas.ProposeGasPrice} GWEI
                                </span>
                                </div>
                                <div class="d-flex">
                                <span>
                                    Low:
                                </span>
                                <span>
                                     &nbsp; ${this.ethGas.SafeGasPrice} GWEI
                                </span>
                                </div>
                        </div>`
            },
            loadEthGasValues() {
                axios.
                get('/api/load-ethgas-values')
                    .then(res => {
                        if (res.data.status) {
                            this.ethGas.SafeGasPrice = res.data.result.SafeGasPrice;
                            this.ethGas.ProposeGasPrice = res.data.result.ProposeGasPrice;
                            this.ethGas.FastGasPrice = res.data.result.FastGasPrice;
                        }
                    })

            },
            async loadFag() {
                this.fagLoad = true;

                await axios.post('api/get_fag').then(res => {
                    if (res.data) {
                        this.fag.data = res.data.data;
                        this.loaded = true;
                    
                    }



                })
                await axios.get('https://api.nftgo.io/api/v1/data/overview')
                    .then(res => {
                        let nftData = res.data;
                        this.fag.data.nftindex = parseInt(nftData.data.nftIndex.toFixed(0));
                    })
                this.fagLoad = false;
            },
            toInterNationalNumber(val) {
                if (val)
                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
            },
    },
    mounted()
    {
        this.loadMarketCap();
        this.loadFag();
        this.loadEthGasValues();
        this.ethGasPriceTooltip();
    }
}
</script>