<template>
    <div>

        <!-- Header: Personal Info -->
        <div class="d-flex">
            <feather-icon icon="UserIcon" size="19" />
            <h4 class="mb-0 ml-50">
                Personal Information
            </h4>
        </div>

        <!-- Form: Personal Info Form -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
            <b-form class="mt-1" @submit.prevent="handleSubmit(updateInformation)" @reset.prevent="resetForm">
                <b-row>

                    <!-- Field: Birth Date -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Birth Date" label-for="birth-date">

                            <flat-pickr v-model="userData.dob" class="form-control" :config="{ dateFormat: 'Y-m-d'}"
                                placeholder="YYYY-MM-DD" />

                        </b-form-group>
                    </b-col>

                    <!-- Field: Mobile -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Contact" label-for="contact">
                            <validation-provider #default="validationContext" name="Contact"
                                rules="">
                                <b-form-input id="contact" v-model="userData.contact" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- Field: Website -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Website" label-for="website">
                            <b-form-input id="website" v-model="userData.website" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Language -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Language" label-for="language">
                            <v-select v-model="userData.language" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="languageOptions" :clearable="false" input-id="language" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Gender -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Gender" label-for="gender" label-class="mb-1">
                            <b-form-radio-group id="gender" v-model="userData.gender" :options="genderOptions"
                                value="male" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Contact Options -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Contact Options" label-for="contact-options" label-class="mb-1">
                            <b-form-checkbox-group id="contact-options" v-model="userData.contactOptions"
                                :options="contactOptionsOptions" />
                        </b-form-group>
                    </b-col>
                </b-row>

                <!-- Header: Personal Info -->
                <div class="d-flex mt-2">
                    <feather-icon icon="MapPinIcon" size="19" />
                    <h4 class="mb-0 ml-50">
                        Address
                    </h4>
                </div>

                <!-- Form: Personal Info Form -->
                <b-row class="mt-1">

                    <!-- Field: Address Line 1 -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Address Line 1" label-for="address-line-1">
                            <b-form-input id="address-line-1" v-model="userData.addressLine1" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Address Line 2 -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Address Line 2" label-for="address-line-2">
                            <b-form-input id="address-line-2" v-model="userData.addressLine2"
                                placeholder="Los Santos" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Postcode -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Postcode" label-for="postcode">
                            <b-form-input id="postcode" v-model="userData.postcode" type="number"
                                placeholder="597626" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: City -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="City" label-for="city">
                            <b-form-input id="city" v-model="userData.city" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: State -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="State" label-for="state">
                            <b-form-input id="state" v-model="userData.state" placeholder="Manhattan" />
                        </b-form-group>
                    </b-col>

                    <!-- Field: Country -->
                    <b-col cols="12" md="6" lg="4">
                        <b-form-group label="Country" label-for="country">
                            <!-- <validation-provider #default="validationContext" name="Country"
                                :rules="`required:${userData.id}`"> -->
                            <v-select v-model="userData.country" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countries" :clearable="false" input-id="user-country" />
                            <!-- <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider> -->
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row class="mt-2">
                    <b-col>
                        <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="submit"
                            :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                            Save Changes
                        </b-button>
                        <!-- <b-button variant="outline-secondary" :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                        Reset
                    </b-button> -->
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </div>
</template>

<script>
    import {
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCard,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormInvalidFeedback,
        BFormRadioGroup,
        BFormCheckboxGroup,
    } from 'bootstrap-vue'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import useUsersList from '../users-list/useUsersList'
    import {
        required,
        alphaNum,
        email,
        uniqueMail,
        uniqueUsername2,
        uniqueMail2
    } from '@validations'
    import flatPickr from 'vue-flatpickr-component'
    import {
        ref
    } from '@vue/composition-api'
    import vSelect from 'vue-select'
    import {
        useToast
    } from 'vue-toastification/composition'
    import countries from '@/@fake-db/data/other/countries'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import formValidation from '@core/comp-functions/forms/form-validation'
    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            flatPickr,
            BFormInput,
            vSelect,
            BFormRadioGroup,
            BFormCheckboxGroup,
            BButton,
            ToastificationContent,
            ValidationProvider,
            ValidationObserver,
            BFormInvalidFeedback
        },
        props: {
            userData: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                required,
                alphaNum,
                email,
                uniqueMail,
                uniqueUsername2,
                uniqueMail2
            }
        },
        setup(props,{refs}) {
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
                        refs.refFormObserver.validate().then(success => {
                    if (success) {
                axios
                    .post(`api/user/updateinformation/${props.userData.id}`, props.userData)
                    .then(response => {
                        if (response.data.status == 'success') {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Information details has been updated',
                                    variant: 'success',
                                      icon: 'CheckCircleIcon',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Something went wrong!',
                                    variant: 'error',
                                      icon: 'XCircleIcon',
                                },
                            })
                        }

                    })
            }
                        })}
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
                resetForm,

            }
        },
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-flatpicker.scss';

</style>
