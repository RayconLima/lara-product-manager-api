import { defineStore } from "pinia";
import PermissionsService from "../infra/services/acl/permissions.service"

export const usePermissionStore = defineStore('permission', {
    state: () => ({
        permissions: [],
    }),
    actions: {
        async getPermissions() {
            return await PermissionsService.permissions().then((response: any) => {
                this.permissions = response.data.data
            })
        },
    }
});