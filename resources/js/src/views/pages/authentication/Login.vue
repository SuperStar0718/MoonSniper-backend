<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">

      <!-- Brand logo-->
      <b-link class="brand-logo">
        <!-- <vuexy-logo /> -->
        <img src="/images/moon/icon/fullcolor.png" alt="" style="width:80px">
        <h2 class="brand-text text-primary ml-1 my-auto">
          <img src="/images/moon/text/fullcolor.png" alt="" class="Logo-image" style="height:30px">
      </h2>
      </b-link>
      <!-- /Brand logo-->

      <!-- Left Text-->
      <b-col
        lg="8"
        class="d-none d-lg-flex align-items-center p-5"
      >
        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
          <b-img
            fluid
            :src="imgUrl"
            alt="Login V2"
          />
        </div>
      </b-col>
      <!-- /Left Text-->

      <!-- Login-->
      <b-col
        lg="4"
        class="d-flex align-items-center auth-bg px-2 p-lg-5"
      >
        <!-- <b-col
          sm="8"
          md="6"
          lg="12"
          class="px-xl-2 mx-auto"
        > -->
        <div class="m-auto" style="padding: 30px 29px; border-radius: 30px; background-color: #0A070E;">
          <b-card-title
            class="mb-1"
            title-tag="h2"
            style="font-family: 'Poppins';font-style: normal;font-weight: 400;font-size: 17.2994px;"
          >
            <!-- Welcome to Vuexy! 👋 -->
            Sign In
          </b-card-title>
          <!-- <b-card-text class="mb-2">
            Please sign-in to your account and start the adventure
          </b-card-text> -->

      

          <!-- form -->
          <validation-observer
            ref="loginForm"
            #default="{invalid}"
          >
            <b-form
              class="auth-login-form mt-2"
              @submit.prevent="login"
            >
              <!-- email -->
              <b-form-group
                label=""
                label-for="login-email"
              >
                <validation-provider
                  #default="{ errors }"
                  name="Email"
                  vid="email"
                  rules="required|email"
                >
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
                    <b-form-input
                      id="login-email"
                      v-model="userEmail"
                      :state="errors.length > 0 ? false:null"
                      name="login-email"
                      placeholder="Email"
                    />
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- forgot password -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password"></label>
                </div>
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  vid="password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge log-in"
                    :class="errors.length > 0 ? 'is-invalid':null"
                  >
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        icon="LockIcon"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                    <b-form-input
                      id="login-password"
                      v-model="password"
                      :state="errors.length > 0 ? false:null"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      name="login-password"
                      placeholder="Password"
                    />
                    <!-- <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="passwordToggleIcon"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append> -->
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- checkbox -->
              <!-- <b-form-group>
                <b-form-checkbox
                  id="remember-me"
                  v-model="status"
                  name="checkbox-1"
                >
                  Remember Me
                </b-form-checkbox>
              </b-form-group> -->

              <b-card-text class="text-center mt-2" style="font-family: 'Poppins';font-style: normal;font-weight: 300;font-size: 10px;line-height: 1.2em;">
                <span>Are you new to MoonSniper?</span>
                <br>
                <b-link :to="{name:'auth-register'}">
                  <span style="color: #2BFF4D ">Create an account</span>
                </b-link>
              </b-card-text>

              <!-- submit buttons -->
              <div class="d-flex">
                <b-button
                  type="submit"
                  variant="primary"
                  block
                  :disabled="invalid"
                  style=" padding:0px;width:145px; height: 31px; font-family: 'Poppins';font-style: normal;font-weight: 400;font-size: 12px;"
                >
                  Login
                </b-button>
                <b-link :to="{name:'auth-forgot-password'}" class="float-right m-auto">
                  <span class="forget" style="font-family: 'Poppins';font-style: normal;font-weight: 400;font-size: 12px;">Forgot?</span>
                </b-link>
              </div>
            </b-form>
          </validation-observer>

          

          <!-- divider -->
          <!-- <div class="divider my-2">
            <div class="divider-text">
              or
            </div>
          </div> -->

          <!-- social buttons -->
          <!-- <div class="auth-footer-btn d-flex justify-content-center">
            <GoogleLoginVue/> -->
            <!-- <b-button
              variant="facebook"
              href="javascript:void(0)"
            >
              <feather-icon icon="FacebookIcon" />
            </b-button>
            <b-button
              variant="twitter"
              href="javascript:void(0)"
            >
              <feather-icon icon="TwitterIcon" />
            </b-button>
            <b-button
              variant="google"
              href="javascript:void(0)"
            >
              <feather-icon icon="MailIcon" />
            </b-button>
            <b-button
              variant="github"
              href="javascript:void(0)"
            >
              <feather-icon icon="GithubIcon" />
            </b-button> -->
          <!-- </div> -->
        </div>
        <!-- </b-col> -->
      </b-col>
    <!-- /Login-->
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import VuexyLogo from '@core/layouts/components/Logo.vue'
import {
  BRow,
  BCol,
  BLink,
  BFormGroup,
  BFormInput,
  BInputGroupAppend,
  BInputGroup,
  BFormCheckbox,
  BCardText,
  BCardTitle,
  BImg,
  BForm,
  BButton,
  BAlert,
  VBTooltip,
} from 'bootstrap-vue'
  import GoogleLoginVue from './GoogleLogin.vue'
