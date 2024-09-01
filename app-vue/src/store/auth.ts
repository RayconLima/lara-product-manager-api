import { defineStore } from 'pinia';
import AuthService from '../infra/services/auth.service'
import { useMeStore } from './me';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
  }),

  actions: {
    async login(email: string, password: string) {
      return await AuthService.auth({email, password}).then((response: any) => {
        localStorage.setItem(import.meta.env.VITE_APP_TOKEN_NAME, response.data.token)
        const meStore = useMeStore();
        meStore.user  = response.data.data
        this.user     = response.data.data;
      })
    },
    // async register({ name, email, password }) {
    //   return await AuthService.register({
    //     plan_id,
    //     name,
    //     email,
    //     password
    //   }).then((response) => {
    //     const meStore = useMeStore();
    //     meStore.user  = response.data.data;
    //     this.user     = response.data.data;
    //     return response;
    //   });
    // },
    // logout() {
    //   return AuthService.logout().then((response) => {
    //     localStorage.removeItem(import.meta.env.VITE_APP_TOKEN_NAME)
    //     this.user = null;
    //     return response;
    //   })
    // },
    // verifyEmail(token) {
    //   return axios.post('api/verify-email', { token })
    // },
    // forgotPassword(email) {
    //   return axios.post('api/forgot-password', { email })
    // },
    // resetPassword(token, password) {
    //   return axios.post('api/reset-password', { token, password })
    // }
  }
});