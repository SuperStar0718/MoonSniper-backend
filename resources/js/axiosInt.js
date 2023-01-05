import axios from 'axios';
let token  = localStorage.getItem('accessToken');
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

export default axios