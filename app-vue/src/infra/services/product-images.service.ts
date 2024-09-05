import BaseService from "./base.service";

export default class ProductImagesService extends BaseService {
    static async images(params?: any) {
        return new Promise((resolve, reject) => {
            this.request({ auth: true })
                .get('product/images', params)
                .then((response: any) => {
                    resolve(response)
                })
                .catch((error: any) => {
                    reject(error.response)
                })
        })
    }
}