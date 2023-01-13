<template>
    <div class="d-flex">
        <div class="w-100">
            <div class="d-flex">
                <div class="nm-width" style="margin: auto;">{{ modal }} &nbsp;</div>
                <div>
                    <div class="d-flex">
                        <b-form-input :options="NumberFormaVal" @blur="blurUpdate" type="number" :step="sliderInterVal" class="form-control" v-model="value1[0]"
                             placeholder="Decrease to" />
                        <span>
                            <feather-icon icon="MinusIcon" size="16" class="align-middle"
                                style="margin:10px 6px 0 0px" />
                        </span>
                        <b-form-input type="number" :step="sliderInterVal" :options="NumberFormaVal" @blur="blurUpdate" class="form-control" v-model="value1[1]"
                             placeholder="Increase to" />
                    </div>
                    <label class="d-flex justify-content-center" style="margin-top: 5px;">{{ getitemLabel() }}</label>
                </div>
            </div>

        </div>
        <div class="w-75" style="padding-left: 22px;
        margin-top: 6px;">
            <div @click="dragSlider">
                <vue-slider :interval="sliderInterVal" @drag-end="dragSlider"  :tooltip-formatter="formatterRange" v-model="value2" :min="0" :max="30" class="mb-2" />
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
            valueData: Object
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
                value2: ['',''],
                Notdragged: true,
                formatterRange: '{value}%',
                NumberFormaVal: {
                    numeral: true,
                    numeralDecimalScale: 1

                },
            }
        },
        methods: {

            dragSlider() {
                this.Notdragged = false;
                this.value1 = [this.value2[0], this.value2[1]]
                if (typeof this.value1[0] != 'string' && this.value1[0] == 0) {
                    this.value1[0] = stringify(this.value1[0]);
                }
                if (typeof this.value1[1] != 'string' && this.value1[1] == 0) {
                    this.value1[1] = stringify(this.value1[1]);
                }
                if(this.value2[0] == null)
                {
                    this.value2[0] = ''
                }
                if(this.value2[1] == null)
                {
                    this.value2[1] = ''
                }
                if(this.value2[0] == 0)
                {
                    this.value1 = ['',this.value1[1]];
                    this.value2 = ['',this.value2[1]]
                }
                if(this.value2[1] == 0)
                {
                    this.value1 = [this.value1[0],''];
                    this.value2 = [this.value2[0],'']
                }
                this.$emit('updateNotificationFilter', [this.value1, this.item])
            },
            blurUpdate() {
                let vals = [null, null]

                if (this.value1[0] == '') {
                    this.value1[0] = null;
                }
                if (this.value1[1] == '') {
                    this.value1[1] = null;
                }
                if (this.value1[0] == null && this.value1[1] == null) {
                    this.value2 = vals;
                } else if (this.value1[0] == null) {
                    this.value1[1] = parseFloat(this.value1[1])
                    if(this.value1[1] < 0) {
                        this.value1[1] = 0;
                    }
                    if(this.value1[1] > 30) {
                        this.value1[1] = 30;
                    }
                    if (this.value1[1] > 30) {
                        vals = [null, 30]
                    } else {
                        vals = [null, this.value1[1]]
                    }
                    this.value2 = vals;
                } else if (this.value1[1] == null) {
                     if(this.value1[0] < 0) {
                        this.value1[0] = 0;
                    }
                    if(this.value1[0] > 30) {
                        this.value1[0] = 30;
                    }
                    this.value1[0] = parseFloat(this.value1[0])
                    if (this.value1[0] > 30) {
                        vals = [30, 30]
                    } else {
                        if (typeof this.value1[0] != 'string') {
                            this.value1[0] = stringify(this.value1[0]);
                        }
                        if (this.value1[0] + 0 > 30) {
                            vals = [this.value1[0], 30]
                        } else {
                            if (this.value1[0] == 0) {
                                vals = [this.value1[0], 30]
                            } else {
                                vals = [this.value1[0], this.value1[0] + 0]
                            }
                        }
                    }

                    this.value1 = vals;
                } else {
                        this.value1[0] = parseFloat(this.value1[0])
                      this.value1[1] = parseFloat(this.value1[1])

                      if(this.value1[0] < 0) {
                        this.value1[0] = 0;
                    }
                    if(this.value1[0] > 30) {
                        this.value1[0] = 30;
                    }
                    if(this.value1[1] < 0) {
                        this.value1[1] = 30;
                    }
                    if(this.value1[1] > 30) {
                        this.value1[1] = 30;
                    }
                    if (this.value1[0] > this.value1[1]) {
                     
                    if (this.value1[0] <= 30) {
                        if (typeof this.value1[0] != 'string') {
                            this.value1[0] = stringify(this.value1[0]);
                        }
                        if (this.value1[0] + 0 > 30) {
                            vals = [this.value1[0], 30]
                        } else {
                            if (this.value1[0] == 0) {
                                vals = [this.value1[0], 30]
                            } else {
                                vals = [this.value1[0], this.value1[0] + 0]
                                vals = [parseFloat(vals[0]), parseFloat(vals[1])];
                            }
                        }
                    } else {
                        vals = [30, 30]
                    }

                } else {

                    if (this.value1[1] > 30) {
                        vals = [this.value1[0], 30]
                    } else {
                        vals = [this.value1[0], this.value1[1]]
                    }

                }
            }

                this.value2 = [vals[0], vals[1]]
                this.value1 = [this.value2[0], this.value2[1]]

                if (typeof this.value2[0] != 'string' && this.value2[0] == 0) {
                    this.value2[0] = stringify(this.value2[0]);
                }
                if (typeof this.value2[1] != 'string' && this.value2[1] == 0) {
                    this.value2[1] = stringify(this.value2[1]);
                }
                if(this.value2[0] == null)
                {
                    this.value2[0] = ''
                }
                if(this.value2[1] == null)
                {
                    this.value2[1] = ''
                }
                this.$emit('updateNotificationFilter', [this.value2, this.item])
            },
            getitemLabel() {
                let label = '';
                switch (this.item) {
                    case 1:
                        label = 'Current price is : ' + this.valueData.current_price+'$';
                        break;
                    case 2:
                        label = '24h volume is : ' + (this.valueData.price_change_percentage_24h != null?this.valueData.price_change_percentage_24h:'-');
                        break;
                    case 3:
                        label = `Today's ROI% is  : ` + (this.valueData.roi_percentage != null?this.valueData.roi_percentage:'-')+'%';
                        break;
                    case 4:
                        label =  `Today's market cap is  : ` + (this.valueData.market_cap != null?this.valueData.market_cap:'-');
                        break;
                    case 5:
                        label = 'Next unlock size is: ' + (this.valueData.next_unlock_percent_of_tokens != null?this.valueData.next_unlock_percent_of_tokens:'-');
                        break;
                    case 6:
                        label = '24H social sentiment is  : ' + (this.valueData.average_sentiment_change != null?this.valueData.average_sentiment_change:'-')+'%';
                        break;

                    default:
                        break;
                }
                return label;

            }
        },
        computed:{
            sliderInterVal()
            {
                let vdata = this.valueData.next_unlock_percent_of_tokens;
              
                let interval = 1;
                if(vdata  < 0 )
                {
                    interval = 0.0001
                }
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
                let vdata = this.valueData.next_unlock_percent_of_tokens;
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
                    this.dragSlider();
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
                if(this.value2[0] == null)
                {
                    this.value2[0] = ''
                }
                if(this.value2[1] == null)
                {
                    this.value2[1] = ''
                }
                this.$emit('updateNotificationFilter', [this.value2, this.item])
                //    this.value3 = newVal[0]
                //     this.value4 = newVal[1]
            },


        }
    }

</script>
<style>
    .nm-width {
        min-width: 100px;
    }

</style>
