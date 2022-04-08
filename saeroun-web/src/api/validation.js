import * as auth from '@/api/auth'

export function is_password_matching(_data) {
  if (_data['password'] != _data['password_confirm']) {
    throw { validation: 'Password match failed' }
  }
}

export function EmailResolver(email) {
  if (email == '') {
    return requiredInputResolver(email)
  }

  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
  if (!emailPattern.test(email)) {
    return new Promise(resolve => {
      resolve('Please use valid email.')
    })
  }

  return new Promise(resolve => {
    auth
      .post_user({ email: email, check_only_email: true })
      .then(response => {
        resolve(true)
      })
      .catch(error => {
        if (error.response.status === 409) {
          resolve('This email is taken. Try another.')
        }
      })
  })
}

export function requiredInputResolver(input) {
  return new Promise(resolve => {
    resolve(!!input || 'This field cannot be empty.')
  })
}

export function passwordConfirmResolver(password, password_confirm) {
  if (password_confirm == '') {
    return requiredInputResolver(password_confirm)
  }
  return new Promise(resolve => {
    resolve(!!(password == password_confirm) || 'Password does not match.')
  })
}
