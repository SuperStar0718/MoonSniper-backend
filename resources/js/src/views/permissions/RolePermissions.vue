<template>
    <div class="greyBackground" style="padding: 20px;">

        <b-row class="mb-2" v-if="loaded">
            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <h3 for="">Permissions</h3>
                </b-form-group>
            </b-col>
            <!-- <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">Client</label>
                    <v-select v-model="selected.Client" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'" multiple
                        label="title" :options="clientPermissions" />
                </b-form-group>
            </b-col> -->
            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">Editor</label>
                    <v-select v-model="selected.Editor" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'" multiple
                        label="title" :options="permissions" />
                </b-form-group>
            </b-col>

            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">Manager</label>
                    <v-select v-model="selected.Manager" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'" multiple
                        label="title" :options="permissions" />
                </b-form-group>
            </b-col>
            <b-col cols="12">
                <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="button" :disabled="sendForm"
                    @click="updatePermissions" :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                    Save Changes
                    <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                </b-button>
            </b-col>

        </b-row>
        <b-row v-if="loaded">
            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <h3 for="">Client Permissions</h3>
                </b-form-group>
            </b-col>
            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">For Free Users</label>
                    <v-select v-model="selectedClient.free" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'" multiple
                        label="title" :options="clientPermissions" />
                </b-form-group>
            </b-col>
            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">For Subscribers</label>
                    <v-select v-model="selectedClient.subscriber" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        multiple label="title" :options="clientPermissions" />
                </b-form-group>
            </b-col>

            <b-col cols="12" md="12" xl="12">
                <b-form-group>
                    <label for="">For Alpha Members</label>
                    <v-select v-model="selectedClient['alpha-member']" :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                        multiple label="title" :options="clientPermissions" />
                </b-form-group>
            </b-col>
            <b-col cols="12">
                <b-button variant="primary" class="mb-1 mb-sm-0 mr-0 mr-sm-1" type="button" :disabled="sendForm"
                    @click="updateClientPermissions" :block="$store.getters['app/currentBreakPoint'] === 'xs'">
                    Save Changes
                    <b-spinner v-if="sendForm" small class="ml-[0.5]" label="Small Spinner" />
                </b-button>
            </b-col>

        </b-row>
    </div>

</template>

<script>
    import {
        BRow,
        BCol,
        BFormGroup,
        BButton
    } from 'bootstrap-vue'
    import vSelect from 'vue-select'
    import axios from '@axios'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BRow,
            BCol,
            BFormGroup,
            vSelect,
            BButton,
            ToastificationContent
        },
        data() {
            return {
                selected: {

                },
                selectedClient: {
                },
                sendForm: false,
                permissions: [

                ],
                loaded: false,
            }
        },
        computed: {
            clientPermissions() {
                return this.permissions.filter(item => {
                    return item != 'Users' && item != 'Managemenu' && item != 'All'&& item != 'Unlocking';
                });

            }
        },
        methods: {
            loadPermissionsAndRoles() {
                axios.post('api/roles-and-permissions', {}).then(res => {
                    console.log(res.data);
                    this.selected = res.data.rolepermissions;
                    this.selectedClient = res.data.clientrolepermissions;
                    // this.selectedClient.subscriber = res.data.clientrolepermissions.subscriber;
                    // this.selectedClient['alpha-member'] = res.data.clientrolepermissions['alpha-member'];
                  
                    this.permissions = res.data.permissions;
                    this.loaded = true;
                })
            },
            updatePermissions() {
                axios.post('api/update-role-permissions', {
                    permissions: JSON.stringify(this.selected)
                }).then(res => {
                    if (res.data.status) {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Permissions Are Updated',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                    }
                })
            },
            updateClientPermissions() {
                axios.post('api/update-role-permissions-for-clients', {
                    permissions: JSON.stringify(this.selectedClient)
                }).then(res => {
                    if (res.data.status) {
                        this.$toast({
                            component: ToastificationContent,
                            props: {
                                title: 'Permissions Are Updated',
                                icon: 'CheckCircleIcon',
                                variant: 'success',
                            },
                        })
                    }
                })
            }
        },
        mounted() {
            this.loadPermissionsAndRoles();
        }
    }

</script>

<style lang="scss">
    @import '~@resources/scss/vue/libs/vue-autosuggest.scss';
 

</style>
