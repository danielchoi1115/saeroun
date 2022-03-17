import http from '@/api/http'

export async function post_user(_data) {
  return http.post('/api/user', _data)
}
