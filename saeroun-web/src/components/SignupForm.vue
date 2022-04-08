<template>
  <form @submit.prevent.stop="onSubmit">
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
        <q-input
          ref="emailRef"
          v-model="email"
          clearable
          label="Email"
          debounce="500"
          type="email"
          :loading="emailLoadingState"
          :rules="[EmailValidation]"
        />
        <q-input ref="usernameRef" v-model="username" label="Name" :rules="[requiredInputValidation]" />
        <q-input
          ref="passwordRef"
          v-model="password"
          type="password"
          label="Password"
          :rules="[requiredInputValidation]"
          @focus="password = ''"
        />
        <q-input
          ref="password_confirmRef"
          v-model="password_confirm"
          type="password"
          label="Confirm Password"
          :rules="[passwordConfirmValidation]"
          @focus="password_confirm = ''"
        />
      </div>
    </div>

    <div class="submit">
      <button>Sign Up</button>
    </div>
  </form>
  <p>Email: {{ email }}</p>
  <p>Username: {{ username }}</p>
  <p>Password: {{ password }}</p>
  <p>Password_confirm: {{ password_confirm }}</p>
</template>

<script>
import { ref } from 'vue'
import * as authApi from '@/api/auth'
import * as validator from '@/api/validation'
export default {
  setup() {
    const email = ref('')
    const emailRef = ref(null)

    const username = ref('')
    const usernameRef = ref(null)

    const password = ref('')
    const passwordRef = ref(null)

    const password_confirm = ref('')
    const password_confirmRef = ref(null)

    return {
      email,
      username,

      emailRef,
      usernameRef,

      password,
      passwordRef,

      password_confirm,
      password_confirmRef,

      EmailValidation(email) {
        return validator.EmailResolver(email)
      },

      requiredInputValidation(val) {
        return validator.requiredInputResolver(val)
      },

      passwordConfirmValidation(password_confirm) {
        return validator.passwordConfirmResolver(password.value, password_confirm)
      },

      onSubmit() {
        emailRef.value.validate()
        usernameRef.value.validate()
        passwordRef.value.validate()
        password_confirmRef.value.validate()

        if (
          !emailRef.value.hasError ||
          !usernameRef.value.hasError ||
          !passwordRef.value.hasError ||
          !password_confirmRef.value.hasError
        ) {
          const data = {
            email: this.email,
            username: this.username,
            password: this.password,
            password_confirm: this.password_confirm,
            account_type: 'pending',
          }
          authApi
            .post_user(data)
            .then(response => {
              console.log(response.data)
            })
            .catch(error => {
              if ('validation' in error) {
                console.log(error.validation)
              } else {
                console.log(error.response.data)
              }
            })
        }
      },
    }
  },
  data() {
    return {
      emailLoadingState: ref(false),
    }
  },
  methods: {},
}
</script>

<style></style>
