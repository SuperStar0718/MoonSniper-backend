<template>
    <div>

        <!-- Media -->
        <b-media class="mb-2">
            <template #aside>
                <b-avatar ref="previewEl" :src="userData.avatar" :text="avatarText(userData.fullName)"
                    :variant="`light-${resolveUserRoleVariant(userData.role)}`" size="90px" rounded />
            </template>
            <h4 class="mb-1">
                {{ userData.fullName }}
            </h4>
            <div class="d-flex flex-wrap">
                <b-button variant="primary" @click="$refs.refInputEl.click()">
                    <input ref="refInputEl" type="file" class="d-none" @input="inputImageRenderer">
                    <span class="d-none d-sm-inline">Update</span>
                    <feather-icon icon="EditIcon" class="d-inline d-sm-none" />
                </b-button>
                <b-button variant="outline-secondary" @click="removeAvatar" class="ml-1">
                    <span class="d-none d-sm-inline">Remove</span>
                    <feather-icon icon="TrashIcon" class="d-inline d-sm-none" />
                </b-button>
            </div>
        </b-media>
        <!-- User Info: Input Fields -->
        <validation-observer #default="{ handleSubmit }" ref="refFormObserver">

            <b-form @submit.prevent="handleSubmit(updateProfile)" @reset.prevent="resetForm">
                <b-row>
                    <b-col cols="12" md="4">
                        <b-form-group label="Username" label-for="username">
                            <validation-provider #default="validationContext" name="Username"
                                :rules="`required|alpha-num|uniqueUsername2:${userData.id}`">
                                <b-form-input id="username" v-model="userData.username" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                    <b-col cols="12" md="4">
                        <b-form-group label="Full Name" label-for="full-name">
                            <validation-provider #default="validationContext" name="Fullname"
                                :rules="`required:${userData.id}`">
                                <b-form-input id="full-name" v-model="userData.fullName" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" md="4">
                        <b-form-group label="Email" label-for="email">
                            <validation-provider #default="validationContext" name="Email"
                                :rules="`required|email|uniqueMail2:${userData.id}`">
                                <b-form-input id="email" v-model="userData.email" type="email" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" md="4">
                        <b-form-group label="Status" label-for="user-status">
                            <validation-provider #default="validationContext" name="Status"
                                :rules="`required:${userData.id}`">
                                <v-select v-model="userData.status" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="statusOptions" :reduce="val => val.value" :clearable="false"
                                    input-id="user-status" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" md="4">

                        <b-form-group label="User Role" label-for="user-role">
                            <validation-provider #default="validationContext" name="Role"
                                :rules="`required:${userData.id}`">
                                <v-select v-model="userData.role" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                    :options="roleOptions" :reduce="val => val.value" :clearable="false"
                                    input-id="user-role" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>

                    <b-col cols="12" md="4">
                        <b-form-group label="Company" label-for="company">
                            <validation-provider #default="validationContext" name="Company"
                                rules="">
                                <b-form-input id="company" v-model="userData.company" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                      <b-col cols="12" md="4">
                        <b-form-group label="Password" label-for="password">
                            <validation-provider #default="validationContext" name="Password"
                                :rules="`password`">
                                <b-form-input id="password" v-model="userData.password" />
                                <b-form-invalid-feedback>
                                    {{ validationContext.errors[0] }}
                                </b-form-invalid-feedback>
                            </validation-provider>
                        </b-form-group>
                    </b-col>
                 

                </b-row>
            </b-form>
        </validation-observer>

        <!-- PERMISSION TABLE -->
        <b-card no-body class="border mt-1 d-none ">
            <b-card-header class="p-1">
                <b-card-title class="font-medium-2">
                    <feather-icon icon="LockIcon" size="18" />
                    <span class="align-middle ml-50">Permission</span>
                </b-card-title>
            </b-card-header>
            <b-table striped responsive class="mb-0" :items="permissionsData">
                <template #cell(module)="data">
                    {{ data.value }}
                </template>
                <template #cell()="data">
                    <b-form-checkbox :checked="data.value" />
                </template>
            </b-table>
        </b-card>

        <!-- Action Buttons -->
        <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="button"
            :block="$store.getters['app/currentBreakPoint'] === 'xs'" @click="updateProfile">
            Save Changes
        </b-button>
        <!-- <b-button variant="outline-secondary" type="reset" :block="$store.getters['app/currentBreakPoint'] === 'xs'">
            Reset
        </b-button> -->
    </div>
