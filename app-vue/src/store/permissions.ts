import { defineStore } from "pinia";
import PermissionsService from "../infra/services/acl/permissions.service"

export const usePermissionStore = defineStore('permission', {
    state: () => ({
        permissions: [],
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getPermissions() {
            this.isLoading = true;
            return await PermissionsService.permissions().then((response: any) => {
                this.permissions = response.data
            }).finally(() => this.isLoading = false)
        },
    }
});