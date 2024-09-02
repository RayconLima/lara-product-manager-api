<template>
    <div class="container">
        <Breadcrumb title="Produtos">
            <CreateProduct v-can="'new_product'" />
        </Breadcrumb>
        
        <div
        class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <form class="flex items-center mb-2" @submit.prevent="search">
                <div class="mr-2">
                    <select v-model="form.type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled>Selecione</option>
                        <option value="name">Nome</option>
                        <option value="description">Descrição</option>
                    </select>
                </div>
                <div>
                    <input type="text" placeholder="Informe sua pesquisa" v-model="form.search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-3x/4 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <button type="submit"
                    class="ml-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Pesquisar
                </button>
            </form>
            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">
                                <Spinner v-if="productStore.loading" :loading="productStore.loading" />
                            </th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Categoria</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Preço</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Validade</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="product in products.data"
                            :key="product?.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product?.category?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ formatMoney(product?.price) }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ customformatDate(product?.expiration_date) }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex justify-between">
                                    <router-link class="px-1 py-1 font-bold text-white bg-blue-500 rounded hover hover:bg-blue-700" v-can="'show_product'" :to="{ name: 'products.show', params: { id: product?.id } }">Visualizar</router-link>
                                    <UpdateProduct v-can="'update_product'" :data="product" />
                                    <button class="px-1 py-1 font-bold text-white bg-red-500 rounded hover hover:bg-red-700" v-can="'destroy_product'" @click.stop.prevent="destroyProduct(product?.id)">Remover</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    routeName="products.index"
                    :pagination="products"
                    @changePage="changePage"
                ></Pagination>
                <!-- <Pagination :currentPage="products.meta.current_page" :totalPages="products.meta.total" /> -->
            </div>
        </div>
    </div>
</template>
<script>
import CreateProduct from './Create.vue'
import UpdateProduct from './Edit.vue'
import Breadcrumb from '../../components/Breadcrumb.vue';
import Spinner from '../../components/Spinner.vue';
import Pagination from '../../components/Pagination.vue';
import { computed, onMounted, ref } from 'vue';
import { useProductStore } from "../../../store/products";
import { useRoute } from 'vue-router';
import { formatMoney, customformatDate } from '../../../config/utils/helpers';

export default {
    name: 'Products',
    components: {
        Spinner,
        Breadcrumb,
        Pagination,
        CreateProduct,
        UpdateProduct,
    },
    setup() {
        const route         = useRoute();
        const productStore  = useProductStore();
        const products      = computed(() => useProductStore().products);
        const form          = ref({
            type    : '',
            search  : '',
        });
        const filteredProducts = computed(() => productStore.filteredProducts);

        onMounted(() => {
            useProductStore().getProducts({ page: 1 });
        });

        const changePage = (page) => {
            productStore.getProducts({ page });
        };

        const destroyProduct = (id) => {
            productStore.destroyProduct(id).finally(() => {
                useProductStore().getProducts();
            })
        }

        const search = async () => {
            if(form.value.type == 'name') {
                await productStore.getProducts({
                    name: form.value.search,
                });
            } 
            
            if (form.value.type == 'description'){
                await productStore.getProducts({
                    description: form.value.search,
                });
            }
        }

        return {
            form,
            search,
            products,
            changePage,
            formatMoney,
            productStore,
            destroyProduct,
            filteredProducts,
            customformatDate,
        }
    }
}
</script>