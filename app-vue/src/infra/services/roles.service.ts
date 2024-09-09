import BaseService from "./base.service";

export default class RolesService extends BaseService {
    
    static async roles(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('roles', params)
                .then((response: any) => {
                    resolve(response)
                })
                .catch((error: any) => {
                    reject(error.response)
                })
        })
    }
}