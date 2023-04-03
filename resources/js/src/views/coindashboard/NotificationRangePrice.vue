<template>
    <div class="d-flex">
        <div class="w-100">
            <div class="d-flex">
                <div class="nm-width" style="margin: auto;">{{ modal }} &nbsp;</div>
                <div>
                    <div class="d-flex">
                        <b-form-input :options="NumberFormaVal" type="number" :step="sliderInterVal" @blur="blurValue1"
                            class="form-control" v-model="value1[0]" placeholder="Decrease to" />
                            <span class="my-auto mx-1">
                                OR
                             </span>
                        <b-form-input type="number" :step="sliderInterVal" :options="NumberFormaVal" @blur="blurValue2"
                            class="form-control" v-model="value1[1]" placeholder="Increase to" />
                    </div>
                    <label class="d-flex justify-content-center" style="margin-top: 5px;">{{ getitemLabel() }}</label>
                </div>
            </div>

        </div>
        <div class="w-75" style="padding-left: 22px;
        margin-top: 6px;">
            <div @click="dragSlider">
                <vue-slider  :interval="sliderInterVal" :tooltip-formatter="formatterRange" @drag-end="dragSlider" :min="-100" :max="100"
                    v-model="value2" class="mb-2" />
            </div>
        </div>
    </div>

