<template>
    <div class="container">
        <Breadcrumb title="Produtos"></Breadcrumb>

        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Categoria</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Preço</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Validade</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="product in products"
                            :key="product.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product?.category?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product.price }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product.expiration_date }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import Breadcrumb from '../../components/Breadcrumb.vue';
import { computed, onMounted } from 'vue';
import { useProductStore } from "../../../store/products";

export default {
    name: 'Products',
    components: {
        Breadcrumb,
    },
    setup() {
        const products = computed(() => useProductStore().products);

        onMounted(() => {
            useProductStore().getProducts();
        });

        return {
            products,
        }
    }
}
</script>