</template>

<script>
    import {
        useToast
    } from 'vue-toastification/composition'
    import countries from '@/@fake-db/data/other/countries'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
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
        BFormInvalidFeedback
    } from 'bootstrap-vue'
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
        uniqueMail2,
        confirmed,
        password
    } from '@validations'
    import {
        avatarText
    } from '@core/utils/filter'
    import vSelect from 'vue-select'
    import {
        useInputImageRenderer
    } from '@core/comp-functions/forms/form-utils'
    import {
        ref
    } from '@vue/composition-api'
    import useUsersList from '../users-list/useUsersList'
    import axios from '@axios'
    import formValidation from '@core/comp-functions/forms/form-validation'
    export default {
        components: {
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
            vSelect,
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
                uniqueMail2,
                  confirmed,
        password
            }
        },
        setup(props,{refs}) {
            const toast = useToast()
            const {
                resolveUserRoleVariant
            } = useUsersList()

            const roleOptions = [{
                    label: 'Admin',
                    value: 'Admin'
            },
               
                {
                    label: 'Editor',
                    value: 'Editor'
                },
                {
                    label: 'Manager',
                    value: 'Manager'
                },
                {
                    label: 'Client',
                    value: 'Client'
                },
            ]

            const statusOptions = [{
                    label: 'Pending',
                    value: 'pending'
                },
                {
                    label: 'Active',
                    value: 'active'
                },
                {
                    label: 'Inactive',
                    value: 'inactive'
                },
            ]

            const permissionsData = [{
                    module: 'Admin',
                    read: true,
                    write: false,
                    create: false,
                    delete: false,
                },
                {
                    module: 'Staff',
                    read: false,
                    write: true,
                    create: false,
                    delete: false,
                },
                {
                    module: 'Author',
                    read: true,
                    write: false,
                    create: true,
                    delete: false,
                },
                {
                    module: 'Contributor',
                    read: false,
                    write: false,
                    create: false,
                    delete: false,
                },
                {
                    module: 'User',
                    read: false,
                    write: false,
                    create: false,
                    delete: true,
                },
            ]
            const countryOptions = [{}]

            // ? Demo Purpose => Update image on click of update
            const refInputEl = ref(null)
            const previewEl = ref(null)

            const {
                inputImageRenderer
            } = useInputImageRenderer(refInputEl, base64 => {
                props.userData.avatar = base64
                axios
                    .post(`api/user/updateavatar/${props.userData.id}`, {
                        avatar: base64
                    })
                    .then(response => {
                        if (response.data.status = 'success') {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Avatar has been updated',
                                    variant: 'success',
                                      icon: 'CheckCircleIcon',
                                },
                            })
                        }
                    })
                // .catch(error => reject(error))                        
            })
            const removeAvatar = () => {
                axios
                    .post(`api/user/removeavatar/${props.userData.id}`)
                    .then(response => {
                        if (response.data.status = 'success') {
                            props.userData.avatar = ''
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Avatar has been updated',
                                    variant: 'success',
                                      icon: 'CheckCircleIcon',
                                },
                            })
                        }

                    })
            }
            const updateProfile = () => {
                refs.refFormObserver.validate().then(success => {
                    if (success) {
                        axios
                            .post(`api/user/updateaccount/${props.userData.id}`, props.userData)
                            .then(response => {
                                if (response.data.status == 'success') {
                                    toast({
                                        component: ToastificationContent,
                                        props: {
                                            title: 'Account details has been updated',
                                            variant: 'success',
                                              icon: 'CheckCircleIcon',
                                        },
                                    })
                                }

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
                resolveUserRoleVariant,
                avatarText,
                roleOptions,
                statusOptions,
                permissionsData,
                refInputEl,
                previewEl,
                inputImageRenderer,
                removeAvatar,
                updateProfile,
                countries,

                refFormObserver,
                getValidationState,
                resetForm,
            }
        },
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-select.scss';

</style>
<style>
    .invalid-feedback {
        display: block !important;
    }

</style>
