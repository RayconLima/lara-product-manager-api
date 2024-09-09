import BaseService from "./base.service";

export default class RolesService extends BaseService {
    static async users(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('users', params)
                .then((response: any) => {
                    resolve(response)
                })
                .catch((error: any) => {
                    reject(error.response)
                })
        })
    }
    static async getUser(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .get(`users/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }
    static async storeUser(params: any) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .post('users', params, { headers: { 'Content-Type': 'multipart/form-data' }})
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async destroyUser(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .delete(`users/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async setRole(userId:number, roleId: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .put(`user/${userId}/set-role`, {role_id: roleId})
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }
}