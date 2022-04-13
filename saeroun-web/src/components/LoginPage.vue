<template>
  <div class="loginbox">
    <form>
      <div class="q-pa-md">
        <div
          class="q-gutter-md"
          style="
            padding: 5px;
            max-width: 400px;
            width: 500px;
            margin: 30px auto;
            display: -webkit-box;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
            border-color: black;
            border-width: 1px;
            border-radius: 4px;
            box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
          "
        >
          <q-input v-model="email" label="Email" type="email" :rules="[myRule]" />
          <q-input v-model="password" type="password" label="Password" />
          <div class="submit">
            <button type="submit" @click.stop.prevent="signin()">Login</button>
          </div>
        </div>
      </div>
    </form>
    <p>Email: {{ email }}</p>
    <p>Password: {{ password }}</p>
  </div>
</template>

<script>
import { ref } from 'vue'
import * as authApi from '@/api/auth'
export default {
  setup() {
    return {
      model: ref(''),
      myRule(val) {
        return new Promise(resolve => {
          setTimeout(() => {
            // call
            //  resolve(true)
            //     --> content is valid
            //  resolve(false)
            //     --> content is NOT valid, no error message
            //  resolve(error_message)
            //     --> content is NOT valid, we have error message
            resolve(!!val || 'Email cannot be empty.')
          }, 100)
        })
      },
    }
  },
  data() {
    return {
      email: ref(''),
      password: ref(''),
    }
  },
  methods: {
    signin() {
      authApi
        .post_user(this.$data)
        .then(response => {
          console.log(response.status)
          console.log(response.data)
          this.$router.go(this.$router.currentRoute)
        })
        .catch(error => {
          console.log(error.response.status)
          console.log(error.response.data)
        })
    },
  },
}
</script>

<style></style>
