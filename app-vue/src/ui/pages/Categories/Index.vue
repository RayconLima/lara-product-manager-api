<template>
    <div class="container">
        <Breadcrumb title="Categorias">
            <CreateCategory />
        </Breadcrumb>

        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">
                                <Spinner v-if="categoryStore.loading" :loading="categoryStore.loading" />
                            </th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="category in categories.data"
                            :key="category?.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ category?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <button class="px-1 py-1 font-bold text-white bg-red-500 rounded hover hover:bg-red-700" v-can="'destroy_category'" @click.stop.prevent="destroyCategory(category.id)">Remover</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import CreateCategory from './Create.vue'
import Breadcrumb from '../../components/Breadcrumb.vue';
import Spinner from '../../components/Spinner.vue';
import { computed, onMounted } from 'vue';
import { useCategoryStore } from "../../../store/categories";

export default {
    name: 'Categories',
    components: {
        Spinner,
        Breadcrumb,
        CreateCategory
    },
    setup() {
        const categoryStore = useCategoryStore();
        const categories    = computed(() => useCategoryStore().categories);

        onMounted(() => {
            useCategoryStore().getCategories();
        });

        const destroyCategory = (id) => {
            categoryStore.destroyCategory(id).finally(() => {
                useProductStore().getCategories();
            })
        }

        return {
            categories,
            categoryStore,
            destroyCategory
        }
    }
}
</script>