import { defineStore } from "pinia";
import CategoriesService from "../infra/services/categories.service";

export const useCategoryStore = defineStore('category', {
    state: () => ({
        categories: []
    }),
    actions: {
        async getCategories() {
            return CategoriesService.categories().then((response: any) => {
                this.categories = response.data.data
                return this.categories
            })
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