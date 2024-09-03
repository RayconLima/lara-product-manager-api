import axios, { AxiosInstance, AxiosRequestConfig } from 'axios'
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
  
    post(url: string, data?: any, config?: AxiosRequestConfig) {
      return this.instance.post(url, data, config);
    }
  
    put(url: string, body: object, configs?: object): Promise<any> {
      return this.instance.put(url, body, configs);
    }
  
    delete(url: string) {
      return this.instance.delete(url);
    }
}