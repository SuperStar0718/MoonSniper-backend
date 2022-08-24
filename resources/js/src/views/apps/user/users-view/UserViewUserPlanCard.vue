<template>
  <b-card
    no-body
    class="border-primary"
  >
    <b-card-header class="d-flex justify-content-between align-items-center pt-75 pb-25">
      <h5 class="mb-0">
        Current Plan
      </h5>
      <b-badge variant="light-primary">
        {{ currentPlan }}
      </b-badge>
      <small class="text-muted w-100 d-none" >July 22, 2021</small>
    </b-card-header>

    <b-card-body>
      <ul class="list-unstyled my-1 d-none">
        <li>
          <span class="align-middle">5 Users</span>
        </li>
        <li class="my-25">
          <span class="align-middle">10 GB storage</span>
        </li>
        <li>
          <span class="align-middle">Basic Support</span>
        </li>
      </ul>
      <b-button
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
        variant="primary"
        block
      >
        Upgrade Plan
      </b-button>
    </b-card-body>
  </b-card>
</template>

<script>
import {
  BCard, BCardHeader, BCardBody, BBadge, BButton,
} from 'bootstrap-vue'
import Ripple from 'vue-ripple-directive'

export default {
  directives: {
    Ripple,
  },
  components: {
    BCard,
    BCardHeader,
    BCardBody,
    BBadge,
    BButton,
  },
  props:{
     userData: {
                type: Object,
                required: true,
            },
  },
  computed:{
    currentPlan()
    {
      switch (this.userData.currentPlan) {
        case 'basic':
            return 'Basic'
          break;
           case 'enterprise':
            return 'Enterprise'
          break;
           case 'team':
            return 'Team'
          break;
      
        default:
          return '-'
          break;
      }
    }
  }
}
</script>

<style>

</style>
