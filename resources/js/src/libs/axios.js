import Vue from 'vue'

// axios
import axios from 'axios'
console.log(process.env.MIX_APP_URL);
const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: process.env.MIX_APP_URL,
  // timeout: 1000,
  // headers: {'X-Custom-Header': 'foobar'}
})

Vue.prototype.$http = axiosIns

export default axiosIns
