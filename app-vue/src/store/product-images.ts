import { defineStore } from "pinia";
import ProductImagesService from "../infra/services/product-images.service";

export const useProductImageStore = defineStore('productImage', {
    state: () => ({
        images: [],
        image: {},
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getImages(params?: {}) {
            this.isLoading = true
            return ProductImagesService.images(params).then((response: any) => {
                this.images = response.data
                return this.images
            }).finally(() => this.isLoading = false)
        },
    }
})