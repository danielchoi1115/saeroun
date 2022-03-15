import axios from 'axios'
// import Constants from './confidentials'

const instance = axios.create({
  // baseURL: Constants.BASEURL,
  withCredentials: true,
  timeout: 5000,
})

export default instance
