import { TOKEN_NAME } from "../../config";
import BaseService from "./base.service";

interface UserFormInterface {
    name: String,
    email: String,
    password: String
  }

export default class AuthService extends BaseService {
    static async auth(params: UserFormInterface) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('login', params)
                .then(response => {
                    localStorage.setItem(TOKEN_NAME, response.data.token)
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static async register({ name, email, password }: UserFormInterface) {
        return new Promise((resolve, reject) => {
            this.request()
                .post('register', { name, email, password })
                .then(response => {
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }

    static async getMe() {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('me')
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    localStorage.removeItem(TOKEN_NAME)
                    reject(error.response)
                })
        })
    }

    static async checkToken(token: string) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .post('verify-email', { token })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    reject(error.response)
                })
        })
    }

    static async verifyEmailfromToken(token: string) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .post('verify-email', { token: token })
                .then(response => {
                    resolve(response.data)
                })
                .catch(error => {
                    localStorage.removeItem(TOKEN_NAME)
                    reject(error.response)
                })
        })
    }

    static logout() {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .post('logout')
                .then(response => {
                    resolve(response)
                })
                .catch(error => reject(error.response))
        })
    }
}