<template>
  <b-tabs
    vertical
    content-class="col-12 col-md-9 mt-1 mt-md-0"
    pills
    nav-wrapper-class="col-md-3 col-12"
    nav-class="nav-left"
  >

    <!-- general tab -->
    <b-tab active>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="UserIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">General</span>
      </template>

      <account-setting-general
        v-if="options.general"
        :general-data="options.general"
      />
    </b-tab>
    <!--/ general tab -->

    <!-- change password tab -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="LockIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Change Password</span>
      </template>

      <account-setting-password :passwords="{}" />
    </b-tab>
    <!--/ change password tab -->

    <!-- info -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="InfoIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Information</span>
      </template>

      <account-setting-information
        v-if="options.general"
        :information-data="options.general"
      />
    </b-tab>

    <!-- social links -->
    <b-tab v-if="false">

      <!-- title -->
      <template #title>
        <feather-icon
          icon="LinkIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Social</span>
      </template>

      <account-setting-social
        v-if="options.social"
        :social-data="options.social"
      />
    </b-tab>

    <!-- notification -->
    <b-tab>

      <!-- title -->
      <template #title>
        <feather-icon
          icon="BellIcon"
          size="18"
          class="mr-50"
        />
        <span class="font-weight-bold">Notifications</span>
      </template>

      <account-setting-notification
        v-if="options.general"
        :user-data="options.general"
        :notification-data="options.general.notifications?options.general.notifications:{}"
      />
    </b-tab>
  </b-tabs>
</template>

<script>
import { BTabs, BTab } from 'bootstrap-vue'
import AccountSettingGeneral from './AccountSettingGeneral.vue'
import AccountSettingPassword from './AccountSettingPassword.vue'
import AccountSettingInformation from './AccountSettingInformation.vue'
import AccountSettingSocial from './AccountSettingSocial.vue'
import AccountSettingNotification from './AccountSettingNotification.vue'
export default {
  components: {
    BTabs,
    BTab,
    AccountSettingGeneral,
    AccountSettingPassword,
    AccountSettingInformation,
    AccountSettingSocial,
    AccountSettingNotification,
  },
  data() {
    return {
      options: {
        general:{}
      },
    }
  },
  beforeCreate() {
    // this.$http.get('/account-setting/data').then(res => { this.options = res.data })
  },
  methods:{
    getUser()
    {
    let user =   localStorage.getItem('userData');
    this.options.general = JSON.parse(user);
    }
  },
  mounted(){
    this.getUser();
    if(this.options.general.notifications.length<= 0)
    {
     this.options.general.notifications = {};
     this.options.general.notifications.commentOnArticle = false;
     this.options.general.notifications.AnswerOnForm = false;
     this.options.general.notifications.followMe = false;
     this.options.general.notifications.newAnnouncements = false;
     this.options.general.notifications.productUpdates = false;
     this.options.general.notifications.blogDigest = false;
    }else{
     this.options.general.notifications.commentOnArticle =  this.options.general.notifications.commentOnArticle?this.options.general.notifications.commentOnArticle:false;
     this.options.general.notifications.AnswerOnForm =  this.options.general.notifications.AnswerOnForm?this.options.general.notifications.AnswerOnForm:false;
     this.options.general.notifications.followMe = this.options.general.notifications.followMe?this.options.general.notifications.followMe:false;;
     this.options.general.notifications.newAnnouncements = this.options.general.notifications.newAnnouncements?this.options.general.notifications.newAnnouncements:false;;
     this.options.general.notifications.productUpdates = this.options.general.notifications.productUpdates?this.options.general.notifications.productUpdates:false;;
     this.options.general.notifications.blogDigest = this.options.general.notifications.blogDigest?this.options.general.notifications.blogDigest:false;;
    }
  }
}
</script>
