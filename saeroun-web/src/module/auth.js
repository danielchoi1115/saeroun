import http from './http'

export async function login(email, password) {
  return http.post('/api/user/auth', {
    email,
    password,
  })
}

export async function signup(email, student_name, password, password_confirm) {
  return http.post('/api/user/new', {
    email,
    student_name,
    password,
    password_confirm,
  })
}
