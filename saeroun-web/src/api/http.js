import axios from 'axios'

const instance = axios.create({
  timeout: 5000,
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  },
  withCredentials: true,
})

// 모든 리퀘스트에 header/쿠키 담아 보내기
// instance.interceptors.request.use(function (config) {
//   if (store.state.auth.token !== null) {
//     config['headers'] = {
//       Authorization: `Bearer ${store.state.auth.access_token}`,
//     }
//   }
//   return config
// })

export default instance
