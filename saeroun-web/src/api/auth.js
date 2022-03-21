import http from '@/api/http'

export async function post_user(_data) {
  if ('password_confirm' in _data) {
    if (_data['password'] != _data['password_confirm']) {
      throw { validation: 'Password match failed' }
    }
  }
  return http.post('/api/user', _data)
}
