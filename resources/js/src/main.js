import Vue from 'vue'
import { ToastPlugin, ModalPlugin,BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import VueCompositionAPI from '@vue/composition-api'
import VueInputRestrictionDirectives from 'vue-input-restriction-directives';

import i18n from '@/libs/i18n'
import router from './router'
import store from './store'
import App from './App.vue'

// Global Components
import './global-components'

// 3rd party plugins
import '@axios'
import '@/libs/acl'
import '@/libs/portal-vue'
import '@/libs/clipboard'
import '@/libs/toastification'
import '@/libs/sweet-alerts'
import '@/libs/vue-select'
import '@/libs/tour'
import VueSocialauth from 'vue-social-auth'
import vueNumeralFilterInstaller from 'vue-numeral-filter';
import Sparkline from 'vue-sparklines'
import vueAwesomeCountdown from 'vue-awesome-countdown'
import VueGlobalEmitter from 'vue-global-emitter'
// Axios Mock Adapter
// import '@/@fake-db/db'

// BSV Plugin Registration
Vue.use(vueNumeralFilterInstaller, { locale: 'en-gb' });
Vue.use(ToastPlugin)
Vue.use(ModalPlugin)
Vue.use(Sparkline)
Vue.use(BootstrapVue)
Vue.use(BootstrapVueIcons)

// Composition API
Vue.use(VueCompositionAPI)
Vue.use(VueGlobalEmitter)
Vue.use(VueInputRestrictionDirectives);
Vue.use(vueAwesomeCountdown, 'vac')

Vue.use(VueSocialauth,{

  providers: {
    google: {
      clientId: '',
      redirectUri: '/auth/google/callback' // Your client app URL
    }
  }
})

// Feather font icon - For form-wizard
// * Shall remove it if not using font-icons of feather-icons - For form-wizard
require('@core/assets/fonts/feather/iconfont.css') // For form-wizard

// import core styles
require('@resources/scss/core.scss')

// import assets styles
require('@resources/assets/scss/style.scss')

Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  render: h => h(App),
}).$mount('#app')
