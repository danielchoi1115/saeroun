<template>
  <div class="about">
    <h1>This is an about page</h1>
  </div>
  <SignupForm />
</template>

<script>
// @ is an alias to /src
import SignupForm from '@/components/SignupForm.vue'

export default {
  name: 'SignupView',
  components: {
    SignupForm,
  },
}
</script>
