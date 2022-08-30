<template>
    <b-sidebar id="add-new-user-sidebar" :visible="isAddNewUserSidebarActive" bg-variant="white"
        sidebar-class="sidebar-lg" shadow backdrop no-header right @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-user-sidebar-active', val)">
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New User
                </h5>

                <feather-icon class="ml-1 cursor-pointer" icon="XIcon" size="16" @click="hide" />

            </div>
            <!-- BODY -->
            <validation-observer #default="{ handleSubmit }" ref="refFormObserver">
                <!-- Form -->
                <b-form class="p-2" @submit.prevent="handleSubmit(onSubmit)" @reset.prevent="resetForm">

                    <!-- Full Name -->
                    <validation-provider #default="validationContext" name="fullName" rules="required">
                        <b-form-group label="Full Name" label-for="full-name">
                            <b-form-input id="full-name" v-model="userData.fullName" autofocus
                                :state="getValidationState(validationContext)" trim placeholder="John Doe" />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Username -->
                    <validation-provider #default="validationContext" name="username"
                        rules="required|alpha-num|uniqueUsername">
                        <b-form-group label="Username" label-for="username">
                            <b-form-input id="username" v-model="userData.username"
                                :state="getValidationState(validationContext)" trim />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Email -->
                    <validation-provider #default="validationContext" name="email" rules="required|email|uniqueMail">
                        <b-form-group label="Email" label-for="email">
                            <b-form-input id="email" v-model="userData.email"
                                :state="getValidationState(validationContext)" trim />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Company -->


                    <!-- Country -->
                    <validation-provider #default="validationContext" name="country" rules="required">
                        <b-form-group label="Country" label-for="country"
                            :state="getValidationState(validationContext)">
                            <v-select v-model="userData.country" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="countries" :clearable="false" input-id="country" />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- User Role -->
                    <validation-provider #default="validationContext" name="role" rules="required">
                        <b-form-group label="User Role" label-for="user-role"
                            :state="getValidationState(validationContext)">
                            <v-select v-model="userData.role" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="roleOptions" :reduce="val => val.value" :clearable="false"
                                input-id="user-role" />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Plan -->
                    <validation-provider #default="validationContext" name="currentPlan" rules="required">
                        <b-form-group label="Plan" label-for="plan" :state="getValidationState(validationContext)">
                            <v-select v-model="userData.currentPlan" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="planOptions" :reduce="val => val.value" :clearable="false" input-id="plan" />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider #default="validationContext" vid="password" name="Password"
                        rules="required|password">
                        <b-form-group label="Password" label-for="account-password">
                            <b-input-group class="input-group-merge">

                                <b-form-input id="account-password" v-model="userData.password"
                                    name="password" :type="passwordIcon" placeholder="Password" />
                                <b-input-group-append is-text>
                                    <feather-icon :icon="passwordToggleIcon" class="cursor-pointer"
                                        @click="togglePassword" />
                                </b-input-group-append>
                            </b-input-group>

                                <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>
                    <validation-provider #default="validationContext" name="Confirm Password"
                        rules="required|confirmed:password">
                        <b-form-group label-for="account-retype-new-password" label="Confirm New Password">
                            <b-input-group class="input-group-merge">
                                <b-form-input id="account-retype-new-password" v-model="userData.password_confirmation"
                                    :type="passwordFieldTypeRetype" name="retype-password" placeholder="New Password" />
                                <b-input-group-append is-text>
                                    <feather-icon :icon="passwordToggleIconRetype" class="cursor-pointer"
                                        @click="togglePasswordRetype" />
                                </b-input-group-append>
                            </b-input-group>

                                <b-form-invalid-feedback :state="getValidationState(validationContext)"> 
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>


                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button v-ripple.400="'rgba(255, 255, 255, 0.15)'" variant="primary" class="mr-2"
                            type="submit">
                            Add
                        </b-button>
                        <b-button v-ripple.400="'rgba(186, 191, 199, 0.15)'" type="button" variant="outline-secondary"
                            @click="hide">
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>

<script>
    import {
        BSidebar,
        BForm,
        BFormGroup,
        BFormInput,
        BFormInvalidFeedback,
        BButton,
        BInputGroupAppend,
        BInputGroup
    } from 'bootstrap-vue'
    import {
        ValidationProvider,
        ValidationObserver
    } from 'vee-validate'
    import {
        ref
    } from '@vue/composition-api'
    import {
        required,
        alphaNum,
        email,
        uniqueMail,
        uniqueUsername,
        confirmed,password
    } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import countries from '@/@fake-db/data/other/countries'
    import store from '@/store'

    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            vSelect,

            // Form Validation
            ValidationProvider,
            ValidationObserver,
            BInputGroupAppend,
            BInputGroup
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewUserSidebarActive',
            event: 'update:is-add-new-user-sidebar-active',
        },
        props: {
            isAddNewUserSidebarActive: {
                type: Boolean,
                required: true,
            },
            roleOptions: {
                type: Array,
                required: true,
            },
            planOptions: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                required,
                alphaNum,
                email,
                uniqueMail,
                uniqueUsername,
                countries,
                password,
                confirmed,
                passwordIcon: 'password',
                passwordFieldTypeRetype: 'password',
            }
        },
        computed: {
            passwordToggleIcon() {
                return this.passwordIcon === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
            passwordToggleIconRetype() {
                return this.passwordFieldTypeRetype === 'password' ? 'EyeIcon' : 'EyeOffIcon'
            },
        },
        methods: {

            togglePassword() {
                this.passwordIcon = this.passwordIcon === 'password' ? 'text' : 'password'
            },

            togglePasswordRetype() {
                this.passwordFieldTypeRetype = this.passwordFieldTypeRetype === 'password' ? 'text' : 'password'
            },

        },
        setup(props, {
            emit
        }) {
            const blankUserData = {
                fullName: '',
                username: '',
                email: '',
                role: null,
                currentPlan: null,
                company: '',
                password: '',
                password_confirmation: '',

            }

            const userData = ref(JSON.parse(JSON.stringify(blankUserData)))
            const resetuserData = () => {
                userData.value = JSON.parse(JSON.stringify(blankUserData))
            }

            const onSubmit = () => {
                store.dispatch('app-user/addUser', userData.value).then((res) => {
                    emit('refetch-data')
                    emit('update:is-add-new-user-sidebar-active', false)
                }).catch(error => {
                    console.log(error);
                })
            }

            const {
                refFormObserver,
                getValidationState,
                resetForm
            } = formValidation(resetuserData)

            return {
                userData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-select.scss';

    #add-new-user-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }

</style>
