<template>
  <b-row>
    <b-col cols="12">
      <tabs-calc />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'

import TabsCalc from './Tabs.vue'

export default {
  components: {
    BRow,
    BCol,
    TabsCalc,
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-autosuggest.scss';
</style>
