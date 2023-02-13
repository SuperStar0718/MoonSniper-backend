<template>
    <div>
        <div>
            <div id="alerts">
                <div class="darkWhiteText" style="font-family: 'Poppins';
    font-style: normal;
    font-weight: 600;
    font-size: 24px;
    margin-top: 26px;
    margin-bottom: 26px;
    text-align: center;
    ">
                    Add or Edit Launchpad coins
                </div>
            </div>
        </div>
        <b-card title="Coins">
         <div class="d-flex justify-between">
           <div class="" style="width:85%">
            <vue-autosuggest ref="autocomplete" v-model="query" :suggestions="suggestions" :input-props="inputProps"
            @focus="isFocused = true" @blur="isFocused = false" :section-configs="sectionConfigs"
            :render-suggestion="renderSuggestion"
            :should-render-suggestions="(size, loading) => (size >= 0 && !loading) || isFocused"
            :get-suggestion-value="getSuggestionValue" @input="fetchResults" />
           </div>
                <div class="mx-auto">
                    <button v-if="editmode" @click="toggleAddNewButton(false)" class="btn btn-outline-dark ">Add new</button>
                    <button v-else @click="toggleAddNewButton(true)"  class="btn btn-outline-dark ">Edit coin</button>
                </div>
         </div>
         <div v-if="editmode">
             <b-card class="border mt-2" no-body v-if="selected">

                <b-card title="Edit coin">
                    <validation-observer ref="UpdateForm" #default="{invalid}" >
                        <b-form>
                            <b-row>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Icon" label-for="icon">
                                        <validation-provider #default="{ errors }" name="Icon"
                                            vid="icon" rules="required">
                                            <div class="">
                                                <b-avatar v-if="!selected.iconBase64" ref="previewEl" :src="'storage/launchpad/icons/'+selected.icon" :text="selected.launchpad?selected.launchpad[0]:''"
                                                size="90px" rounded />
                                                <b-avatar v-else ref="previewEl" :src="selected.icon" :text="selected.launchpad?selected.launchpad[0]:''"
                                                size="90px" rounded />
                                                <b-button variant="primary" @click="$refs.refInputEl.click()">
                                                    <input ref="refInputEl" type="file" class="d-none" @change="consumeIcon">
                                                    <span class="d-none d-sm-inline">Update</span>
                                                    <feather-icon icon="EditIcon" class="d-inline d-sm-none" />
                                                </b-button>
                                               
                                              </div>
                                            <b-form-invalid-feedback>
                                                {{ errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Launchpad" label-for="launchpad">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="launchpad" rules="required">
                                            <b-form-input  id="icon" v-model="selected.launchpad" />
                                                <b-form-invalid-feedback>
                                                    {{ errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>                                                              
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <!-- basic -->
                                  
                                    <b-form-group label="Project" label-for="project">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="project" rules="required">
                                        <b-form-input id="project"
                                            v-model="selected.project" />
                                            <b-form-invalid-feedback>
                                                {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>      
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Category" label-for="category">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="category" rules="required">
                                        <b-form-input id="category" v-model="selected.category" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>      
                                    </b-form-group>
                                </b-col>


                         
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Market cap" label-for="market_cap">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="market_cap" rules="integer">
                                        <b-form-input id="market_cap" v-model="selected.market_cap" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Thicker" label-for="thicker">
                                        <validation-provider #default="{ errors }" name="Thicker"
                                        vid="thicker" rules="required">
                                        <b-form-input id="thicker" v-model="selected.thicker" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                 
                                    <b-form-group label="Launch time" label-for="launch_time">
                                     
                                        <flat-pickr v-model="selected.launch_time" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />
                                       
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="First unlock time" label-for="first_unlock_time">
                                       
                                        <flat-pickr v-model="selected.first_unlock_time" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />
                                    
                                           
                                    </b-form-group>
                                </b-col>
                           


                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Network" label-for="network">
                                        
                                        <b-form-input id="network" v-model="selected.network" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Ido public number" label-for="Ido public number">
                                        <validation-provider #default="{ errors }" name="Ido public number"
                                        vid="ido_public_number" rules="integer">
                                        <b-form-input id="ido_public_number" v-model="selected.ido_public_number" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Telegram" label-for="telegram">
                                        <b-form-input id="telegram" v-model="selected.telegram" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Website" label-for="website">
                                        <b-form-input id="website" v-model="selected.website" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Twitter" label-for="twitter">
                                        <b-form-input id="twitter" v-model="selected.twitter" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Tokenomies" label-for="tokenomies">
                                        <b-form-input id="tokenomies" v-model="selected.tokenomies" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Contract" label-for="contract">
                                        <b-form-input id="contract" v-model="selected.contract" />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row class="mt-2">
                                <b-col>
                                    <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                        @click="updateCoinData(selected.id,'save')" :disabled="sendForm || invalid"
                                        :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                        Save
                                        <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                    </b-button>
                                    <!-- <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                        @click="updateCoinData(selected.id,'saveandedit')"
                                        :disabled="sendForm || invalid"
                                        :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                        Save & Edit Another
                                        <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                    </b-button> -->
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
         </div>
         <div v-else>
            <b-card class="border mt-2" no-body>
                <b-card title="Add coin">
                    <validation-observer ref="AddForm" #default="{invalid}">
                        <b-form>
                            <b-row>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Icon" label-for="icon">
                                        <validation-provider #default="{ errors }" name="Icon"
                                            vid="icon" rules="required">
                                             <div class="">
                                               
                                                <b-avatar  v-if="form.iconBase64" ref="previewEl" :src="form.iconBase64" 
                                                size="90px" rounded />
                                                <b-button variant="primary" @click="$refs.refInputEl2.click()">
                                                    <input ref="refInputEl2" type="file" class="d-none" @change="consumeIconAdd">
                                                    <span class="d-none d-sm-inline">Update</span>
                                                    <feather-icon icon="EditIcon" class="d-inline d-sm-none" />
                                                </b-button>
                                               
                                              </div>
                                            <b-form-invalid-feedback>
                                                {{ errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Launchpad" label-for="launchpad">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="launchpad" rules="required">
                                            <b-form-input  id="icon" v-model="form.launchpad" />
                                                <b-form-invalid-feedback>
                                                    {{ errors[0] }}
                                            </b-form-invalid-feedback>
                                        </validation-provider>                                                              
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <!-- basic -->
                                  
                                    <b-form-group label="Project" label-for="project">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="project" rules="required">
                                        <b-form-input id="project"
                                            v-model="form.project" />
                                            <b-form-invalid-feedback>
                                                {{ errors[0] }}
                                        </b-form-invalid-feedback>
                                    </validation-provider>      
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Category" label-for="category">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="category" rules="required">
                                        <b-form-input id="category" v-model="form.category" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>      
                                    </b-form-group>
                                </b-col>


                         
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Market cap" label-for="market_cap">
                                        <validation-provider #default="{ errors }" name="Launchpad"
                                        vid="market_cap" rules="integer">
                                        <b-form-input id="market_cap" v-model="form.market_cap" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Thicker" label-for="thicker">
                                        <validation-provider #default="{ errors }" name="Thicker"
                                        vid="thicker" rules="required">
                                        <b-form-input id="thicker" v-model="form.thicker" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                 
                                    <b-form-group label="Launch time" label-for="launch_time">
                                        <flat-pickr v-model="form.launch_time" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />
                                       
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="First unlock time" label-for="first_unlock_time">
                                        <flat-pickr v-model="form.first_unlock_time" class="form-control"
                                        :config="{ enableTime: false,dateFormat: 'Y-m-d'}" />
                                    
                                       
                                    </b-form-group>
                                </b-col>
                           


                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Network" label-for="network">
                                        <b-form-input id="network" v-model="form.network" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Ido public number" label-for="Ido public number">
                                        <validation-provider #default="{ errors }" name="Ido public number"
                                        vid="ido_public_number" rules="integer">
                                        <b-form-input id="ido_public_number" v-model="form.ido_public_number" />
                                        <b-form-invalid-feedback>
                                            {{ errors[0] }}
                                    </b-form-invalid-feedback>
                                </validation-provider>    
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Telegram" label-for="telegram">
                                        <b-form-input id="telegram" v-model="form.telegram" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Website" label-for="website">
                                        <b-form-input id="website" v-model="form.website" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Twitter" label-for="twitter">
                                        <b-form-input id="twitter" v-model="form.twitter" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Tokenomies" label-for="tokenomies">
                                        <b-form-input id="tokenomies" v-model="form.tokenomies" />
                                    </b-form-group>
                                </b-col>
                                <b-col md="6" xl="3" class="mb-1">
                                    <b-form-group label="Contract" label-for="contract">
                                        <b-form-input id="contract" v-model="form.contract" />
                                    </b-form-group>
                                </b-col>
                            </b-row>
                            <b-row class="mt-2">
                                <b-col>
                                    <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                        @click="addCoinData('save')" :disabled="sendForm || invalid"
                                        :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                        Save
                                        <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                    </b-button>
                                    <!-- <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="click"
                                        @click="addCoinData('saveandedit')"
                                        :disabled="sendForm || invalid"
                                        :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                                        Save & Edit Another
                                        <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                                    </b-button> -->
                                </b-col>
                            </b-row>    
                            
                        </b-form>
                    </validation-observer>
                </b-card>
                
                <!-- <pre>{{ JSON.stringify(selected, null, 4) }}</pre> -->
            </b-card>
         </div>
            
        </b-card>
    </div>
</template>
<script>
    /* eslint-disable vue/no-unused-components */
    /* eslint no-unused-expressions: ["error", { "allowShortCircuit": true }] */
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
        useInputImageRenderer
    } from '@core/comp-functions/forms/form-utils'
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
            BFormSelect

        },
        data() {
            return {
                query: '',
                timeout: null,
                selected: null,
                sendForm: false,
                debounceMilliseconds: 250,
                form:{
                    iconBase64:null,
                    icon:null,
                    project:null,
                    category:null,
                    market_cap:null,
                    thicker:null,
                    launch_time:null,
                    first_unlock_time:null,
                    network:null,
                    ido_public_number:null,
                    telegram:null,
                    website:null,
                    twitter:null,
                    tokenomies:null,
                    contract:null,
                },
                inputProps: {
                    id: 'autosuggest__input_ajax',
                    placeholder: 'Enter coin name',
                    class: 'form-control',
                    name: 'ajax',
                },
                isFocused: false,
                suggestions: [],
                editmode:true,
                sectionConfigs: {
                    coins: {
                        limit: 100,
                        label: 'Coins',
                        onSelected: selected => {
                            this.isFocused = false;
                            this.selected = selected.item

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
                previewImage:null,
                required,
                alphaNum,
                integer,
                digits,
                double
            }
        },
        methods: {
            toggleAddNewButton(bool){
                this.editmode = bool;
                this.query = '';
                
            },
            fetchResults() {
                this.editmode =  true;
                const {
                    query
                } = this

                clearTimeout(this.timeout)
                this.timeout = setTimeout(() => {
                    const coinsPromise = axios.post('api/fetch-launchpad-coins-as', {
                        key: this.query
                    })
                    Promise.all([coinsPromise]).then(values => {
                        this.suggestions = []
                        this.selected = null
                        const coins = this.filterResults(values[0].data, query, 'launchpad')
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
                 return suggestion.item.launchpad;
            },
            getSuggestionValue(suggestion) {
                 return suggestion.item.launchpad ;
            },
            
            async updateCoinData(id, type) {
                this.sendForm = true;
                
                if (this.selected.id == id) {

                    let params = {
                        iconBase64: this.selected.iconBase64,
                        iconBase64: this.selected.iconBase64,
                        id: this.selected.id,
                        launchpad: this.selected.launchpad,
                        project: this.selected.project,
                        category: this.selected.category,
                        market_cap: this.selected.market_cap,
                        thicker: this.selected.thicker,
                        launch_time: this.selected.launch_time,
                        first_unlock_time: this.selected.first_unlock_time,
                        end_vc_unlock: this.selected.end_vc_unlock,
                        first_vc_unlock_text: this.selected.first_vc_unlock_text,
                        network: this.selected.network,
                        ido_public_number: this.selected.ido_public_number,
                        telegram: this.selected.telegram,
                        website: this.selected.website,
                        twitter: this.selected.twitter,
                        tokenomies: this.selected.tokenomies,
                        contract: this.selected.contract,
                    }
                    await axios.post('api/update-launchpad-coin', params,{
                        'content-type': 'multipart/form-data'
                    }).then(res => {
                        if (res.data.status == true) {
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


            },
            addCoinData(type){
                this.sendForm = true;
                   
                     axios.post('api/add-launchpad-coin', this.form,{
                        'content-type': 'multipart/form-data'
                    }).then(res => {
                        if (res.data.status == true) {
                            this.$toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Coin has been added',
                                    variant: 'success',
                                    icon: 'CheckCircleIcon',
                                },
                            });
                            this.editmode = true;

                            this.form= {
                                iconBase64:null,
                                icon:null,
                                project:null,
                                category:null,
                                market_cap:null,
                                thicker:null,
                                launch_time:null,
                                first_unlock_time:null,
                                network:null,
                                ido_public_number:null,
                                telegram:null,
                                website:null,
                                twitter:null,
                                tokenomies:null,
                                contract:null,
                            }
                        }
                    })
                    setTimeout(() => {
                        this.sendForm = false;
                    }, 1000);
                if (type != 'save') {
                    this.selected = null;
                    this.$refs.autocomplete.$el.click();
                    this.isFocused = true;
                }
            },
            consumeIcon(event){
                const refInputEl = this.$refs.refInputEl;
                const file = refInputEl.files[0];
                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    // The base64 encoded string is stored in the result property
                   this.selected.iconBase64 = reader.result;
                   this.selected.icon = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            },
            consumeIconAdd(event){
                const refInputEl2 = this.$refs.refInputEl2;
                const file = refInputEl2.files[0];
                const reader = new FileReader();
                reader.addEventListener('load', () => {
                    // The base64 encoded string is stored in the result property
                   this.form.iconBase64 = reader.result;
                   this.form.icon = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            }

        },
        mounted() {
            
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
    @import '~@resources/scss/vue/libs/vue-autosuggest.scss';
    .imagePreviewWrapper {
        width: 60px;
        height: 60px;
        display: block;
        cursor: pointer;
        margin: 0;

        background-size: cover;
        background-position: center center;
    }
</style>
