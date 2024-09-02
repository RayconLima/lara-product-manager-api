import { defineStore } from "pinia";
import CategoriesService from "../infra/services/categories.service";

export const useCategoryStore = defineStore('category', {
    state: () => ({
        categories: [],
        isLoading: false
    }),
    getters: {
        loading (state: any) {
            return state.isLoading
        }
    },
    actions: {
        async getCategories() {
            this.isLoading = true
            return CategoriesService.categories().then((response: any) => {
                this.categories = response.data.data
                return this.categories
            }).finally(() => this.isLoading = false)
        },
        async saveCategory(params: any) {
            await CategoriesService
                .storeCategory(params)
                .then((response: any) => {
                    return this.categories = response.data.data;
                })
        },
        destroyCategory(id: number) {
            CategoriesService.destroy(id).then(() => {
                this.getCategories();
            })
        }
    }
})