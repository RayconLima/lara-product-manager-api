import { defineStore } from "pinia";
import ProductsService from "../infra/services/products.service";

export const useProductStore = defineStore('product', {
    state: () => ({
        products: []
    }),
    actions: {
        async getProducts() {
            return ProductsService.products().then((response: any) => {
                this.products = response.data.data
                return this.products
            })
        },
        async saveProduct(params: any) {
            await ProductsService
                .storeProduct(params)
                .then((response: any) => {
                    return this.products = response.data.data;
                })
        },
        destroyProduct(id: number) {
            ProductsService.destroy(id).then(() => {
                this.getProducts();
            })
        }
    }
})