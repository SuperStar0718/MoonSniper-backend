<template>
  <b-row>
    <b-col cols="12">
      <auto-suggest-ajax />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'

import AutoSuggestAjax from './AutoSuggestAjax.vue'

export default {
  components: {
    BRow,
    BCol,
    AutoSuggestAjax,
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-autosuggest.scss';
</style>
