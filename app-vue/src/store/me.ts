import { defineStore } from 'pinia';
import AuthService from '../infra/services/auth.service'

interface PermissionUser {
  id: number;
  name: string;
  label: string;
  created_at: null | string;
  updated_at: null | string;
}

interface UserRole {
  id: number;
  name: string;
  label: string;
  created_at: null | string;
  updated_at: null | string;
  permissions: PermissionUser[];
}

interface User {
  id: number;
  name: string;
  email: string;
  avatar: string;
  roles: UserRole[];
  permissions: string[];
}

export const useMeStore = defineStore('me', {
  state: () => ({
    user: {} as User,
  }),

  actions: {
    async getMe() {
      try {
        return await AuthService.getMe().then(async (response:any) => {
          this.user = await response.data
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