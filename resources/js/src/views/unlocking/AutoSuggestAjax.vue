<template>
    <b-card title="Coins">
        <vue-autosuggest ref="autocomplete" v-model="query" :suggestions="suggestions" :input-props="inputProps"
            @focus="isFocused = true" @blur="isFocused = false" :section-configs="sectionConfigs"
            :render-suggestion="renderSuggestion"
            :should-render-suggestions="(size, loading) => (size >= 0 && !loading) || isFocused"
            :get-suggestion-value="getSuggestionValue" @input="fetchResults" />
        <b-card class="border" no-body v-if="selected">

            <b-card title="Update Coin's Details">
                <validation-observer ref="UpdateForm" #default="{invalid}">
                    <b-form>
                        <b-row>
                            <b-col md="6" xl="3" class="mb-1">

                                <b-form-group label="Total Locked" label-for="totallocked">
                                    <validation-provider #default="{ errors }" name="Total locker" vid="total_locker"
                                        rules="double">
                                        <b-form-input id="totallocked" v-model="selected.total_locked" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <b-row>

                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Next Unlock Date" label-for="nextunlockdate">
                                    <flat-pickr v-model="selected.next_unlock_date" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />

                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <!-- basic -->
                                <b-form-group label="Next Unlock Date (text)" label-for="nextunlockdatetext">
                                    <b-form-input id="nextunlockdatetext" v-model="selected.next_unlock_date_text" />
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Next Unlock Size" label-for="nextunlocksize">
                                    <b-form-select id="nextunlocksize" v-model="selected.next_unlock_size"
                                        :options="nextUnlockSize" />
                                </b-form-group>
                            </b-col>


                        </b-row>
                        <b-row>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Number of Tokens" label-for="nextunlocknumberoftokens">
                                    <validation-provider #default="{ errors }" name="Number of Token"
                                        vid="next_unlock_number_of_tokens" rules="double">
                                        <b-form-input id="nextunlocknumberoftokens"
                                            v-model="selected.next_unlock_number_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Percent of Tokens" label-for="nextunlockpercentoftokens">
                                    <validation-provider #default="{ errors }" name="Percent of Tokens"
                                        vid="next_unlock_percent_of_tokens" rules="double">
                                        <b-form-input id="nextunlockpercentoftokens"
                                            v-model="selected.next_unlock_percent_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Seed Price" label-for="seedprice">
                                    <validation-provider #default="{ errors }" name="Seed Price" vid="seed price"
                                        rules="double">
                                        <b-form-input id="seedprice" v-model="selected.seed_price" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                        </b-row>


                        <b-row>


                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Date of first VC unlock" label-for="firstvcunlock">
                                    <flat-pickr v-model="selected.first_vc_unlock" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Date of first VC unlock (Text)" label-for="firstvcunlocktext">
                                    <b-form-input id="firstvcunlocktext" v-model="selected.first_vc_unlock_text" />
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Date of last VC unlock" label-for="endvcunlock">
                                    <flat-pickr v-model="selected.end_vc_unlock" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />

                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Date of last VC unlock (Text)" label-for="endvcunlocktext">
                                    <b-form-input id="endvcunlocktext" v-model="selected.end_vc_unlock_text" />
                                </b-form-group>
                            </b-col>
                        </b-row>
                        <h5 class="mt-1">
                            Unlocks in the next 3 months:
                        </h5>
                        <b-row>

                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Number of Tokens" label-for="threemonthsunlocknumberoftokens">
                                    <validation-provider #default="{ errors }" name="Number of Tokens2"
                                        vid="three_months_unlock_number_of_tokens" rules="double">
                                        <b-form-input id="threemonthsunlocknumberoftokens"
                                            v-model="selected.three_months_unlock_number_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Percent of Tokens" label-for="threemonthsunlockpercentoftokens">
                                    <validation-provider #default="{ errors }" name="Percent of Tokens2"
                                        vid="three_months_unlock_percent_of_tokens" rules="double">
                                        <b-form-input id="threemonthsunlockpercentoftokens"
                                            v-model="selected.three_months_unlock_percent_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Unlock Size" label-for="threemonthsunlocksize">
                                    <b-form-select id="threemonthsunlocksize"
                                        v-model="selected.three_months_unlock_size" :options="nextUnlockSize" />
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <h5 class="mt-1">
                            Unlocks in the next 6 months:
                        </h5>
                        <b-row>

                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Number of Tokens" label-for="sixmonthsunlocknumberoftokens">
                                    <validation-provider #default="{ errors }" name="Number of Tokens3"
                                        vid="six_months_unlock_number_of_tokens" rules="double">
                                        <b-form-input id="sixmonthsunlocknumberoftokens"
                                            v-model="selected.six_months_unlock_number_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Percent of Tokens" label-for="sixmonthsunlockpercentoftokens">
                                    <validation-provider #default="{ errors }" name="Percent of Tokens3"
                                        vid="six_months_unlock_number_of_tokens" rules="double">
                                        <b-form-input id="sixmonthsunlockpercentoftokens 	"
                                            v-model="selected.six_months_unlock_percent_of_tokens" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>
                                </b-form-group>
                            </b-col>
                            <b-col md="6" xl="3" class="mb-1">
                                <b-form-group label="Unlock Size" label-for="sixmonthsunlocksize">
                                    <b-form-select id="sixmonthsunlocksize" v-model="selected.six_months_unlock_size"
                                        :options="nextUnlockSize" />
                                </b-form-group>
                            </b-col>

                        </b-row>
                        <b-row class="mt-2">
                            <b-col>
                                <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                    @click="updateCoinData(selected.coin_id,'save')" :disabled="sendForm || invalid"
                                    :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                    Save
                                    <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                </b-button>
                                <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                    @click="updateCoinData(selected.coin_id,'saveandedit')"
                                    :disabled="sendForm || invalid"
                                    :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                    Save & Edit Another
                                    <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                </b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </validation-observer>
            </b-card>
            <!-- <pre>{{ JSON.stringify(selected, null, 4) }}</pre> -->
        </b-card>
        <b-card v-else>
            <b-card-text class="mt-1">
                No coin selected
            </b-card-text>
        </b-card>
    </b-card>
