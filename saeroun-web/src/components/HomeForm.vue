<template>
  <form @submit.prevent="get_user_info">
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
import * as auth from '@/api/auth'

export default {
  data() {
    return {
      email: ref(''),
      user_name: '',
      password: '',
    }
  },
  methods: {
    get_user_info() {
      auth
        .get_user_info()
        .then(response => {
          console.log(response.data)
          this.user_name = response.data.username
        })
        .catch(error => {
          console.log(error.response.data)
        })
    },
  },
}
</script>

<style></style>
