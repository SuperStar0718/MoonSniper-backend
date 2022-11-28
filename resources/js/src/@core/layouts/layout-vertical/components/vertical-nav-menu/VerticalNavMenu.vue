<template>
  <div class="position-fixed nav-background" style="height:100%;z-index:3;">

  <div
    class="main-menu menu-fixed menu-accordion menu-shadow"
    :class="[
      { 'expanded': !isVerticalMenuCollapsed || (isVerticalMenuCollapsed && isMouseHovered) },
      skin === 'light'|| skin === 'bordered' ? 'menu-light' : 'menu-dark'
    ]"
    @mouseenter="updateMouseHovered(true)"
    @mouseleave="updateMouseHovered(false)"
    style="min-height:auto;max-height:962.5px"
    >
    <!-- main menu header-->
    <div class="navbar-header expanded">
      <slot
        name="header"
        :toggleVerticalMenuActive="toggleVerticalMenuActive"
        :toggleCollapsed="toggleCollapsed"
        :collapseTogglerIcon="collapseTogglerIcon"
      >
        <ul class="nav navbar-nav flex-row" style="padding-right:0 !important">

          <!-- Logo & Text -->
          <!-- <li class="nav-item mr-auto">
            <b-link
              class="navbar-brand"
              to="/"
            >
              <span class="brand-logo">
                <b-img
                  :src="appLogoImage"
                  alt="logo"
                />
              </span>
              <h2 class="brand-text">
                {{ appName }}
              </h2>
            </b-link>
          </li> -->

          <!-- Toggler Button -->
          <li class="nav-item mr-auto lg-d-none-max">
            <b-link class="nav-link modern-nav-toggle  ">
              <feather-icon
              icon="XIcon"
              size="25"
              class="d-block d-xl-none toggle-icon"
              @click="toggleVerticalMenuActive"
              />
              <feather-icon
              :icon="collapseTogglerIconFeather"
              size="25"
              class="d-noned-xl-block collapse-toggle-icon toggle-icon lg-d-none-max"
                @click="toggleCollapsed"
              />
            </b-link>
          </li>

          <!--Dark Toggle button-->
          <!-- <li class="nav-item nav-toggle m-auto rounded-pill" style="margin-right:0 !important; padding-right: 1rem !important; padding-left: 1rem; border: 3px black solid;">
            <dark-Toggler class="d- d-lg-block" />
          </li> -->
        </ul>
      </slot>
    </div>
    <!-- / main menu header-->

    <!-- Shadow -->
    <div
      :class="{'d-block': shallShadowBottom}"
      class=""
    />

    <div class="row mt-1 mb-4 user_info">
      <div class="d-none user-nav d-inline float-left w-50 text-center m-auto">
        <p style="margin-bottom:5px;font-family: Poppins;font-style: normal;font-weight: 700;font-size: 24px;letter-spacing: 3pt;">
          {{ userData.fullName || userData.username }}
        </p>
        <p style="font-family: Poppins;margin: 7px;font-style: normal;font-weight: 500;font-size: 17px;">{{ userData.role }}</p>
        <button onclick="" style="font-family: Poppins; font-size:17px; border-radius: 10px;padding:4px 20px">Upgrade</button>
      </div>
      <div class="float-right w-50 text-right pr-4">
        <b-avatar size="100" :src="userData.avatar" :to="{ name: 'pages-profile'}" variant="light-primary" badge class="badge-minimal" badge-variant="success">
          <feather-icon v-if="!userData.fullName" icon="UserIcon" size="22" />
        </b-avatar>
      </div>
    </div>

    <!-- main menu content-->
    <vue-perfect-scrollbar
      :settings="perfectScrollbarSettings"
      class="main-menu-content scroll-area"
      tagname="ul"
      @ps-scroll-y="evt => { shallShadowBottom = evt.srcElement.scrollTop > 0 }"
    >
      <vertical-nav-menu-items
        :items="navMenuItems"
        class="navigation navigation-main"
        style="background-color:transparent;"
      />
    </vue-perfect-scrollbar>
    <!-- /main menu content-->
    <div class="text-center mt-3 user_logout">
      <i class="d-inline-flex bi bi-question-circle" style="font-size:32px;cursor:pointer"></i>
      <div class="d-inline-flex pl-1" style="padding-top: 5px;cursor:pointer">
        <feather-icon size="32" icon="LogOutIcon" class="mr-50" @click="logout"/>
      </div>
    </div>
  </div>
  <div class="fulfill-navbar" style="border:none;margin-top: 962px;background-color: rgba(255, 255, 255, 0.07);height: calc(100vh - 962.5px);margin-right: 58px;"></div>
