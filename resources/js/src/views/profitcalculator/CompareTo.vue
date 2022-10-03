<template>

    <b-card title="" class="w-75 mx-auto">
        <b-row>
            <b-col sm="12" md="12" lg="4" xl="4" class="mb-1">
                <label>Invest in</label>
                <b-input-group label="Invest in">
                    <vue-autosuggest ref="autocomplete" class="w-100" v-model="query" :suggestions="suggestions"
                        :input-props="inputProps" @focus="isFocused = true" @blur="isFocused = false"
                        :section-configs="sectionConfigs" :render-suggestion="renderSuggestion"
                        :should-render-suggestions="(size, loading) => (size >= 0 && !loading) || isFocused"
                        :get-suggestion-value="getSuggestionValue" @input="fetchResults" />
                </b-input-group>
            </b-col>
            <b-col sm="12" md="12" lg="4" xl="4" class="mb-1">
                <label>Investments</label>

                <b-input-group append="$" label="Investments">
                    <cleave :options="NumberFormaVal" class="form-control" v-model="investPrice" v-numeric-only
                        placeholder="amount" />
                </b-input-group>

            </b-col>
            <b-col sm="12" md="12" lg="4" xl="4" class="mb-1">
                <label>Compare to</label>
                <b-input-group label="Compare to">
                    <vue-autosuggest ref="autocomplete" class="w-100" v-model="query2" :suggestions="suggestionsCompare"
                        :input-props="inputProps" @focus="isFocused2 = true" @blur="isFocused2 = false"
                        :section-configs="sectionConfigsCompare" :render-suggestion="renderSuggestionCompare"
                        :should-render-suggestions="(size, loading) => (size >= 0 && !loading) || isFocused2"
                        :get-suggestion-value="getSuggestionValueCompare" @input="fetchResultsCompare" />
                </b-input-group>
            </b-col>
        </b-row>

        <b-card v-if="show == 1 &&selected != null && selectedCompare != null">
            <b-row class="">
                <b-col md="12" xl="12" class="text-center">
                    <div class="radius_gradient">
                        <b-card title="Potential Profit" class="mx-auto innerCard text-center str_green_gradient" style="max-width:200px">
                            <b-row>
                                <div class="text-center m-auto">
                                    <b-col cols="12" class="darkWhiteText" style="margin-top:30px; font-family: 'Poppins';
                                        font-style: normal;
                                        font-weight: 500;
                                        font-size: 32px;">
                                        <p v-if="Potential >=1" class="text-wrap" style="width:160px">
                                            {{ roundData(Potential)?roundData(Potential):0 }}$</p>
                                            <p v-else class="text-wrap" style="width:160px">
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
                    </div>
                </b-col>

            </b-row>
        </b-card>
        <b-card v-else-if="show=0">
            <b-card-text class="mt-1 text-center">
                No coin selected
            </b-card-text>
        </b-card>
        <b-card v-else>
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
                query2: '',
                timeout: null,
                selected: null,
                selectedCompare: null,
                sendForm: false,
                debounceMilliseconds: 250,
                inputProps: {
                    id: 'autosuggest__input_ajax',
                    placeholder: 'Search',
                    class: 'form-control',
                    name: 'ajax',
                },
                investPrice: null,
                Potential: 0,
                ATLPotential: 0,
                isFocused: false,
                isFocused2: false,
                suggestions: [],
                suggestionsCompare: [],
                show: 2,
                capTimes: 0,
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
                                if (this.selected != null && this.selected.market_cap != 0 && this
                                    .selectedCompare != null && this.selectedCompare.market_cap != 0 && this
                                    .investPrice != null && this.investPrice.trim() != '') {
                                    this.capTimes = this.selectedCompare.market_cap.toFixed(2) / this
                                        .selected
                                        .market_cap.toFixed(2);

                                    this.Potential = this.capTimes.toFixed(2) * this.investPrice;
                                    this.show = 1;
                                } else {
                                    this.show = 2;
                                }

                            })
                        }

                        // this.selected = selected.item

                    },

                },
                sectionConfigsCompare: {
                    coins: {
                        limit: 100,
                        label: 'Coins',
                        onSelected: selected => {

                            this.isFocused2 = false;
                            axios.post('api/load-single-coin', {
                                coinid: selected.item.coin_id
                            }).then(res => {

                                this.selectedCompare = res.data.coin;
                                if (this.selected != null && this.selected.market_cap != 0 && this
                                    .selectedCompare != null && this.selectedCompare.market_cap != 0 && this
                                    .investPrice != null && this.investPrice.trim() != '') {
                                    this.capTimes = this.selectedCompare.market_cap.toFixed(2) / this
                                        .selected
                                        .market_cap.toFixed(2);

                                    this.Potential = this.capTimes.toFixed(2) * this.investPrice;
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
                        const coins = this.filterResults(values[0].data, query, 'name')
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
            fetchResultsCompare() {
                const {
                    query
                } = this

                clearTimeout(this.timeout)
                this.timeout = setTimeout(() => {
                    const coinsPromise = axios.post('api/autosuggestcoins', {
                        key: this.query2
                    })
                    Promise.all([coinsPromise]).then(values => {
                        this.suggestionsCompare = []
                        this.selectedCompare = null
                        const coins = this.filterResults(values[0].data, query, 'name')
                        coins.length && this.suggestionsCompare.push({
                            name: 'coins',
                            data: coins
                        })
                    })
                }, this.debounceMilliseconds)
            },
            filterResultsCompare(data, text, field) {
                return data.filter(item => {
                    if (item[field].toLowerCase().indexOf(text.toLowerCase()) > -1) {
                        return item[field]
                    }
                    return FormInputContextualStatesVue
                }).sort()
            },
            renderSuggestionCompare(suggestion) {
                return suggestion.item.name + ' (' + suggestion.item.symbol + ')';
            },
            getSuggestionValueCompare(suggestion) {
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
        mounted() {},
        watch: {
            'investPrice': function () {
                if (this.selected != null && this.selected.market_cap != 0 && this.selectedCompare != null && this
                    .selectedCompare.market_cap != 0 && this
                    .investPrice != null && this.investPrice.trim() != '') {
                    this.capTimes = this.selectedCompare.market_cap.toFixed(2) / this.selected
                        .market_cap.toFixed(2);

                    this.Potential = this.capTimes.toFixed(2) * this.investPrice;
                    this.show = 1;
                } else {
                    this.show = 2;
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

</style>
<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
