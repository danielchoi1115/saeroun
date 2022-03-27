<template>
  <div class="q-pa-md">
    <div class="q-gutter-md" style="max-width: 300px">
      <q-input v-model="email" label="Standard" />

      <q-input v-model="email" filled label="Filled" />

      <q-input v-model="email" outlined label="Outlined" />

      <q-input v-model="email" standout label="Standout" />

      <q-input v-model="email" standout="bg-teal text-white" label="Custom standout" />

      <!-- https://quasar.dev/vue-components/select#using-menu-and-filtering -->
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  data() {
    return {
      email: ref(''),
      name: '',
      password: '',
    }
  },
  methods: {
    // signin() {
    //   authApi
    //     .signin(this.email, this.password)
    //     .then(response => {
    //       console.log(response.data)
    //     })
    //     .catch(error => {
    //       console.log(error.response.data)
    //     })
    // },
  },
}
</script>

<style></style>
