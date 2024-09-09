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

    static async storeCategory(params: String) {
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

    static async updateCategory(id: number, params: String) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: true })
                .put(`categories/${id}`, params)
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