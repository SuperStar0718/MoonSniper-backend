import Vue from 'vue'

// axios
import axios from 'axios'
let token  = localStorage.getItem('accessToken');
const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  baseURL: process.env.MIX_APP_URL,
  // timeout: 1000,
  headers: {Authorization: `Bearer ${token}`}
})

Vue.prototype.$http = axiosIns

export default axiosIns
