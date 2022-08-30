<template>
  <b-card>
    <b-row>
      <h6 class="section-label mx-1 mb-2">
        Activity
      </h6>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
        @click="notificationData.commentOnArticle!=notificationData.commentOnArticle"
          id="accountSwitch1"
          :checked="notificationData.commentOnArticle"
          name="check-button"
          v-model="notificationData.commentOnArticle"
          inline
          switch
        >
          <span>Email me when someone comments on my article</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
        @click="notificationData.AnswerOnForm!=notificationData.AnswerOnForm"
          id="accountSwitch2"
          :checked="notificationData.AnswerOnForm"
          name="check-button"
          v-model="notificationData.AnswerOnForm"
          switch
          inline
        >
          <span>Email me when someone answers on my form</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
        @click="notificationData.followMe!=notificationData.followMe"
          id="accountSwitch3"
          :checked="notificationData.followMe"
          name="check-button"
          v-model="notificationData.followMe"
          switch
          inline
        >
          <span>Email me hen someone follows me</span>
        </b-form-checkbox>
      </b-col>

      <!-- application switch -->
      <h6 class="section-label mx-1 mt-2">
        Application
      </h6>
      <b-col
        cols="12"
        class="mt-1 mb-2"
      >
        <b-form-checkbox
        @click="notificationData.newAnnouncements=!notificationData.newAnnouncements"
          id="accountSwitch4"
          :checked="notificationData.newAnnouncements"
          name="check-button"
          v-model="notificationData.newAnnouncements"
          switch
          inline
        >
          <span>News and announcements</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
        @click="notificationData.productUpdates=!notificationData.productUpdates"
          id="accountSwitch5"
          :checked="notificationData.productUpdates"
          name="check-button"
          v-model="notificationData.productUpdates"
          switch
          inline
        >
          <span>Weekly product updates</span>
        </b-form-checkbox>
      </b-col>
      <b-col
        cols="12"
        class="mb-2"
      >
        <b-form-checkbox
        @click="notificationData.blogDigest!=notificationData.blogDigest"
          id="accountSwitch6"
          :checked="notificationData.blogDigest"
          name="check-button"
          v-model="notificationData.blogDigest"
          switch
          inline
        >
          <span>Weekly blog digest</span>
        </b-form-checkbox>
      </b-col>
      <!--/ application switch -->

      <!-- buttons -->
      <b-col cols="12">
        <b-button @click="updateNotification"
          v-ripple.400="'rgba(255, 255, 255, 0.15)'"
          variant="primary"
          class="mr-1 mt-1"
        >
          Save clicks
        </b-button>
        <b-button
          v-ripple.400="'rgba(186, 191, 199, 0.15)'"
          type="reset"
          class="mt-1"
          variant="outline-secondary"
        >
          Cancel
        </b-button>
      </b-col>
      <!--/ buttons -->
    </b-row>
  </b-card>
</template>

<script>
import {
  BButton, BRow, BCol, BCard, BFormCheckbox,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'
import axios from '@axios'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
  import {
        useToast
    } from 'vue-toastification/composition'
export default {
  components: {
    BButton,
    BRow,
    BCol,
    BCard,
    BFormCheckbox,
    ToastificationContent
  },
  directives: {
    Ripple,
  },
  props: {
    notificationData: {
      type: Object,
      default: () => {},
    },
    userData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      // localOptions: JSON.parse(JSON.stringify(this.notificationData)),
    }
  },
  methods:{
   
  },
  setup(props)
  {
    const toast = useToast({});

    const  updateNotification = ()=> {
              
                axios
                    .post(`api/user/updatenotofications`,{notifications: props.notificationData})
                    .then(response => {
                        if (response.data.status == 'success') {
                            props.userData.notifications = response.data.notifications;
                              localStorage.setItem('userData', JSON.stringify(  props.userData ))
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Notificatons are updated',
                                    variant: 'success',
                                     icon: 'CheckCircleIcon',
                                },
                            })
                        } else {
                            toast({
                                component: ToastificationContent,
                                props: {
                                    title: 'Something went wrong!',
                                    variant: 'error',
                                    variant:'XCircleIcon'
                                },
                            })
                        }

                    })
            }
            return{
              updateNotification
            }
  }
}
</script>
