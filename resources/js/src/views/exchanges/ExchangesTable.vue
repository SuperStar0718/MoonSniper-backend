<template>
    <div class="ExchangeTableDiv">
        <b-overlay :show="!exchangesLoaded" rounded="sm">
            <div >
                <div>
                    <b-table :no-border-collapse="true" tbody-tr-class="cursor-pointer  box rounded-pill"
                    :show-empty="true"  class="b-table-2" :fields="fields"
                    style=" white-space: nowrap;" responsive   :items="exchangeData.data">
                    <template #cell(exchange)="data">
                        <div>
                            <a :href="data.item.trade_url" target="blank_" style="color:white !important">
                            <div class="">
                                <div style="padding-top:3px">${{ data.value }}
                                </div>
                            </div>
                        </a>
                        </div>
                    </template>
                    <template #cell(volume)="data">
                        <div>
                           
                                <div class="">
                                    <div style="padding-top:3px">${{ toInterNationalNumber(data.value?data.value:0) }}
                                    </div>
                                </div>
                           
                        </div>
                    </template>
                   
                </b-table>
                  </div>
                  <div class="mx-2 mb-2">
                    <b-row>
                        <b-col cols="12" sm="6"
                            class="d-flex align-items-center justify-content-center justify-content-sm-start">
                        </b-col>
                        <!-- Pagination -->
                        <b-col cols="12" sm="6"
                            class="d-flex align-items-center justify-content-center justify-content-sm-end">
    
                            <b-pagination id="pagination" v-model="pageNumber" :total-rows="exchangeData.total"
                                :per-page="exchangeData.per_page" first-number last-number class="mb-0 mt-1 mt-sm-0"
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
            </b-overlay>
    </div>
</template>
<script>
    import {
        BTable,
        BOverlay,
        BTabs,
        BTab,
        BFormCheckbox,
        BRow,BCol,BPagination

    } from 'bootstrap-vue'
    import axios from '@axios'
    import fieldsData from './fields'
    export default {
        components: {
            BTable,
            BOverlay,
            BTabs,
        BTab,
        BFormCheckbox,
        BRow,BCol,BPagination
        },
        props:{
            token:Object
        },
        data() {
            return {
                exchangesLoaded: false,
                exchangeData:[],
                pageNumber:1,
                isBusy:false,
                fields: fieldsData,
          

            }
        },
        methods:{
            loadExchanges() {
                this.exchangesLoaded= false;
                this.isBusy = true;
                axios.post('api/exchanges-by-token?token='+this.token.coin_id+'&page=' + this.pageNumber).then(res => {
                    if (res.data.status == true) {
                        this.exchangeData = res.data.exchanges;
                        this.exchangesLoaded= true;
                    }
                    this.isBusy = false;

                })

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
            this.loadExchanges()
        },
       
        watch:{
            'pageNumber': function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.loadExchanges(false)
                }
            },
        }
    }

</script>
<style>
.ExchangeTableDiv .b-overlay {
    height: 100px !important;
}
[dir=ltr] .card .table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 48rem;
}
[dir=ltr] .card .table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 71.357rem;
}
</style>