import useJwt from '@/auth/jwt/useJwt'
import { required, email } from '@validations'
import { togglePasswordVisibility } from '@core/mixins/ui/forms'
import store from '@/store/index'
import { getHomeRouteForLoggedInUser } from '@/auth/utils'

import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default {
  directives: {
    'b-tooltip': VBTooltip,
  },
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    BAlert,
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
    GoogleLoginVue
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      status: '',
      password: '',
      userEmail: '',
      sideImg: require('@/assets/images/pages/login-v2.svg'),

      // validation rules
      required,
      email,
    }
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === 'password' ? 'EyeIcon' : 'EyeOffIcon'
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === 'dark') {
        // eslint-disable-next-line vue/no-side-effects-in-computed-properties
        this.sideImg = require('@/assets/images/pages/login-v2-dark.svg')
        return this.sideImg
      }
      return this.sideImg
    },
  },
  methods: {
    login() {
      this.$refs.loginForm.validate().then(success => {
        if (success) {
          useJwt
            .login({
              email: this.userEmail,
              password: this.password,
            })
            .then(response => {
              if(response.data.error)
              {
                 this.$refs.loginForm.setErrors({"password":["Invalid Credentials."]})
                 return;
              }
              const { userData } = response.data
              useJwt.setToken(response.data.accessToken)
              // useJwt.setRefreshToken(response.data.refreshToken)
              localStorage.setItem('userData', JSON.stringify(userData))
              this.$ability.update(userData.ability)
              // ? This is just for demo purpose as well.
              // ? Because we are showing eCommerce app's cart items count in navbar
              // this.$store.commit('app-ecommerce/UPDATE_CART_ITEMS_COUNT', userData.extras.eCommerceCartItemsCount)
              // ? This is just for demo purpose. Don't think CASL is role based in this case, we used role in if condition just for ease
              this.$router.replace(getHomeRouteForLoggedInUser(userData.role)).then(() => {
                this.$toast({
                  component: ToastificationContent,
                  position: 'top-right',
                  props: {
                    title: `Welcome ${userData.fullName || userData.username}`,
                    icon: 'CoffeeIcon',
                    variant: 'success',
                    text: `You have successfully logged in as ${userData.role}. Now you can start to explore!`,
                  },
                })
              })
            })
            .catch(error => {
              // console.log(error);
              // this.$refs.loginForm.setErrors(error.response.data.error)
            })
        }
      })
    },
  },
}
</script>
<style scoped>
@media only screen and (max-width: 600px) {
  .Logo-image {
    height:17px !important;
  }
}
</style>
<style lang="scss">
  @import '~@resources/scss/vue/pages/page-auth.scss';
</style>
