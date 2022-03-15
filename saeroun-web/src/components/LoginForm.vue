<template>
  <form @submit.prevent="signup">
    <label>Email</label>
    <input type="email" required v-model="email" />

    <label>Password</label>
    <input type="password" required v-model="password" />

    <div class="submit">
      <button>Login</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Password: {{ password }}</p>
</template>

<script>
import * as authApi from '@/module/auth'

export default {
  data() {
    return {
      email: '',
      password: '',
    }
  },
  methods: {
    signup() {
      authApi
        .login(this.email, this.password)
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
