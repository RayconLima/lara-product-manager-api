import { defineStore } from 'pinia';
import AuthService from '../infra/services/auth.service'

export const useMeStore = defineStore('me', {
  state: () => ({
    user: null,
  }),

  actions: {
    async getMe() {
      try {
        return await AuthService.getMe().then(async (response:any) => {
          this.user   =   await response.data
        });
      } catch (error) {
        throw error;
      }
    }
  },

  getters: {
    isLoggedIn: (state) => !!state.user
  }
})