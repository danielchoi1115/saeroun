<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png" />
    <h2>This is Saeroun English</h2>
  </div>
  <p>{{ result }}</p>
  <p>{{ data }}</p>

  <Suspense>
    <template #default>
      <HomeForm />
    </template>
    <template #fallback>
      <span>Loading...</span>
    </template>
  </Suspense>
</template>

<script>
import HomeForm from '@/frames/HomeFrame.vue'
export default {
  name: 'HomeView',
  components: {
    HomeForm,
  },
  data() {
    return {
      hasAuth: false,
      result: '',
      data: '',
    }
  },
}
</script>
