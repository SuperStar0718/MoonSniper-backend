<template>
    <div class="d-flex">
        <div class="w-100">
            <div class="d-flex">
                <div class="nm-width" style="margin: auto;">{{ modal }} &nbsp;</div>
                <div>
                    <div class="d-flex">
                        <cleave :options="NumberFormaVal" @blur="blurUpdate" class="form-control" v-model="value1[0]"
                             placeholder="min" />
                             <span class="my-auto mx-1">
                                OR
                             </span>
                        <cleave :options="NumberFormaVal" @blur="blurUpdate" class="form-control" v-model="value1[1]"
                             placeholder="max" />
                    </div>
                    <label class="d-flex justify-content-center" style="margin-top: 5px;">{{ getitemLabel() }}</label>
                </div>
            </div>

        </div>
        <div class="w-75" style="padding-left: 22px;
        margin-top: 6px;">
            <div @click="dragSlider">
                <vue-slider @drag-end="dragSlider" v-model="value2" class="mb-2" />
            </div>
        </div>
    </div>

</template>
<script>
    import {

        BFormGroup,

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
            Cleave
        },
        data() {
            return {
                value1: this.value,
                value2: this.value,
                Notdragged: true,
                NumberFormaVal: {
                    numeral: true,
                },
            }
        },
        methods: {

            dragSlider() {
                this.Notdragged = false;
                console.log(this.value2);
                this.value1 = [this.value2[0], this.value2[1]]
                if (typeof this.value1[0] != 'string' && this.value1[0] == 0) {
                    this.value1[0] = stringify(this.value1[0]);
                }
                if (typeof this.value1[1] != 'string' && this.value1[1] == 0) {
                    this.value1[1] = stringify(this.value1[1]);
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
                    if (this.value1[1] > 100) {
                        vals = [null, 100]
                    } else {
                        vals = [null, this.value1[1].]
                    }
                    this.value2 = vals;
                } else if (this.value1[1] == null) {
                    if (this.value1[0] > 100) {
                        vals = [100, 100]
                    } else {
                        if (typeof this.value1[0] != 'string') {
                            this.value1[0] = stringify(this.value1[0]);
                        }
                        if (this.value1[0] + 0 > 100) {
                            vals = [this.value1[0], 100]
                        } else {
                            if (this.value1[0] == 0) {
                                vals = [this.value1[0], 100]
                            } else {
                                vals = [this.value1[0], this.value1[0] + 0]
                            }
                        }
                    }

                    this.value1 = vals;
                } else if (this.value1[0] > this.value1[1]) {
                    if (this.value1[0] <= 100) {
                        if (typeof this.value1[0] != 'string') {
                            this.value1[0] = stringify(this.value1[0]);
                        }
                        if (this.value1[0] + 0 > 100) {
                            vals = [this.value1[0], 100]
                        } else {
                            if (this.value1[0] == 0) {
                                vals = [this.value1[0], 100]
                            } else {
                                vals = [this.value1[0], this.value1[0] + 0]
                            }
                        }
                    } else {
                        vals = [100, 100]
                    }

                } else {

                    if (this.value1[1] > 100) {
                        vals = [this.value1[0], 100]
                    } else {
                        vals = [this.value1[0], this.value1[1]]
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
                this.$emit('updateNotificationFilter', [this.value2, this.item])
            },
            getitemLabel() {
                let label = '';
                switch (this.item) {
                    case 1:
                        label = 'Current price is : ' + this.valueData.current_price+'$';
                        break;
                    case 2:
                        label = '24h volume is : ' + (this.valueData.total_volume?this.valueData.total_volume:'-');
                        break;
                    case 3:
                        label = `Today's ROI% is  : ` + (this.valueData.roi_percentage?this.valueData.roi_percentage:'-')+'%';
                        break;
                    case 4:
                        label =  `Today's market cap is  : ` + (this.valueData.market_cap?this.valueData.market_cap:'-');
                        break;
                    case 5:
                        label = 'Next unlock size is: ' + (this.valueData.next_unlock_percent?this.valueData.next_unlock_percent:'-');
                        break;
                    case 6:
                        label = '24H social sentiment is  : ' + (this.valueData.average_sentiment_change?this.valueData.average_sentiment_change:'-')+'%';
                        break;

                    default:
                        break;
                }
                return label;

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
