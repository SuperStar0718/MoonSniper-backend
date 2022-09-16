<template>
  <b-row>
    <b-col cols="12">
      <auto-suggest-basic />
      <auto-suggest-slot />
      <auto-suggest-section />
      <auto-suggest-ajax />
    </b-col>
  </b-row>
</template>

<script>
import { BRow, BCol } from 'bootstrap-vue'
import AutoSuggestBasic from '../autosuggest/AutoSuggestBasic.vue'
import AutoSuggestSlot from '../autosuggest/AutoSuggestSlot.vue'
import AutoSuggestSection from '../autosuggest/AutoSuggestSection.vue'
import AutoSuggestAjax from '../autosuggest/AutoSuggestAjax.vue'

export default {
  components: {
    BRow,
    BCol,
    AutoSuggestBasic,
    AutoSuggestSlot,
    AutoSuggestSection,
    AutoSuggestAjax,
  },
}
</script>

<style lang="scss">
@import '~@resources/scss/vue/libs/vue-autosuggest.scss';
</style>
