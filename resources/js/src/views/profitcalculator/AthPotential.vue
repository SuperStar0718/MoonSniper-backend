<template>
    <b-card title="" class="w-75 mx-auto" style="background:transparent !important">
        <b-row>
            <b-col sm="12" md="6" lg="6" xl="6" class="mb-1">
                <label>Invest in</label>
                <b-input-group label="Invest in">
                    <vue-autosuggest ref="autocomplete" class="w-100" v-model="query" :suggestions="suggestions"
                        :input-props="inputProps" @focus="isFocused = true" @blur="isFocused = false"
                        :section-configs="sectionConfigs" :render-suggestion="renderSuggestion"
                        :should-render-suggestions="(size, loading) => (size >= 0 && !loading) || isFocused"
                        :get-suggestion-value="getSuggestionValue" @input="fetchResults" />
                </b-input-group>
            </b-col>
            <b-col sm="12" md="6" lg="6" xl="6">
                <label>Investments</label>

                <b-input-group append="$" label="Investments">
                    <cleave :options="NumberFormaVal" class="form-control" v-model="investPrice" v-numeric-only
                        placeholder="amount" />
                </b-input-group>

            </b-col>
        </b-row>

        <b-card v-if="show == 1&&selected != null" style="background:transparent !important">
            <b-row class="">
                <b-col md="6" xl="6" class="float-right">
                    <!-- <div class="radius_gradient m-auto" style="max-width: 350px;">
                        <b-card title="Potential Profit" class="mx-auto innerCard text-center str_green_gradient" style="max-width:350px">
                            <b-row>
                                <div class="text-center m-auto">
                                    <b-col cols="12" class="darkWhiteText" style="margin-top:30px; font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 32px;">
                                        <p v-if="Potential >=1" class="text-wrap" style="width:210px;">
                                            {{ roundData(Potential)?roundData(Potential):0 }}$</p>
                                            <p v-else class="text-wrap" style="width:210px;">
                                                {{ Potential?Potential:0 }}$</p>
                                    </b-col>
                                    <b-col cols="12" style="font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 18px;
                                        color: #50DC5F;">
                                        <p v-if="capTimes>=1" class="text-wrap">
                                            {{ roundData(capTimes) }}X</p>
                                            <p v-else class="text-wrap">
                                                {{ capTimes}}X</p>
                                    </b-col>
                                </div>
                            </b-row>
                        </b-card>
                    </div> -->
                    <div class="radius_gradient">
                        <b-card title="ATH Potential" class="mx-auto innerCard text-center str_green_gradient" style="max-width:240px;">
                            <b-row>
                                <div class="text-center m-auto">
                                    <b-col cols="12" class="darkWhiteText" style="margin-top:30px; font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 32px;" >
                                        <p  v-if="ATHPotential >=1" class="text-wrap" >
                                            {{ roundData(ATHPotential)?roundData(ATHPotential):0 }}$</p>
                                            <p v-else class="text-wrap" >
                                                {{ATHPotential?ATHPotential:0 }}$</p>
                                    </b-col>
                                    <b-col cols="12" style="font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 18px;
                                        color: #50DC5F;">
                                        <p class="text-wrap"  v-if="selected.athX >=1"> {{roundData(selected.athX) }}X</p>
                                        <p class="text-wrap"  v-else> {{selected.athX }}X</p>
                                    </b-col>
                                </div>
                            </b-row>

                        </b-card>
                    </div>
                </b-col>
                <b-col md="6" xl="6" class="">
                    <div class="radius_gradient">
                        <b-card title="ATL Potential" class="mx-auto innerCard text-center str_green_gradient" style="max-width:240px;">
                            <b-row>
                                <div class="text-center m-auto">
                                    <b-col cols="12" style="margin-top:30px; font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 32px;">
                                        <p class="text-wrap" style="line-height: 30px; max-width: 204px;" v-if="ATLPotential >= 1">   {{ roundData(ATLPotential)?roundData(ATLPotential):0 }}$</p>
                                        <p class="text-wrap" style="line-height: 30px; max-width: 204px;" v-else>   {{ ATLPotential?ATLPotential:0 }}$</p>
                                    </b-col>
                                    <b-col cols="12" style="font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 18px;
                                        color: #50DC5F;">
                                        <p class="text-wrap  text-danger"    v-if="selected.atlX >= 1"> {{ roundData(selected.atlX) }}X</p>
                                        <p class="text-wrap text-danger"    v-else> {{ selected.atlX }}X</p>
                                    </b-col>
                                </div>
                            </b-row>

                        </b-card>
                    </div>
                </b-col>
            </b-row>
        </b-card>
        <b-card v-else style="background:transparent !important">
            <b-card-text class="mt-1 text-center">
                No Data To Show
            </b-card-text>
        </b-card>
    </b-card>
</template>

