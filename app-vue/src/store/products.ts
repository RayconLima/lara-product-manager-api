import { defineStore } from "pinia";
import ProductsService from "../infra/services/products.service";

export const useProductStore = defineStore('product', {
    state: () => ({
        products: []
    }),
    actions: {
        getProducts() {
            return ProductsService.products().then((response: any) => {
                this.products = response.data.data
                return this.products
            })
        }
    }
})