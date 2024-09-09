import { defineStore } from "pinia";
import RolesService from "../infra/services/acl/roles.service"

export const useRolesStore = defineStore('role', {
    state: () => ({
        roles: [],
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getRoles() {
            this.isLoading = true
            return await RolesService.roles().then((response: any) => {
                this.roles = response.data
            }).finally(() => this.isLoading = false)
        },
    }
});