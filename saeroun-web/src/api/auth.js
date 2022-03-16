import http from '@/api/http'
import { VueCookieNext } from 'vue-cookie-next'

export async function signin(email, password) {
  const response = await http.post('/api/user/auth', {
    email,
    password,
  })
  if (response.status === 200) {
    VueCookieNext.setCookie('access_token', response.data.access_token)
  }

  return response
}
export async function signup(email, student_name, password, password_confirm) {
  return http.post('/api/user/new', {
    email,
    student_name,
    password,
    password_confirm,
  })
}
