import { defineStore } from "pinia";
import UsersService from "../infra/services/users.service"

export const useUserStore = defineStore('users', {
    state: () => ({
        users: [],
        isLoading: false
    }),
    actions: {
        async getUsers() {
            return await UsersService.users().then((response: any) => {
                this.users = response.data
            })
        },
        async saveUser(params: any) {
            this.isLoading = true
            await UsersService
                .storeUser(params)
                .then((response: any) => {
                    return this.users = response.data.data;
                }).finally(() => {
                    this.getUsers()
                    this.isLoading = false
                })
        },
    }
});