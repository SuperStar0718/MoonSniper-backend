<template>
    <component :is="profileData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert variant="danger" :show="profileData === undefined">
            <h4 class="alert-heading">
                Error fetching user data
            </h4>
            <div class="alert-body">
                No user found with this user id. Check
                <b-link class="alert-link" :to="{ name: 'apps-users-list'}">
                    User List
                </b-link>
                for other users.
            </div>
        </b-alert>

        <b-tabs v-if="profileData" pills>

            <!-- Tab: Account -->
            <b-tab active>
                <template #title>
                    <feather-icon icon="UserIcon" size="16" class="mr-0 mr-sm-50" />
                    <span class="d-none d-sm-inline">Account</span>
                </template>
                <b-media class="mb-2">
                    <template #aside>
                        <b-avatar ref="previewEl" :src="profileData.avatar" :text="avatarText(profileData.fullName)"
                            :variant="`light-${resolveUserRoleVariant(profileData.role)}`" size="90px" rounded />
                    </template>
                    <h4 class="mb-1">
                        {{ profileData.fullName }}
                    </h4>

                </b-media>
                <!-- User Info: Input Fields -->

                <b-row>
                    <b-col cols="12" md="3">
                        <strong class="" label="Username" label-for="username">Username</strong>
                            <p>{{profileData.username}}</p>
                        
                    </b-col>
                    <b-col cols="12" md="3">
                        <strong class="" label="Full Name" label-for="full-name">Full Name</strong>
                            <p>{{profileData.fullName}}</p>
                        
                    </b-col>

                    <b-col cols="12" md="3">
                        <strong class="" label="Email" label-for="email">Email</strong>
                          <p>{{profileData.email}}</p>
                        
                    </b-col>

                    <b-col cols="12" md="3">

                        <strong class="" label="User Role" label-for="user-role">User Role</strong>
                          <p>{{ profileData.role }}</p>
                        
                    </b-col>
                    <b-col cols="12" md="3" v-if="profileData.role == 'Client'">
                        <strong class="" label="User Plan" label-for="user-plan">User Plan</strong>
                     <p class="capitalize">{{profileData.currentPlan}}</p>
                        
                    </b-col>

                    <b-col cols="12" md="3">
                        <strong class="" label="Company" label-for="company" v-if="profileData.company">Company"</strong>
                          <p>{{ profileData.company }}</p>
                        
                    </b-col>
                </b-row>
            </b-tab>
            <!-- Tab: Information -->
            <b-tab>
                <template #title>
                    <feather-icon icon="InfoIcon" size="16" class="mr-0 mr-sm-50" />
                    <span class="d-none d-sm-inline">Information</span>
                </template>
               <!-- Header: Personal Info -->

      <!-- Form: Personal Info Form -->
              <b-row>

                  <!-- Field: Birth Date -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Birth Date" label-for="birth-date">Birth-date
                      </strong>
                       <p v-if="profileData.dob != null && profileData.dob !=''">{{profileData.dob}}</p>
                       
                       <p v-else>-</p>

                      
                  </b-col>

                  <!-- Field: Mobile -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Contact" label-for="contact">Contact
                      </strong>
                        <p v-if="profileData.contact != null && profileData.contact !=''">{{profileData.contact}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Website -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Website" label-for="website">Website</strong>
                        <p v-if="profileData.website != null && profileData.website !=''">{{profileData.website}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Language -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Language" label-for="language">Language</strong>
                        <p v-if="profileData.language != null && profileData.language !=''">{{profileData.language}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Gender -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Gender" label-for="gender" label-class="mb-1">Gender</strong>
                        <p v-if="profileData.gender != null && profileData.gender !=''">{{profileData.gender}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Contact Options -->
                  <!-- <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Contact Options" label-for="contact-options" label-class="mb-1">Contact options</strong>
                       
                              <p v-if="profileData.contactOptions != null && profileData.contactOptions !=''">{{profileData.contactOptions}}</p>
                              <p v-else>-</p>
                      
                  </b-col> -->
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
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Address Line 1" label-for="address-line-1">Address Line 1</strong>
                          <p v-if="profileData.addressLine1 != null && profileData.addressLine1 !=''">{{profileData.addressLine1}}</p>
                          <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Address Line 2 -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Address Line 2" label-for="address-line-2">Address Line 2</strong>
                        <p v-if="profileData.addressLine2 != null && profileData.addressLine2 !=''">{{profileData.addressLine2}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Postcode -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Postcode" label-for="postcode">PostCode</strong>
                        <p v-if="profileData.postcode != null && profileData.postcode !=''">{{profileData.postcode}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: City -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="City" label-for="city">City</strong>
                        <p v-if="profileData.city != null && profileData.city !=''">{{profileData.city}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: State -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="State" label-for="state">State"</strong>
                         <p v-if="profileData.state != null && profileData.state !=''">{{profileData.state}}</p>
                        <p v-else>-</p>
                      
                  </b-col>

                  <!-- Field: Country -->
                  <b-col cols="12" md="6" lg="3">
                      <strong class="" label="Country" label-for="country">Country</strong>
                        <p v-if="profileData.country != null && profileData.country !=''">{{profileData.country}}</p>
                        <p v-else>-</p>
                      
                  </b-col>
              </b-row>
           
            </b-tab>
        </b-tabs>
    </component>
</template>

<script>
    import {
        BTab,
        BTabs,
        BCard,
        BAlert,
        BLink,
        BButton,
        BMedia,
        BAvatar,
        BRow,
        BCol,
        BFormGroup,
        BFormInput,
        BForm,
        BTable,
        BCardHeader,
        BCardTitle,
        BFormCheckbox,
        BFormInvalidFeedback
    } from 'bootstrap-vue'

    import axios from '@axios';
    import {
        avatarText
    } from '@core/utils/filter'
    /* eslint-disable global-require */
    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,
            BButton,
            BMedia,
            BAvatar,
            BRow,
            BCol,
            BFormGroup,
            BFormInput,
            BForm,
            BTable,
            BCardHeader,
            BCardTitle,
            BFormCheckbox,
            BFormInvalidFeedback
        },

        data() {
            return {
                profileData: {},
            }
        },
        created() {
            axios.get('/api/user').then(res => {
                this.profileData = res.data
            })
        },
        setup(props, {
            refs
        }) {
            const resolveUserRoleVariant = role => {
                if (role === 'Client') return 'primary'
                if (role === 'Manager') return 'success'
                if (role === 'Editor') return 'info'
                if (role === 'Admin') return 'danger'
                return 'primary'
            }
            const statusOptions = role => {
                if (role === 'pending') return 'Pending'
                if (role === 'active') return 'Active'
                if (role === 'inactive') return 'Inactive'
            }
           
            
            return {
                avatarText,
                resolveUserRoleVariant,
                statusOptions,
            }
        }
    }
    /* eslint-disable global-require */

</script>

<style lang="scss">
    @import '~@resources/scss/vue/pages/page-profile.scss';

</style>

<style>
    .card-body {
        padding: 1.5rem !important;
    }

</style>