<script>
    /* eslint-disable vue/no-unused-components */
    /* eslint no-unused-expressions: ["error", { "allowShortCircuit": true }] */
    import Cleave from 'vue-cleave-component'
    import {
        BCard,
        BCardText,
        BAvatar,
        BFormInput,
        BRow,
        BCol,
        BFormGroup,
        BFormDatepicker,
        BForm,
        BButton,
        BFormInvalidFeedback,
        BSpinner,
        BFormSelect,
        BInputGroup

    } from 'bootstrap-vue'
    import {
        VueAutosuggest
    } from 'vue-autosuggest'
    import axios from '@axios'
    import flatPickr from 'vue-flatpickr-component'
    import FormInputContextualStatesVue from '../forms/form-element/form-input/FormInputContextualStates.vue'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {
        required,
        alphaNum,
        integer,
        double,
        digits
    } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    export default {
        components: {
            VueAutosuggest,
            BCard,
            BCardText,
            BAvatar,
            BFormInput,
            BFormGroup,
            BRow,
            BCol,
            flatPickr,
            BFormDatepicker,
            BButton,
            BForm,
            ToastificationContent,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback,
            BSpinner,
            BFormSelect,
            Cleave,
            BInputGroup

        },
        data() {
            return {
                query: '',
                timeout: null,
                selected: null,
                sendForm: false,
                show: 0,
                debounceMilliseconds: 250,
                inputProps: {
                    id: 'autosuggest__input_ajax',
                    placeholder: 'Search',
                    class: 'form-control',
                    name: 'ajax',
                },
                investPrice: null,
                ATHPotential: 0,
                ATLPotential: 0,
                isFocused: false,
                suggestions: [],
                sectionConfigs: {
                    coins: {
                        limit: 100,
                        label: 'Coins',
                        onSelected: selected => {

                            this.isFocused = false;
                            axios.post('api/load-single-coin', {
                                coinid: selected.item.coin_id
                            }).then(res => {
                                this.selected = res.data.coin;
                               
                                if (this.selected != null && this.selected != "") {
                                    this.selected.athX = (this.selected.ath / this.selected.current_price)
                                    this.selected.atlX = (this.selected.current_price /this.selected.atl )
                                    this.ATHPotential = this.investPrice * this.selected.athX;
                                    this.ATLPotential = this.investPrice / this.selected.atlX;
                                    this.show = 1;
                                } else {
                                    this.show = 0;

                                }

                            })
                        }

                        // this.selected = selected.item

                    },

                },

                NumberFormaVal: {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                },
            }
        },
        methods: {
            fetchResults() {
                const {
                    query
                } = this

                clearTimeout(this.timeout)
                this.timeout = setTimeout(() => {
                    const coinsPromise = axios.post('api/autosuggestcoins', {
                        key: this.query
                    })
                    Promise.all([coinsPromise]).then(values => {
                        this.suggestions = []
                        this.selected = null
                        const coins = values[0].data;
                        coins.length && this.suggestions.push({
                            name: 'coins',
                            data: coins
                        })
                    })
                }, this.debounceMilliseconds)
            },
            filterResults(data, text, field) {
                return data.filter(item => {
                    if (item[field].toLowerCase().indexOf(text.toLowerCase()) > -1) {
                        return item[field]
                    }
                    return FormInputContextualStatesVue
                }).sort()
            },
            renderSuggestion(suggestion) {
                return suggestion.item.name + ' (' + suggestion.item.symbol + ')';
            },
            getSuggestionValue(suggestion) {
                return suggestion.item.name + ' (' + suggestion.item.symbol + ')';
            },
            toInterNationalNumber(val) {
                if (val)
                    return new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 15,
                    }).format(val);
            },
            roundData(val) {
                if (val) {
                    return this.toInterNationalNumber(parseFloat(val).toFixed(2));
                }
            },
        },
        mounted() {
            
        },
        watch: {
            'investPrice': function () {
                if (this.selected != null && this.selected != "" ) {
                    this.selected.athX = (this.selected.ath / this.selected.current_price)
                    this.selected.atlX = (this.selected.current_price /this.selected.atl )
                    this.ATHPotential = this.investPrice * this.selected.athX;
                    this.ATLPotential = this.investPrice / this.selected.atlX;
                    this.show = 1
                } else {
                    this.show = 0
                }
            },
        }
    }

</script>

<style lang="scss" scoped>
    pre {
        min-height: 295px;
        padding: 1.5rem;
        margin-bottom: 0;
        border-radius: .5rem;
    }

    .invalid-feedback {
        display: block !important;
    }

    .innerCard {
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, .15) !important;
        -webkit-transition: all 0.3s ease-in-out, background 0s, color 0s, border-color 0s !important;
    }

    .card-body {
        padding: 1.5em !important;
    }

</style>
<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
