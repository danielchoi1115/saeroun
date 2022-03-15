<template>
  <div class="login">
    <h1>This is a login page</h1>
  </div>
  <LoginForm />
</template>

<script>
// @ is an alias to /src
import LoginForm from '@/components/LoginForm.vue'

export default {
  name: 'HomeView',
  components: {
    LoginForm,
  },
}
</script>
