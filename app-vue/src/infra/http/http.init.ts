import axios, { AxiosInstance } from 'axios'
import { URL_API, TOKEN_NAME } from '../../config'

export default class Http {
    instance: AxiosInstance
    constructor(status: any) {
      const token = localStorage.getItem(TOKEN_NAME)

      const headers = status.auth ? {
          Authorization: `Bearer ${token}`
      } : {}

      this.instance = axios.create({
          baseURL: URL_API,
          headers: headers
      })
    }

    get(url: string, params?: any) {
      return this.instance.get(url, { params });
    }
  
    post(url: string, data?: any) {
      return this.instance.post(url, data);
    }
  
    put(url: string, data?: any) {
      return this.instance.put(url, data);
    }
  
    delete(url: string) {
      return this.instance.delete(url);
    }
}