<template>
    <div class="auth-wrapper auth-v2">
        <b-row class="auth-inner m-0">

            <!-- Brand logo-->
            <b-link class="brand-logo">
                <!-- <vuexy-logo /> -->
                <img src="/images/moon/icon/fullcolor.png" alt="" style="width:80px">
                <h2 class="brand-text text-primary ml-1 my-auto">
                    <img src="/images/moon/text/fullcolor.png" alt="" style="height:30px">
                </h2>
            </b-link>
            <!-- /Brand logo-->

            <!-- Left Text-->
            <b-col lg="8" class="d-none d-lg-flex align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <b-img fluid :src="imgUrl" alt="Register V2" />
                </div>
            </b-col>
            <!-- /Left Text-->

            <!-- Register-->
            <b-col lg="4" class="d-flex align-items-center auth-bg px-2 p-lg-5">
                <!-- <b-col sm="8" md="6" lg="12" class="px-xl-2 mx-auto"> -->
                <div class="m-auto" style="padding: 30px 29px; border-radius: 30px; background-color: #0A070E;">
                    <b-card-title>
                        <!-- Adventure starts here 🚀 -->
                        Register
                    </b-card-title>
                    <!-- <b-card-text class="mb-2">
                        Make your app management easy and fun!
                    </b-card-text> -->
                    <!-- form -->
                    <validation-observer ref="registerForm" #default="{invalid}">
                        <b-form class="auth-register-form mt-2" @submit.prevent="register">
                            <!-- <b-form-group label="fullName" label-for="register-fullname"> -->
                            <b-form-group>
                                <validation-provider #default="{ errors }" name="fullName" rules="required|maxVal:50">
                                    <b-input-group
                                        class="input-group-merge log-in"
                                        :class="errors.length > 0 ? 'is-invalid':null"
                                    >
                                        <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            icon="UserIcon"
                                        />
                                        </b-input-group-append>
                                        <b-form-input id="register-fullname" v-model="fullName" name="register-fullname"
                                            :state="errors.length > 0 ? false:null" placeholder="johndoe" />
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>
                            <!-- username -->
                            <!-- <b-form-group label="Username" label-for="register-username"> -->
                            <b-form-group>
                                <validation-provider #default="{ errors }" name="Username" vid="username"
                                    rules="required|alpha-num|uniqueUsername">
                                    <b-input-group
                                        class="input-group-merge log-in"
                                        :class="errors.length > 0 ? 'is-invalid':null"
                                    >
                                        <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            icon="MailIcon"
                                        />
                                        </b-input-group-append>
                                        <b-form-input id="register-username" v-model="username" name="register-username"
                                            :state="errors.length > 0 ? false:null" placeholder="johndoe" />
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>

                            <!-- email -->
                            <!-- <b-form-group label="Email" label-for="register-email"> -->
                            <b-form-group>
                                <validation-provider #default="{ errors }" name="Email" vid="email"
                                    rules="required|email|uniqueMail">
                                    <b-input-group
                                        class="input-group-merge log-in"
                                        :class="errors.length > 0 ? 'is-invalid':null"
                                    >
                                        <b-input-group-append is-text>
                                        <feather-icon
                                            class="cursor-pointer"
                                            icon="LockIcon"
                                        />
                                        </b-input-group-append>
                                        <b-form-input id="register-email" v-model="userEmail" name="register-email"
                                            :state="errors.length > 0 ? false:null" placeholder="john@example.com" />
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>

                            <!-- password -->
                            <!-- <b-form-group label-for="register-password" label="Password"> -->
                            <b-form-group>
                                <validation-provider #default="{ errors }" name="Password" vid="password"
                                    rules="required|password">
                                    <b-input-group class="input-group-merge log-in"
                                        :class="errors.length > 0 ? 'is-invalid':null">
                                        <b-input-group-append is-text>
                                            <feather-icon icon="LockIcon" class="cursor-pointer"
                                                @click="togglePasswordVisibility" />
                                        </b-input-group-append>
                                        <b-form-input id="register-password" v-model="password"
                                            class="form-control-merge" :type="passwordFieldType"
                                            :state="errors.length > 0 ? false:null" name="register-password"
                                            placeholder="············" />
                                    </b-input-group>
                                    <small class="text-danger">{{ errors[0] }}</small>
                                </validation-provider>
                            </b-form-group>

                            <b-form-group>
                                <b-form-checkbox id="register-privacy-policy" v-model="status" name="checkbox-1">
                                    I agree with
                                    <b-link class="darkTextWhite"><span style="color: greenyellow;">privacy</span> </b-link>&nbsp;&nbsp;and&nbsp;&nbsp;<b-link><span style="color:greenyellow">policy</span></b-link>
                                </b-form-checkbox>
                            </b-form-group>

                            <b-button variant="primary" block type="submit" :disabled="invalid || sendForm">
                                Register
                            </b-button>
                        </b-form>
                    </validation-observer>
                    <!-- <p class="text-center mt-2">
                        <span>Already have an account?</span>
                        <b-link :to="{name:'auth-login'}">
                            <span>&nbsp;Sign in instead</span>
                        </b-link>
                    </p> -->
                    <!-- divider -->
                    <!-- <div class="divider my-2">
                        <div class="divider-text">
                            or
                        </div>
                    </div> -->
                    <!-- <button @click="AuthProvider('github')">auth Github</button> -->
                    <!-- <div class="auth-footer-btn d-flex justify-content-center">
                        <GoogleLoginVue/> -->

                        <!-- <b-button variant="facebook" href="javascript:void(0)">
                            <feather-icon icon="FacebookIcon" />
                        </b-button>
                        <b-button variant="twitter" href="javascript:void(0)">
                            <feather-icon icon="TwitterIcon" />
                        </b-button>
                        <b-button variant="google" href="javascript:void(0)">
                            <feather-icon icon="MailIcon" />
                        </b-button>
                        <b-button variant="github" href="javascript:void(0)">
                            <feather-icon icon="GithubIcon" />
                        </b-button> -->
                    <!-- </div> -->
                </div>
                <!-- </b-col> -->
            </b-col>
            <!-- /Register-->
        </b-row>
    </div>