</template>

<script>
    /* eslint-disable vue/no-unused-components */
    /* eslint no-unused-expressions: ["error", { "allowShortCircuit": true }] */
    import BCardCode from '@core/components/b-card-code/BCardCode.vue'
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
        BFormSelect

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
            BCardCode,
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
            BFormSelect

        },
        data() {
            return {
                query: '',
                timeout: null,
                selected: null,
                sendForm: false,
                debounceMilliseconds: 250,
                inputProps: {
                    id: 'autosuggest__input_ajax',
                    placeholder: 'Enter coin name',
                    class: 'form-control',
                    name: 'ajax',
                },
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
                            })
                            // this.selected = selected.item

                        },
                    },

                },
                nextUnlockSize: [{
                        value: null,
                        text: 'Please select some item'
                    },
                    {
                        value: 'small',
                        text: 'SMALL'
                    },
                    {
                        value: 'medium',
                        text: 'MEDIUM'
                    },
                    {
                        value: 'big',
                        text: 'BIG'
                    },
                ],
                required,
                alphaNum,
                integer,
                digits,
                double
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
                 return suggestion.item.name + ' ('+suggestion.item.symbol+')';
            },
            getSuggestionValue(suggestion) {
                 return suggestion.item.name + ' ('+suggestion.item.symbol+')';
            },
            async updateCoinData(coinid, type) {
                this.sendForm = true;
                if (this.selected.coin_id == coinid) {
                    let params = {
                        coinid: this.selected.coin_id,
                        total_locked: this.selected.total_locked,
                        next_unlock_date: this.selected.next_unlock_date,
                        next_unlock_date_text: this.selected.next_unlock_date_text,
                        next_unlock_number_of_tokens: this.selected.next_unlock_number_of_tokens,
                        next_unlock_percent_of_tokens: this.selected.next_unlock_percent_of_tokens,
                        next_unlock_size: this.selected.next_unlock_size,
                        first_vc_unlock: this.selected.first_vc_unlock,
                        end_vc_unlock: this.selected.end_vc_unlock,
                        first_vc_unlock_text: this.selected.first_vc_unlock_text,
                        end_vc_unlock_text: this.selected.end_vc_unlock_text,
                        three_months_unlock_number_of_tokens: this.selected
                            .three_months_unlock_number_of_tokens,
                        three_months_unlock_percent_of_tokens: this.selected
                            .three_months_unlock_percent_of_tokens,
                        three_months_unlock_size: this.selected.three_months_unlock_size,
                        six_months_unlock_number_of_tokens: this.selected.six_months_unlock_number_of_tokens,
                        six_months_unlock_percent_of_tokens: this.selected.six_months_unlock_percent_of_tokens,
                        six_months_unlock_size: this.selected.six_months_unlock_size,
                        seed_price: this.selected.seed_price,
                    }
                    await axios.post('api/update-coindata', params).then(res => {
                        if (res.data.status == 'success') {
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Coin details has been updated',
                                    variant: 'success',
                                    icon: 'CheckCircleIcon',
                                },
                            })
                        }
                    })
                    setTimeout(() => {
                        this.sendForm = false;
                    }, 1000);
                }
                if (type != 'save') {
                    this.selected = null;
                    this.$refs.autocomplete.$el.click();
                    this.isFocused = true;
                }


            }
        },
        mounted() {
            var params = {
                filters: [],
                "filters2": "",
                sort: ["market_cap", "desc"]
            };
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

</style>

</style>
<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
