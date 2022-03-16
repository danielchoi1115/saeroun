<template>
  <form @submit.prevent="signin">
    <label>Email</label>
    <input v-model="email" type="email" required />

    <label>Password</label>
    <input v-model="password" type="password" required />

    <div class="submit">
      <button>Login</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Password: {{ password }}</p>
</template>

<script>
import * as authApi from '@/api/auth'
export default {
  data() {
    return {
      email: '',
      password: '',
    }
  },
  methods: {
    signin() {
      authApi
        .signin(this.email, this.password)
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
