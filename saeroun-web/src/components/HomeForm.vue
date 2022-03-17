<template>
  <!-- <form @submit.prevent="signin"> -->
  <form>
    <label>Email</label>
    <input type="email" required />

    <label>Name</label>
    <input type="name" required />

    <div class="submit">
      <button>Get User Info</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Name: {{ name }}</p>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      name: '',
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