</template>
<script>
    import {

        BFormGroup,
        BFormInput
    } from 'bootstrap-vue'
    import Cleave from 'vue-cleave-component'
    // eslint-disable-next-line import/no-extraneous-dependencies
    import 'cleave.js/dist/addons/cleave-phone.us';
    import VueSlider from 'vue-slider-component';
    import {
        stringify
    } from 'json5';
    export default {
        props: {
            value: Array,
            item: 0,
            modal: String,
            valueData: Object,
            current_price:Number
        },
        components: {
            VueSlider,
            BFormGroup,
            Cleave,
            BFormInput
        },
        data() {
            return {
                value1: this.value,
                value2: ['', ''],
                formatterRange: '{value}%',
                Notdragged: true,
                NumberFormaVal: {
                    numeral: true,
                },

            }
        },
        methods: {

            dragSlider() {
                this.Notdragged = false;

                let vdata = 0.00;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                if (this.value2[0] < 0) {
                    if (this.value2[1] < 0) {
                        this.value1 = [parseFloat(vdata) - (parseFloat(vdata) * Math.abs(this.value2[0]) / 100),
                            parseFloat(vdata) - (parseFloat(vdata) * Math.abs(this
                                .value2[1]) / 100)
                        ]
                    } else {
                        this.value1 = [parseFloat(vdata) - (parseFloat(vdata) * Math.abs(this.value2[0]) / 100),
                            parseFloat(vdata) + (parseFloat(vdata) * this.value2[1] /
                                100)
                        ]

                    }
                } else {
                    if (this.value2[1] < 0) {
                        this.value1 = [parseFloat(vdata) + (parseFloat(vdata) * this.value2[0] / 100), parseFloat(
                            vdata) - (parseFloat(vdata) * Math.abs(this
                            .value2[1]) / 100)]
                    } else {
                        this.value1 = [parseFloat(vdata) + (parseFloat(vdata) * this.value2[0] / 100), parseFloat(
                            vdata) + (parseFloat(vdata) * Math.abs(this
                            .value2[1]) / 100)]

                    }
                }
                let v1 = '';
                let v2 = '';
                if (this.value1[0] != null && this.value1[0] != '') {
                    v1 = this.value1[0].toFixed(this.sliderInterVal2);
                }
                if (this.value1[1] != null && this.value1[1] != '') {
                    v2 = this.value1[1].toFixed(this.sliderInterVal2);

                }
                if(this.value2[0] == 0)
                {
                    v1 = '';
                    this.value2[0] = '';
                }
                if(this.value2[1] == 0)
                {
                    v2 = '';
                    this.value2[1] = '';
                }
                
                this.value1 = [v1, v2]
                this.$emit('updateNotificationFilter', [this.value2, this.item,this.value1])
            },
            blurValue1() {
                
                if(this.value1[0] != null || this.value1[0] != '')
                {
               
                let vdata = 0.00;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                let min = parseFloat(vdata) - (parseFloat(vdata) * 100 / 100)
                let max = parseFloat(vdata) + (parseFloat(vdata) * 100 / 100)
                max = max.toFixed(this.sliderInterVal2);
                min = min.toFixed(this.sliderInterVal2);

                if (this.value1[0] != null && this.value1[0] != '') {
                    if (parseFloat(this.value1[0]) < min || parseFloat(this.value1[0]) > max) {
                        this.value1[0] = min;
                    } 
                    if (this.value1[1] == null  || this.value1[1] == '') {
                        this.value1[1] = null;
                    }else if(parseFloat(this.value1[1]) < parseFloat(this.value1[0])){
                        this.value1[1] = null;
                        
                    }

                }
                   
            }else{
                this.value1[0] != null;
            }
            
                this.blurValue2();
            },
            blurValue2() {
                let vdata = 0.00;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                let min = parseFloat(vdata) - (parseFloat(vdata) * 100 / 100)
                let max = parseFloat(vdata) + (parseFloat(vdata) * 100 / 100)
                max = max.toFixed(this.sliderInterVal2);
                min = min.toFixed(this.sliderInterVal2);

                if (this.value1[1] != null && this.value1[1] != '') {
                    
                    if (parseFloat(this.value1[1]) < min || parseFloat(this.value1[1]) > max) {
                        this.value1[1] = max;
                    }  
                    if (this.value1[0] == null  || this.value1[0] == '') {
                        this.value1[0] = null;
                    }
                } else {
                    if (this.value1[0] != null && this.value1[0] != '') {
                        this.value1[1] = null;
                    }

                }
                
               
                this.updateValue2();
            },
            updateValue2() {
                let vdata = 0.00;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }

                let v1 = '';
                let v2 = '';

                if (this.value1[0] != null && this.value1[0] != '') {
                    v1 = -(100 - (parseFloat(this.value1[0]) / parseFloat(vdata)) * 100);

                }
                if (this.value1[1] != null && this.value1[1] != '') {
                    v2 = -(100 - (parseFloat(this.value1[1]) / parseFloat(vdata)) * 100);
                }
                if (v1 != '') {
                    v1 = v1.toFixed(this.sliderInterVal2);
                }
                if (v2 != '') {
                    v2 = v2.toFixed(this.sliderInterVal2);
                }

                this.value2 = [v1, v2];

                this.$emit('updateNotificationFilter', [this.value2, this.item,this.value1])
            },
            getitemLabel() {
                let label = '';
                switch (this.item) {
                    case 1:
                        label = 'Current price is : ' + this.current_price + '$';
                        break;
                    case 2:
                        label = '24h volume is : ' + (this.valueData.total_volume ? this.valueData.total_volume : '-');
                        break;
                    case 3:
                        label = `Today's ROI% is  : ` + (this.valueData.roi_percentage ? this.valueData.roi_percentage :
                            '-') + '%';
                        break;
                    case 4:
                        label = `Today's market cap is  : ` + (this.valueData.market_cap ? this.valueData.market_cap :
                            '-');
                        break;
                    case 5:
                        label = 'Next unlock size is: ' + (this.valueData.next_unlock_percent_of_tokens ? this.valueData
                            .next_unlock_percent_of_tokens : '-');
                        break;
                    case 6:
                        label = '24H social sentiment is  : ' + (this.valueData.average_sentiment_change ? this
                            .valueData.average_sentiment_change : '-') + '%';
                        break;

                    default:
                        break;
                }
                return label;

            }
        },
        computed: {
            minvalue() {
                let vdata = 0;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                return (-100 / parseFloat(vdata)) * 100

            },
            maxvalue() {
                let vdata = 0;
                if (this.item == 1) {
                    vdata = this.current_price;
                } else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                return (100 / parseFloat(vdata)) * 100

            },
            sliderInterVal()
            {
                let vdata = 0;
                if (this.item == 1) {
                    vdata = this.current_price;
                }else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                let interval = 1;
                if(vdata  >= 0 && vdata <0.5)
                {
                    interval = 0.0001
                }
                if(vdata  >= 0.5 && vdata <1.1)
                {
                    interval = 0.001
                }
                if(vdata  >= 1.1 && vdata <100)
                {
                    interval = 0.01
                }
                if(vdata  >= 100)
                {
                    interval = 0.1
                }
                return interval ;
            },
            sliderInterVal2()
            {
                let vdata = 0;
                if (this.item == 1) {
                    vdata = this.current_price;
                }else if (this.item == 4) {
                    vdata = this.valueData.market_cap;
                }
                let interval = 1;
                if(vdata  >= 0 && vdata <0.5)
                {
                    interval = 4;
                }
                if(vdata  >= 0.5 && vdata <1.1)
                {
                    interval = 3;
                }
                if(vdata  >= 1.1 && vdata <100)
                {
                    interval = 2
                }
                if(vdata  >= 100)
                {
                    interval = 1
                }
                return interval ;
            }
        
        },
        watch: {
            value2: function (newVal, oldVal) {
                if (this.Notdragged) {
                    // this.dragSlider();
                }

            },
            value: function (newVal, oldVal) {

                this.value1 = [this.value[0], this.value[1]];
                this.value2 = [this.value[0], this.value[1]];
                if (typeof this.value2[0] != 'string' && this.value2[0] == 0) {
                    this.value2[0] = stringify(this.value2[0]);
                }
                if (typeof this.value2[1] != 'string' && this.value2[1] == 0) {
                    this.value2[1] = stringify(this.value2[1]);
                }
                this.$emit('updateNotificationFilter', [this.value2, this.item,this.value1])
                   this.value3 = newVal[0]
                    this.value4 = newVal[1]
            },


        }
    }

</script>
<style>
    .nm-width {
        min-width: 100px;
    }

</style>
