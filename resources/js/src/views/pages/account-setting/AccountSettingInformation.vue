<template>
    <b-card>
        <!-- form -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
            <b-form @submit.prevent="handleSubmit(updateInformation)" @reset.prevent="resetForm">
                <b-row>
                    <!-- bio -->
                    <b-col cols="12">
                        <b-form-group label="Bio" label-for="bio-area">
                            <b-form-textarea id="bio-area" v-model="informationData.bio" rows="4"
                                placeholder="Your bio data here..." />
                        </b-form-group>
                    </b-col>
                    <!--/ bio -->

                    <!-- birth date -->
                    <b-col md="6">
                        <b-form-group label-for="example-datepicker" label="Birth date">
                         
                                <flat-pickr v-model="informationData.dob" class="form-control" name="date"
                                    placeholder="Birth date" />
                               
                        </b-form-group>
                    </b-col>
                    <!--/ birth date -->
                    <!-- Country -->
                    <b-col md="6">
                        <b-form-group label-for="countryList" label="Country">
                            <v-select id="countryList" v-model="informationData.country"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'" label="title"
                                :options="countries" />
                        </b-form-group>
                    </b-col>
                    <!--/ Country -->
                    <!-- website -->
                    <b-col md="6">
                        <b-form-group label-for="website" label="Website">
                            <b-form-input id="website" v-model="informationData.website"
                                placeholder="Website address" />
                        </b-form-group>
                    </b-col>
                    <!--/ website -->
                    <!-- phone -->
                    <b-col md="6">
                 
                        <b-form-group label-for="Contact" label="Phone">
                           <validation-provider #default="validationContext" name="Mobile"
                                :rules="`required`">
                            <cleave id="phone" v-model="informationData.contact" class="form-control" :raw="false"
                                :options="clevePhone" placeholder="Phone number" />
                                 <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!-- phone -->
                    <b-col cols="12">
                        <b-button type="submit" v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary" class="mt-1 mr-1">
                            Save changes
                        </b-button>
                        <b-button v-if="false" v-ripple.400="'rgba(186, 191, 199, 0.15)'" type="reset" class="mt-1"
                            variant="outline-secondary" @click.prevent="resetForm">
                            Reset
                        </b-button>
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card>
</template>

<script>
    import {
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BCard,
        BFormTextarea,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import flatPickr from 'vue-flatpickr-component'
    import Ripple from 'vue-ripple-directive'
    import Cleave from 'vue-cleave-component'
    import {
        useToast
    } from 'vue-toastification/composition'
    import countries from '@/@fake-db/data/other/countries'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import {
        required,
        alphaNum,
        email,
        uniqueMail,
        uniqueUsername2,
        uniqueMail2
    } from '@validations'
    // eslint-disable-next-line import/no-extraneous-dependencies
    import 'cleave.js/dist/addons/cleave-phone.us'

    export default {
        components: {
            BButton,
            BForm,
            BFormGroup,
            BFormInput,
            BRow,
            BCol,
            BCard,
            BFormTextarea,
            vSelect,
            flatPickr,
            Cleave,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback
        },
        directives: {
            Ripple,
        },
        props: {
            informationData: {
                type: Object,
                default: () => {},
            },
        },
        data() {
            return {
                clevePhone: {
                    phone: true,
                    phoneRegionCode: 'US',
                    required,
                    alphaNum,
                    email,
                    uniqueMail,
                    uniqueUsername2,
                    uniqueMail2
                },
            }
        },
        methods: {
            resetForm() {
                this.informationData =this.informationData;
            },
        },
        setup(props) {
            const toast = useToast()

            const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

            const genderOptions = [{
                    text: 'Male',
                    value: 'male'
                },
                {
                    text: 'Female',
                    value: 'female'
                },
            ]

            const contactOptionsOptions = ['Email', 'Message', 'Phone']
            const updateInformation = () => {
              let params = {
                bio:props.informationData.bio,
                contact:props.informationData.contact,
                country:props.informationData.country,
                dob:props.informationData.dob,
                website:props.informationData.website
              }
                axios
                    .post(`api/user/updateprofileinformation`, params)
                    .then(response => {
                        if (response.data.status == 'success') {
                            localStorage.setItem('userData', JSON.stringify(response.data.user))
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Notificatons are updated',
                                    variant: 'success',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Something went wrong!',
                                    variant: 'error',
                                },
                            })
                        }

                    })
            }
            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(props.userData)

            return {
                languageOptions,
                genderOptions,
                contactOptionsOptions,
                countries,
                updateInformation,
                refFormObserver,
                getValidationState,
            }


        }
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-select.scss';
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
