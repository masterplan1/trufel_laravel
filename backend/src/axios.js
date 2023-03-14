import axios from "axios"
import store from "./store"
import router from "./router"
import { def } from "@vue/shared"

const axiosClient = axios.create({
  baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`
})

axiosClient.interceptors.request.use(config => {
  config.headers = {
    'Authorization': `Bearer ${store.state.user.token}`,
    'Accept': 'application/json'
  }
  return config
})

axiosClient.interceptors.response.use(response => {
  return response
}, error => {
  if(error.response.status === 401){
    sessionStorage.removeItem('TOKEN')
    router.push({name: 'login'})
  }
  throw error
  // console.error(error)
})

export default axiosClient;