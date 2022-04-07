<template>
  <div class="q-pa-md">
    <div class="q-gutter-md" style="max-width: 300px">
      <q-input v-model="email" label="Standard" />
      <!-- https://quasar.dev/vue-components/select#using-menu-and-filtering -->
    </div>
  </div>
  <form @submit.prevent="get_user">
    <div class="submit">
      <button>Get User Name</button>
    </div>
  </form>
  <div>
    <p>user_name: {{ user_name }}</p>
  </div>
</template>

<script>
import { ref } from 'vue'
import * as authApi from '@/api/auth'

export default {
  data() {
    return {
      email: ref(''),
      user_name: '',
      password: '',
    }
  },
  methods: {
    get_user() {
      authApi
        .get_user()
        .then(response => {
          console.log(response.data)
        })
        .catch(error => {
          console.log(error.response.data)
        })
    },
  },
}
</script>

<style></style>
