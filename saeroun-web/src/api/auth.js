import http from '@/api/http'
import * as validate from '@/api/validation'

export async function post_user(_data) {
  if ('password_confirm' in _data) {
    validate.is_password_matching(_data)
  }
  return http.post('/api/user', _data)
}

export function get_user() {
  return http.get('/api/user')
}

export async function loadUserData() {
  var result = false
  var data = null
  await get_user()
    .then(response => {
      result = true
      data = response.data
    })
    .catch(error => {
      result = false
      data = null
    })

  return new Promise(resolve => {
    setTimeout(() => {
      resolve({
        result: result,
        data: data,
      })
    }, 5)
  })
}
