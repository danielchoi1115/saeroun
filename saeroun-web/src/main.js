import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { Quasar } from 'quasar'
import quasarUserOptions from './quasar-user-options'
// import store from './store'

const app = createApp(App)
// app.use(store)
app.use(router)
app.use(Quasar, quasarUserOptions)
app.mount('#app')

// var user = {
//   id: 1,
//   name: 'Journal',
//   session: '25j_7Sl6xDq2Kc3ym0fmrSSk2xV2XkUkX',
// }
// this.$cookies.set('user', user)
// // print user name
// console.log(this.$cookies.get('user').name)