</div>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import { BLink, BImg, BAvatar } from 'bootstrap-vue'
import { provide, computed, ref } from '@vue/composition-api'
import useAppConfig from '@core/app-config/useAppConfig'
import { $themeConfig } from '@themeConfig'
import VerticalNavMenuItems from './components/vertical-nav-menu-items/VerticalNavMenuItems.vue'
import useVerticalNavMenu from './useVerticalNavMenu'
import DarkToggler from '@core/layouts/components/app-navbar/components/DarkToggler.vue'
import { avatarText } from '@core/utils/filter'
import useJwt from '@/auth/jwt/useJwt'
import "bootstrap-icons/font/bootstrap-icons.css";
import { initialAbility } from '@/libs/acl/config'

export default {
  components: {
    VuePerfectScrollbar,
    VerticalNavMenuItems,
    DarkToggler,
    BLink,
    BAvatar,
    BImg,
  },
  props: {
    isVerticalMenuActive: {
      type: Boolean,
      required: true,
    },
    toggleVerticalMenuActive: {
      type: Function,
      required: true,
    },
    navMenuItems: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      userData: JSON.parse(localStorage.getItem('userData')),
      avatarText,
    }
  },
  setup(props) {
    const {
      isMouseHovered,
      isVerticalMenuCollapsed,
      collapseTogglerIcon,
      toggleCollapsed,
      updateMouseHovered,
    } = useVerticalNavMenu(props)

    const { skin } = useAppConfig()

    // Shadow bottom is UI specific and can be removed by user => It's not in `useVerticalNavMenu`
    const shallShadowBottom = ref(false)

    provide('isMouseHovered', isMouseHovered)

    const perfectScrollbarSettings = {
      maxScrollbarLength: 60,
      wheelPropagation: false,
    }

    const collapseTogglerIconFeather = computed(() => (collapseTogglerIcon.value === 'unpinned' ? 'MenuIcon' : 'XIcon'))

    // App Name
    const { appName, appLogoImage } = $themeConfig.app

    return {
      perfectScrollbarSettings,
      isVerticalMenuCollapsed,
      collapseTogglerIcon,
      toggleCollapsed,
      isMouseHovered,
      updateMouseHovered,
      collapseTogglerIconFeather,

      // Shadow Bottom
      shallShadowBottom,

      // Skin
      skin,

      // App Name
      appName,
      appLogoImage,
    }
  },

  methods: {
    logout() {
      // Remove userData from localStorage
      // ? You just removed token from localStorage. If you like, you can also make API call to backend to blacklist used token
      localStorage.removeItem(useJwt.jwtConfig.storageTokenKeyName)
      localStorage.removeItem(useJwt.jwtConfig.storageRefreshTokenKeyName)

      // Remove userData from localStorage
      localStorage.removeItem('userData')

      // Reset ability
      this.$ability.update(initialAbility)

      // Redirect to login page
      this.$router.push({
        name: 'auth-login'
      })
    },
  }
}
</script>

<style lang="scss">
@import "~@resources/scss/base/core/menu/menu-types/vertical-menu.scss";

.navbar-nav a.nav-link:has(svg){
  padding:1px;
  color:black;
}
@media (max-width: 1199px) {
.lg-d-none-max{
   display: none;
  }
}
</style>
