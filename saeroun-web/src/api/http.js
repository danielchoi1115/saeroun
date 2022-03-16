import store from '@/store'
import axios from 'axios'

const instance = axios.create({
  timeout: 5000,
})

instance.interceptors.request.use(function (config) {
  if (store.state.auth.token !== null) {
    config['headers'] = {
      Authorization: `Bearer ${store.state.auth.access_token}`,
    }
  }
  return config
})

export default instance
