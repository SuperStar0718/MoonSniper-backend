<template>
  <layout-vertical :nav-menu-items="navMenuItems">
   <div class="header-div">
    <Topbar/>
    <NotificationDropdown />  
    <router-view />
   </div>

    <app-customizer
      v-if="showCustomizer"
      slot="customizer"
    />

  </layout-vertical>
</template>

<script>
import LayoutVertical from '@core/layouts/layout-vertical/LayoutVertical.vue'
import AppCustomizer from '@core/layouts/components/app-customizer/AppCustomizer.vue'
import { $themeConfig } from '@themeConfig'
import navMenuItems from '@/navigation/vertical'
import axios from '@axios';
import store from '@/store/index'
import NotificationDropdown from '../../views/Notify/NotificationDropdown.vue';
import Topbar from '../../views/Notify/Topbar.vue';
export default {
  
  components: {
    AppCustomizer,
    LayoutVertical,
    NotificationDropdown,
    Topbar
  },
  data() {
    return {
      showCustomizer: $themeConfig.layout.customizer,
      navMenuItems,
      notifications:[]
    }
  },
  methods:{
    loadPermissions()
    {
      axios.post('/api/abilities').then(res=>{
      let userData =  localStorage.getItem('userData')
       let jsonUserData  =  JSON.parse(userData);
       jsonUserData.ability = res.data
       localStorage.setItem('userData', JSON.stringify(jsonUserData))
        this.$ability.update(res.data)
      })
    },
  
  },
    mounted()
    {
      if(window.innerWidth <1199)
      {
        store.commit('verticalMenu/UPDATE_VERTICAL_MENU_COLLAPSED', true)
      }
        this.loadPermissions();
    }
}
</script>
<style>
@font-face {
  font-family: Poppins-Light;
  src: url('../../../../assets/fonts/Poppins-Light.ttf');
}
</style>
