<template>
    <b-card>
        <!-- form -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
            <b-form @submit.prevent="handleSubmit(updatePassword)">
                <b-row>
                    <!-- old password -->
                    <b-col md="6">
                        <b-form-group label="Old Password" label-for="account-old-password">
                            <validation-provider #default="validationContext" vid="oldpassword" name="Old-Password" rules="required">
                                <b-input-group class="input-group-merge">

                                    <b-form-input id="account-old-password" v-model="passwords.oldpassword"
                                        name="old-password" :type="passwordFieldTypeOld" placeholder="Old Password" />
                                    <b-input-group-append is-text>
                                        <feather-icon :icon="passwordToggleIconOld" class="cursor-pointer"
                                            @click="togglePasswordOld" />
                                    </b-input-group-append>

                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!--/ old password -->
                </b-row>
                <b-row>
                    <!-- new password -->
                    <b-col md="6">
                        <b-form-group label-for="account-new-password" label="New Password">
                            <validation-provider #default="validationContext" name="New-Password" rules="required">
                                <b-input-group class="input-group-merge">
                                    <b-form-input id="account-new-password" v-model="passwords.password"
                                        :type="passwordFieldTypeNew" name="new-password" placeholder="New Password" />
                                    <b-input-group-append is-text>
                                        <feather-icon :icon="passwordToggleIconNew" class="cursor-pointer"
                                            @click="togglePasswordNew" />
                                    </b-input-group-append>
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!--/ new password -->

                    <!-- retype password -->
                    <b-col md="6">
                        <b-form-group label-for="account-retype-new-password" label="Confirm New Password">
                            <validation-provider #default="validationContext" name="Confirm Password" rules="required|confirmed:New-Password">
                                <b-input-group class="input-group-merge">
                                    <b-form-input id="account-retype-new-password" v-model="passwords.password_confirmation"
                                        :type="passwordFieldTypeRetype" name="retype-password"
                                        placeholder="New Password" />
                                    <b-input-group-append is-text>
                                        <feather-icon :icon="passwordToggleIconRetype" class="cursor-pointer"
                                            @click="togglePasswordRetype" />
                                    </b-input-group-append>
                                </b-input-group>
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <!--/ retype password -->

                    <!-- buttons -->
                    <b-col cols="12">
                        <b-button type="submit" v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary" class="mt-1 mr-1">
                            Save changes
                        </b-button>
                        <b-button v-ripple.400="'rgba(186, 191, 199, 0.15)'" type="reset" variant="outline-secondary"
                            class="mt-1">
                            Reset
                        </b-button>
                    </b-col>
                    <!--/ buttons -->
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
        BInputGroup,
        BInputGroupAppend,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import {
        useToast
    } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import {
        required,
        alphaNum,
        email,
        uniqueMail,
        uniqueUsername2,
        uniqueMail2,
        confirmed
    } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import {
        ref,reactive
    } from '@vue/composition-api'
import axios from '@axios'
    export default {
        components: {
            BButton,
            BForm,
            BFormGroup,
            BFormInput,
            BRow,
            BCol,
            BCard,
            BInputGroup,
            BInputGroupAppend,
            BFormInvalidFeedback,
            ValidationProvider,
            ValidationObserver
        },
        directives: {
            Ripple,
        },
        props:{
          passwords:{
            type:Object,
               default: () => {},
          }
        },
        
        data() {
            return {
                oldpassword: '',
                password: '',
                password_confirmation: '',
                passwordFieldTypeOld: 'password',
                passwordFieldTypeNew: 'password',
                passwordFieldTypeRetype: 'password',
                required,
                alphaNum,
                email,
                uniqueMail,
                uniqueUsername2,
                uniqueMail2,
                confirmed
            }
        },

        computed: {
            passwordToggleIconOld() {
                return this.passwordFieldTypeOld === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
            passwordToggleIconNew() {
                return this.passwordFieldTypeNew === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
            passwordToggleIconRetype() {
                return this.passwordFieldTypeRetype === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
        },
        methods: {

            togglePasswordOld() {
                this.passwordFieldTypeOld = this.passwordFieldTypeOld === 'password' ? 'text' : 'password'
            },
            togglePasswordNew() {
                this.passwordFieldTypeNew = this.passwordFieldTypeNew === 'password' ? 'text' : 'password'
            },
            togglePasswordRetype() {
                this.passwordFieldTypeRetype = this.passwordFieldTypeRetype === 'password' ? 'text' : 'password'
            },

        },
        setup(props,{refs}) {
 const toast = useToast()
           
            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(
               props.passwords
           )
            const updatePassword = ()=>{
             
                axios
                    .post(`api/user/updatepassword`,  props.passwords)
                    .then(response => {
                        if (response.data.status == 'success') {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Password has been updated',
                                    variant: 'success',
                                },
                            })
                        }else{
                          refs.refFormObserver.setErrors({"oldpassword":["Old password doesn't match."]})
                        }

                    }).catch(error => {
                      console.log(error);
                        refs.refFormObserver.setErrors(error.data.errors)
                    })
            }
            return {
                refFormObserver,
                getValidationState,
                updatePassword
            }
        }
    }

</script>
