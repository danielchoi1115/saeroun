<template>
  <div class="submit">
    <button>Get User Name</button>
  </div>
  <div>
    <p>username: {{ userdata.username }}</p>
    <p>email: {{ userdata.email }}</p>
  </div>
</template>

<script>
export default {
  props: {
    userdata: Object({
      email: String,
      username: String,
      account_type: String,
    }),
  },
  data() {
    return {}
  },
}
</script>

<style></style>
