import axios from 'axios'
import Constants from './confidentials'

const instance = axios.create({
  baseURL: Constants.BASEURL,
  timeout: 5000,
})

export default instance
