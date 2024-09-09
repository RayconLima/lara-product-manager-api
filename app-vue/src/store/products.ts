import { defineStore } from "pinia";
import ProductsService from "../infra/services/products.service";

interface ProductInterface {
    name: String,
    price: Number,
    description: String,
    expiration_date: Date,
    category_id: Number
}

export const useProductStore = defineStore('product', {
    state: () => ({
        products: [],
        product: {},
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getProducts(params?: {}) {
            this.isLoading = true
            return ProductsService.products(params).then((response: any) => {
                this.products = response.data
                return this.products
            }).finally(() => this.isLoading = false)
        },
        async saveProduct(params: ProductInterface) {
            this.isLoading = true
            await ProductsService
                .storeProduct(params)
                .then((response: any) => {
                    return this.products = response.data.data;
                }).finally(() => {
                    this.getProducts()
                    this.isLoading = false
                })
        },
        async getProduct(id: number) {
            await ProductsService
                .getProduct(id)
                .then((response: any) => {
                    return this.product = response.data.data;
                })
        },
        async updateProduct(id: number, params: ProductInterface) {
            this.isLoading = true;
            await ProductsService
                .updateProduct(id, params)
                .then((response: any) => {
                    return this.products = response.data.data;
                }).finally(() => {
                    this.getProducts()
                    this.isLoading = false
                })
        },
        destroyProduct(id: number) {
            ProductsService.destroy(id).then(() => {
                this.getProducts();
            })
        }
    }
})