<template>
  <b-card>
    <!-- about -->
    <div
      v-for="(data,key,index) in aboutData"
      :key="data.id"
      :class="index ? 'mt-2':''"
    >
      <h5 class="text-capitalize mb-75">
        {{ key }}
      </h5>
      <b-card-text>
        {{ data }}
      </b-card-text>
    </div>
  </b-card>
</template>

<script>
import { BCard, BCardText } from 'bootstrap-vue'
export default {
  components: {
    BCard,
    BCardText,
  },
  props: {
    aboutData: {
      type: Object,
      default: () => {},
    },
  },
}
</script>
<style>
  .card-body {
    padding: 1.5rem !important;
  }
</style>
