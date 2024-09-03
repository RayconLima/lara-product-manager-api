import { defineStore } from "pinia";
import RolesService from "../infra/services/acl/roles.service"

export const useRoleStore = defineStore('role', {
    state: () => ({
        roles: [],
    }),
    actions: {
        async getRoles() {
            return await RolesService.roles().then((response: any) => {
                this.roles = response.data
            })
        },
    }
});