<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <h1>This is Saeroun English</h1>
    <p>hi</p>
  </div>
  <HomeForm />
</template>

<script>
// @ is an alias to /src
import HomeForm from '@/components/HomeForm.vue'

export default {
  name: 'HomeView',
  components: {
    HomeForm,
  },
}
</script>
