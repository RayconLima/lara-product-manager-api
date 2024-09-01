import BaseService from "./base.service";

export default class CategoriesService extends BaseService {
    
    static async categories(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('categories', params)
                .then((response: any) => {
                    resolve(response)
                })
                .catch((error: any) => {
                    reject(error.response)
                })
        })
    }

    static async storeCategory(params: any) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .post('categories', params)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async getCategory(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .get(`categories/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async updateCategory(id: number, payload: any) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .put(`categories/${id}`, {...payload, name: payload.label.toLowerCase().trim()})
                .then((response:any) => resolve(response))
                .catch((error : any) => reject(error.response))
        })
    }

    static async destroy(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .delete(`categories/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }
}