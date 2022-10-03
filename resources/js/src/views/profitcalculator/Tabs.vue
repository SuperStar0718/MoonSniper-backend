<template>
    <b-row>
        <b-col cols="12">
            <b-card title="">
                <div class="darkWhiteText" style="font-family: 'Poppins';
                    font-style: normal;
                    font-weight: 600;
                    font-size: 24px;
                    margin-top: 26px;
                    margin-bottom: 26px;
                    text-align: center;
                    ">
                    Profit Calculator
                </div>
                <b-tabs content-class="pt-2">
                    <b-tab active title="ATH Potential">
                        <AthPotentialVue />
                    </b-tab>
                    <b-tab title=" Compare to Token">
                        <CompareToVue/>
                    </b-tab>
                    <b-tab title="Avagare top 5 potential calculators">
                        <AverageFiveVue/>
                    </b-tab>
                </b-tabs>
            </b-card>
        </b-col>
    </b-row>
</template>

<script>
    /* eslint-disable vue/no-unused-components */
    /* eslint no-unused-expressions: ["error", { "allowShortCircuit": true }] */
    import {
        BCard,
        BCardText,
        BButton,
        BSpinner,
        BFormSelect,
        BTabs,
        BTab, BRow, BCol 
    } from 'bootstrap-vue'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import AthPotentialVue from './AthPotential.vue'
import CompareToVue from './CompareTo.vue'
import AverageFiveVue from './AverageFive.vue'

    export default {
        components: {
            BCard,
            BCardText,
            BButton,
            ToastificationContent,
            BSpinner,
            BFormSelect,
            BTabs,
            BTab,
            BRow, BCol,
            AthPotentialVue,
            CompareToVue,
            AverageFiveVue

        },
        data() {
            return {

            }
        },

    }

</script>

</style>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
