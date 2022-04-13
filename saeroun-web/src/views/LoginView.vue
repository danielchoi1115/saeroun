<template>
  <div class="login">
    <h1>This is a login page</h1>
  </div>
  <LoginPage />
</template>

<script>
// @ is an alias to /src
import LoginPage from '@/components/LoginPage.vue'

export default {
  name: 'LoginView',
  components: {
    LoginPage,
  },
}
</script>
