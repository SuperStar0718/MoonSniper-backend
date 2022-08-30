<template>
    <b-card>
        <!-- media -->
        <b-media no-body>
            <b-media-aside>
                <b-link>
                    <b-avatar ref="previewEl" :src="generalData.avatar" :text="avatarText(generalData.fullName)"
                        size="90px" rounded />
                </b-link>
                <!--/ avatar -->
            </b-media-aside>

            <b-media-body class="mt-75 ml-75">
                <!-- upload button -->
                <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary" size="sm" class="mb-75 mr-75"
                    @click="$refs.refInputEl.$el.click()">
                    Upload
                </b-button>
                <b-form-file ref="refInputEl" v-model="profileFile" accept=".jpg, .png, .gif" :hidden="true" plain
                    @input="inputImageRenderer" />
                <!--/ upload button -->

                <!-- reset -->
                <b-button @click="removeAvatar" v-ripple.400="'rgba(186, 191, 199, 0.15)'" variant="outline-secondary"
                    size="sm" class="mb-75 mr-75">
                    Remove
                </b-button>
                <!--/ reset -->
                <!-- <b-card-text>Allowed JPG, GIF or PNG. Max size of 800kB</b-card-text> -->
            </b-media-body>
        </b-media>
        <!--/ media -->
        <!-- form -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
            <b-form class="mt-2" @submit.prevent="handleSubmit(updateProfile)">
                <b-row>
                    <b-col sm="6">
                        <b-form-group label="Username" label-for="account-username">
                            <validation-provider #default="validationContext" name="Username"
                                :rules="`required|alpha-num|uniqueUsername2:${generalData.id}`">
                                <b-form-input v-model="generalData.username" placeholder="Username" name="username" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col sm="6">

                        <b-form-group label="Full Name" label-for="account-name">
                            <validation-provider #default="validationContext" name="FullName" :rules="`required`">
                                <b-form-input v-model="generalData.fullName" name="name" placeholder="Name" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col sm="6">
                        <b-form-group label="E-mail" label-for="account-e-mail">
                            <validation-provider #default="validationContext" name="Email" :rules="`required|email|uniqueMail2:${generalData.id}`">
                                <b-form-input v-model="generalData.email" name="email" placeholder="Email" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col sm="6">
                        <b-form-group label="Company" label-for="account-company">
                          <validation-provider #default="validationContext" name="Company" rules="">
                            <b-form-input v-model="generalData.company" name="company" placeholder="Company name" />
                             <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                                 </validation-provider>
                        </b-form-group>
                    </b-col>

                    <!-- alert -->
                    <b-col cols="12" class="mt-75" v-if="generalData.email_verified_at">
                        <b-alert show variant="warning" class="mb-50">
                            <h4 class="alert-heading">
                                Your email is not confirmed. Please check your inbox.
                            </h4>
                            <div class="alert-body">
                                <b-link class="alert-link">
                                    Resend confirmation
                                </b-link>
                            </div>
                        </b-alert>
                    </b-col>
                    <!--/ alert -->

                    <b-col cols="12">
                        <b-button type="submit" v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary"
                            class="mt-2 mr-1">
                            Save changes
                        </b-button>
                        <!-- <b-button v-ripple.400="'rgba(186, 191, 199, 0.15)'" variant="outline-secondary" type="reset"
                        class="mt-2" @click.prevent="resetForm">
                        Reset
                    </b-button> -->
                    </b-col>
                </b-row>
            </b-form>
        </validation-observer>
    </b-card>
</template>

<script>
    import {
        BAvatar,
        BFormFile,
        BButton,
        BForm,
        BFormGroup,
        BFormInput,
        BRow,
        BCol,
        BAlert,
        BCard,
        BCardText,
        BMedia,
        BMediaAside,
        BMediaBody,
        BLink,
        BImg,
        BFormInvalidFeedback
    } from 'bootstrap-vue'
    import Ripple from 'vue-ripple-directive'
    import {
        useInputImageRenderer
    } from '@core/comp-functions/forms/form-utils'
    import {
        ref
    } from '@vue/composition-api'
    import {
        avatarText
    } from '@core/utils/filter'
    import axios from '@axios'
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
        uniqueMail2
    } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    export default {
        components: {
            BButton,
            BForm,
            BImg,
            BFormFile,
            BFormGroup,
            BFormInput,
            BRow,
            BCol,
            BAlert,
            BCard,
            BCardText,
            BMedia,
            BMediaAside,
            BMediaBody,
            BLink,
            BAvatar,
            ToastificationContent,
            BFormInvalidFeedback,
            ValidationProvider,
            ValidationObserver
        },
        directives: {
            Ripple,
        },
        props: {
            generalData: {
                type: Object,
                default: () => {},
            },
        },
        data() {
            return {
                // optionsLocal: JSON.parse(JSON.stringify(this.generalData)),
                profileFile: null,
                required,
                alphaNum,
                email,
                uniqueMail,
                uniqueUsername2,
                uniqueMail2
            }
        },
        methods: {
            // resetForm() {
            //     // this.optionsLocal = JSON.parse(JSON.stringify(this.generalData))
            // },
        },
        setup(props,{refs}) {
            const toast = useToast()
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {
                inputImageRenderer
            } = useInputImageRenderer(refInputEl, base64 => {
                props.generalData.avatar = base64
                axios
                    .post(`api/user/updateavatar/${props.generalData.id}`, {
                        avatar: base64
                    })
                    .then(response => {
                        if (response.data.status == 'success') {
                            props.generalData.avatar = response.data.avatar;
                            localStorage.setItem('userData', JSON.stringify(props.generalData))
                            toast({
                                component: ToastificationContent,
                                props: {
                                    icon: true,
                                    title: 'Avatar has been updated',
                                    variant: 'success',
                                     icon: 'CheckCircleIcon',
                                },
                            })
                        }
                    })
                // .catch(error => reject(error))                        
            });
            const removeAvatar = () => {
                axios
                    .post(`api/user/removeavatar/${props.generalData.id}`)
                    .then(response => {
                        if (response.data.status = 'success') {
                            props.generalData.avatar = ''
                            props.generalData.avatar = null;
                            localStorage.setItem('userData', JSON.stringify(props.generalData))
                            toast({
                                icon: true,
                                component: ToastificationContent,
                                props: {
                                    title: 'Avatar has been updated',
                                    variant: 'success',
                                    icon:'CheckCircleIcon'
                                },
                            })
                        }

                    })
            }
            const updateProfile = () => {
               refs.refFormObserver.validate().then(success => {
                    if (success) {
                let params = {
                    username: props.generalData.username,
                    fullName: props.generalData.fullName,
                    email: props.generalData.email,
                    company: props.generalData.company
                }
                axios
                    .post(`api/user/profile`, params)
                    .then(response => {
                        if (response.data.status = 'success') {
                            localStorage.setItem('userData', JSON.stringify(response.data.user))
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Account details has been updated',
                                    variant: 'success',
                                    icon:'CheckCircleIcon'
                                },
                            })
                        }

                    }).catch(error => {
                        this.$refs.refFormObserver.setErrors(error.response.data.error)
                    })
            }
               })}
            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(props.generalData)
            return {
                refInputEl,
                previewEl,
                inputImageRenderer,
                avatarText,
                removeAvatar,
                updateProfile,
                refFormObserver,
                getValidationState,
            }
        },
    }

</script>
<style>
    .invalid-feedback {
        display: block !important;
    }

</style>
