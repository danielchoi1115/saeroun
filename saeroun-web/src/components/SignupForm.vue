<template>
  <form @submit.prevent="signup">
    <label>Email</label>
    <input v-model="email" type="email" required />

    <label>Name</label>
    <input v-model="student_name" type="student_name" required />

    <label>Password</label>
    <input v-model="password" type="password" required />

    <label>Confirm Password</label>
    <input v-model="password_confirm" type="password" required />

    <div class="submit">
      <button>Sign Up</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Password: {{ password }}</p>
  <p>Password_confirm: {{ password_confirm }}</p>
</template>

<script>
import * as authApi from '@/api/auth'

export default {
  data() {
    return {
      email: '',
      student_name: '',
      password: '',
      password_confirm: '',
    }
  },
  methods: {
    signup() {
      authApi
        .signup(
          this.email,
          this.student_name,
          this.password,
          this.password_confirm,
        )
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
