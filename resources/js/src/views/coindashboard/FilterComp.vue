<template>
    <div>
        <b-form-group :label="modal">
            <div class="d-flex">
                <cleave :options="NumberFormaVal" class="form-control" v-model="value2[0]" v-numeric-only
                    placeholder="min" />
                <span>
                    <feather-icon icon="MinusIcon" size="16" class="align-middle" style="margin:10px 6px 0 0px" />
                </span>
                <cleave :options="NumberFormaVal" class="form-control" v-model="value2[1]" v-numeric-only
                    placeholder="max" />
            </div>

        </b-form-group>
        <div v-if="item != 7">
            <vue-slider :max="100" :min="0" v-model="value2" class="mb-2" />

        </div>
        <div v-else>
            <vue-slider :max="5" :min="0" v-model="value2" class="mb-2" />

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
                value2: this.value,
                NumberFormaVal: {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                },
            }
        },
        watch: {
            value2: function (newVal, oldVal) {
                if (oldVal && newVal) {
                    this.$emit('updateSlider', [newVal, this.item])
                }
            },
            value: function (newVal, oldVal) {
               this.value2 = newVal;
            },
        }
    }

</script>
