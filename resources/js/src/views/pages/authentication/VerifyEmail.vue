<template>
    <div class="auth-wrapper auth-v1 px-2">
        <div class="auth-inner py-2">
            <!-- Reset Password v1 -->
            <b-card class="mb-0">

                <!-- logo -->
                <b-link class="brand-logo">
                    <vuexy-logo />

                    <h2 class="brand-text text-primary ml-1">
                        Vuexy
                    </h2>
                </b-link>
                <template>
                    <div class="text-center d-flex justify-content-center">


                        <b-spinner class="mr-1" label="Small Spinner" />

                    </div>
                </template>

            </b-card>
            <!-- /Reset Password v1 -->
        </div>
    </div>

</template>

<script>
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import VuexyLogo from '@core/layouts/components/Logo.vue'
    import {
        BCard,
        BCardTitle,
        BCardText,
        BForm,
        BFormGroup,
        BInputGroup,
        BInputGroupAppend,
        BLink,
        BFormInput,
        BButton,
        BSpinner
    } from 'bootstrap-vue'
    import {
        required
    } from '@validations'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
    import axios from '@axios'
    import {
        getHomeRouteForLoggedInUser
    } from '@/auth/utils'
    export default {
        components: {
            VuexyLogo,
            BCard,
            BButton,
            BCardTitle,
            BCardText,
            BForm,
            BFormGroup,
            BInputGroup,
            BLink,
            BFormInput,
            BInputGroupAppend,
            ValidationProvider,
            ValidationObserver,
            BSpinner
        },
        data() {
            return {}
        },
        computed: {

        },
        methods: {

            validationForm() {
                axios.post('api/verify-mail', {
                    token: this.$route.params.token,
                    email: this.$route.query.email,
                }).then(res => {
                    if (res.data.status == 'success') {

                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Your email has been verified successfully',
                                icon: 'EditIcon',
                                variant: 'success',
                                 timeout: 5000
                            },
                        })
                        this.$router.replace(getHomeRouteForLoggedInUser()).then(() => {})
                    } else {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Invalid Request',
                                icon: 'EditIcon',
                                variant: 'error',
                                  timeout: 5000
                            },
                        })
                        this.$router.replace(getHomeRouteForLoggedInUser()).then(() => {})
                    }
                })

            },
        },
        created() {
            this.validationForm();
        }
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/pages/page-auth.scss';

</style>
