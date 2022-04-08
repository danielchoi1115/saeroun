import http from '@/api/http'
import * as validate from '@/api/validation'

export async function post_user(_data) {
  if ('password_confirm' in _data) {
    validate.is_password_matching(_data)
  }
  return http.post('/api/user', _data)
}

export async function get_user_info() {
  return http.get('/api/user')
}
