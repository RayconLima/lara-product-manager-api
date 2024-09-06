import { defineStore } from "pinia";
import UsersService from "../infra/services/users.service"

export const useUsersStore = defineStore('users', {
    state: () => ({
        users: [],
        user: {},
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getUsers() {
            this.isLoading = true
            return await UsersService.users().then((response: any) => {
                this.users = response.data
            }).finally(() => this.isLoading = false)
        },
        async getUser(id: number) {
            await UsersService
                .getUser(id)
                .then((response: any) => {
                    return this.user = response.data.data;
                })
        },
        async saveUser(params: any) {
            this.isLoading = true
            await UsersService
                .storeUser(params)
                .then((response: any) => this.users = response.data.data)
                .finally(() => {
                    this.getUsers()
                    this.isLoading = false
                })
        },
        async setRole(params: any) {
            await UsersService
                .setRole(params)
                .then((response: any) => this.users = response.data.data)
                .finally(() => {
                    this.getUsers()
                    this.isLoading = false
                })
        }
    }
});