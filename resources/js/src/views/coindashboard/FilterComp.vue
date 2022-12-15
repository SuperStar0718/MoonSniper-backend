<template>
    <div>
        <b-form-group :label="modal">
            <div class="d-flex">
                <cleave :options="NumberFormaVal" @blur="blurUpdate" class="form-control" v-model="value1[0]"
                    v-numeric-only placeholder="min" />
                <span>
                    <feather-icon icon="MinusIcon" size="16" class="align-middle" style="margin:10px 6px 0 0px" />
                </span>
                <cleave :options="NumberFormaVal" @blur="blurUpdate" class="form-control" v-model="value1[1]"
                    v-numeric-only placeholder="max" />
            </div>

        </b-form-group>
        <div v-if="item != 7" @click="dragSlider">
            <vue-slider @drag-end="dragSlider"  v-model="value2" class="mb-2" />
        </div>
        <div v-else @click="dragSlider">
            <vue-slider @drag-end="dragSlider"  :max="5" :min="0" v-model="value2" class="mb-2" />

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
            modal: String
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
                Notdragged:true,
                NumberFormaVal: {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
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
                this.$emit('updateSlider', [this.value1, this.item])
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
                        vals = [null, this.value1[1]]
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
                            if(this.value1[0] == 0)
                            {
                                vals = [this.value1[0], 100]
                            }else{
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
                            if(this.value1[0] == 0)
                            {
                                vals = [this.value1[0], 100]
                            }else{
                            vals = [this.value1[0], this.value1[0] + 0]
                            }
                        }
                    } else {
                        vals = [100, 100]
                    }

                } else {

                    if(this.value1[1] >100)
                    {
                        vals = [this.value1[0], 100]
                    }else{
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
                this.$emit('updateSlider', [this.value2, this.item])
            }
        },
        watch: {
            value2: function (newVal, oldVal) {
                if(this.Notdragged)
                {
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
                this.$emit('updateSlider', [this.value2, this.item])
                //    this.value3 = newVal[0]
                //     this.value4 = newVal[1]
            },


        }
    }

</script>
