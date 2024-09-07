import { defineStore } from 'pinia';
import AuthService from '../infra/services/auth.service'
import { useMeStore } from './me';

interface UserFormInterface {
  name: String,
  email: String,
  password: String
}

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),

  actions: {
    async login(params: UserFormInterface) {
      return await AuthService.auth(params).then((response: any) => {
        localStorage.setItem(import.meta.env.VITE_APP_TOKEN_NAME, response.data.token)
        const meStore = useMeStore();
        meStore.user  = response.data.data
        this.user     = response.data.data;
      })
    },
    async register({ name, email, password }: UserFormInterface) {
      return await AuthService.register({
        name,
        email,
        password
      }).then((response: any) => {
        const meStore = useMeStore();
        meStore.user  = response.data.data;
        this.user     = response.data.data;
        return response;
      });
    },
    async logout() {
      return await AuthService.logout().then((response) => {
        localStorage.removeItem(import.meta.env.VITE_APP_TOKEN_NAME)
        this.user = null;
        return response;
      })
    },
   async verifyEmail(token: string) {
      return await AuthService.checkToken(token).then((response) => response)
    },
    // forgotPassword(email) {
    //   return axios.post('forgot-password', { email })
    // },
    // resetPassword(token, password) {
    //   return axios.post('reset-password', { token, password })
    // }
  }
});