<template>
  <form @submit.prevent="signup">
    <label>Email</label>
    <input type="email" required v-model="email" />

    <label>Name</label>
    <input type="student_name" required v-model="student_name" />

    <label>Password</label>
    <input type="password" required v-model="password" />

    <label>Confirm Password</label>
    <input type="password" required v-model="password_confirm" />

    <div class="submit">
      <button>Sign Up</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Password: {{ password }}</p>
  <p>Password_confirm: {{ password_confirm }}</p>
</template>

<script>
import * as authApi from '@/module/auth'

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
