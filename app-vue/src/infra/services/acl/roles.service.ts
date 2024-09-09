import BaseService from "../base.service";

export default class RolesService extends BaseService {
    static async roles(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('roles', params)
                .then(response => {
                    resolve(response)
                })
                .catch(error => {
                    reject(error.response)
                })
        })
    }
}