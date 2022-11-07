<template>
    <section id="dashboard-analytics">
      <b-row class="match-height">
        <b-col
          lg="6"
          md="12"
        >
       <table></table>
        </b-col>
      </b-row>
  
    </section>
  </template>
  
  <script>
  import { BRow, BCol } from 'bootstrap-vue'
  import Table from "./table/bs-table/Table.vue"
  import { kFormatter } from '@core/utils/filter'
  
  export default {
    components: {
      BRow,
      BCol,
      Table
    },
    data() {
      return {
        data: {},
      }
    },
    created() {
      // data
      this.$http.get('/analytics/data')
        .then(response => { this.data = response.data })
    },
    methods: {
      kFormatter,
    },
  }
  </script>
  