import BaseService from "./base.service";

export default class ProductsService extends BaseService {
    
    static async products(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: false })
                .get('products', params)
                .then((response: any) => {
                    resolve(response)
                })
                .catch((error: any) => {
                    reject(error.response)
                })
        })
    }

    static async storeProduct(params: any) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: false })
                .post('products', params)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async getProduct(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: false })
                .get(`products/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }

    static async updateProduct(id: number, payload: any) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: false })
                .put(`products/${id}`, {...payload, name: payload.label.toLowerCase().trim()})
                .then((response:any) => resolve(response))
                .catch((error : any) => reject(error.response))
        })
    }

    static async destroy(id: number) {
        return new Promise(async (resolve, reject) => {
            await this.request({ auth: false })
                .delete(`products/${id}`)
                .then((response:any) => resolve(response))
                .catch((error: any) => reject(error.response))
        })
    }
}