</template>

<script>
    /* eslint-disable global-require */
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import VuexyLogo from '@core/layouts/components/Logo.vue'
    import {
        BRow,
        BCol,
        BLink,
        BButton,
        BForm,
        BFormCheckbox,
        BFormGroup,
        BFormInput,
        BInputGroup,
        BInputGroupAppend,
        BImg,
        BCardTitle,
        BCardText,
    } from 'bootstrap-vue'
    import {
        required,
        email,
        uniqueUsername,
        uniqueMail,
        password,
        maxVal
    } from '@validations'
    import {
        togglePasswordVisibility
    } from '@core/mixins/ui/forms'
    import store from '@/store/index'
    import useJwt from '@/auth/jwt/useJwt'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import {
        getHomeRouteForLoggedInUser
    } from '@/auth/utils'
    import GoogleLoginVue from './GoogleLogin.vue'
    import router from '@/router'
    export default {
        components: {
            VuexyLogo,
            BRow,
            BImg,
            BCol,
            BLink,
            BButton,
            BForm,
            BCardText,
            BCardTitle,
            BFormCheckbox,
            BFormGroup,
            BFormInput,
            BInputGroup,
            BInputGroupAppend,
            // validations
            ValidationProvider,
            ValidationObserver,
            GoogleLoginVue
        },
        mixins: [togglePasswordVisibility],
        data() {
            return {
                status: '',
                username: '',
                fullName: '',
                userEmail: '',
                password: '',
                sendForm: false,
                url: '',
                sideImg: require('@/assets/images/pages/register-v2.svg'),
                // validation
                required,
                email,
                uniqueUsername,
                uniqueMail,
                password,
                maxVal,

            }
        },
        computed: {
            passwordToggleIcon() {
                return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
            imgUrl() {
                if (store.state.appConfig.layout.skin === 'dark') {
                    // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                    this.sideImg = require('@/assets/images/pages/register-v2-dark.svg')
                    return this.sideImg
                }
                return this.sideImg
            },
        },
        methods: {
            register() {
                this.$refs.registerForm.validate().then(success => {
                    if (success) {
                        this.sendForm = true;
                        useJwt
                            .register({
                                username: this.username,
                                fullName: this.fullName,
                                email: this.userEmail,
                                password: this.password,
                            })
                            .then(response => {
                                if (response.data.status = 'success') {
                                    this.sendForm = true;
                                    this.$toast({
                                        component: ToastificationContent,
                                        props: {
                                            title: 'Registration completed Successfully, We have sent a verification link to your email',
                                            icon: 'EditIcon',
                                            variant: 'success',
                                            timeout: 5000
                                        },

                                    })
                                    this.$router.push('/login');
                                } else {
                                    this.sendForm = false;
                                    this.$toast({
                                        component: ToastificationContent,
                                        props: {
                                            title: 'Something went wrong',
                                            icon: 'EditIcon',
                                            variant: 'error',
                                            timeout: 5000
                                        },

                                    })
                                    this.$refs.registerForm.setErrors(response.data.error)
                                }
                               
                            })
                            .catch(error => {
                                this.$refs.registerForm.setErrors(error.data.error)
                            })
                    }
                })
            },
        },
     



    }



</script>

<style lang="scss">
    @import '~@resources/scss/vue/pages/page-auth.scss';

</style>
