<template>
  <div v-if="userData.result"><LobbyPage :userdata="userData.data" /></div>
  <div v-else><LoginPage /></div>
</template>

<script>
import { ref, defineAsyncComponent } from 'vue'
import * as auth from '@/api/auth'

const LobbyPage = defineAsyncComponent(() => import('@/components/LobbyPage.vue'))
const LoginPage = defineAsyncComponent(() => import('@/components/LoginPage.vue'))

export default {
  components: {
    LobbyPage,
    LoginPage,
  },
  async setup() {
    const userData = ref(await auth.loadUserData())
    return {
      userData,
    }
  },
}
</script>

<style></style>
