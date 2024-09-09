<template>
    <div class="container">
        <Breadcrumb title="products" routeName="products.index" routeSingleName="products.show" :data="product" />
        <div class="mb-4 w-full mr-4">
            <div class="container flex bg-white rounded-md shadow-md">
                <div>
                    <ul class="container p-4">
                        <h2 class="px-2 py-2"><span class="font-bold">Produto:</span> {{ product?.name }}</h2>
                        <li><span class="px-2 py-2 text-gray-500 font-semibold">Categoria:</span> {{ product?.category?.name }}</li>
                        <li><span class="px-2 py-2 text-gray-500 font-semibold">Preço:</span> {{ formatMoney(product?.price) }}</li>
                        <li><span class="px-2 py-2 text-gray-500 font-semibold">Descrição:</span> {{ product?.description }}</li>
                        <li><span class="px-2 py-2 text-gray-500 font-semibold">Data de validade:</span> {{ product?.expiration_date }}</li>
                        <li><span class="px-2 py-2 text-gray-500 font-semibold">Quantidade de imagens:</span> {{ images?.meta?.total }}</li>
                    </ul>
                </div>
            </div>

            <div class="container flex bg-white rounded-md shadow-md mt-4">
                <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-4" >
                    <Spinner v-if="productImageStore.loading" :loading="productImageStore.loading" />
                    <div v-else v-for="image in images.data" :key="image.id">
                        <button @click.prevent="destroyImage(image.id)" type="button" class="absolute top-[5] left-[-6] m-2 flex justify-center items-center text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-4 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">X</button>
                        <img class="h-5/4 max-w-full rounded-lg" :src="`${image.path}`" :alt="`${image.path}`">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import CreateProduct from './Create.vue'
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import Breadcrumb from '../../components/Breadcrumb.vue';
import Spinner from '../../components/Spinner.vue';
import { useProductStore } from "../../../store/products";
import { useProductImageStore } from "../../../store/product-images";
import { formatMoney } from '../../../config/utils/helpers';
export default {
    name: 'Single',
    components: {
        Spinner,
        Breadcrumb,
        CreateProduct
    },
    setup() {
        const productStore          = useProductStore();
        const productImageStore     = useProductImageStore();
        const product               = computed(()   => productStore.product);
        const images                = computed(()   => productImageStore.images);
        const route                 = useRoute();

        onMounted(() => {
            productStore.getProduct(route.params.id);
            productImageStore.getImages({ product_id: route.params.id});
        });

        const destroyProduct = (id) => {
            productStore.destroyProduct(id)
        }

        const destroyImage = (id) => {
            productImageStore.destroyImage(id)
        }

        return {
            images,
            product,
            formatMoney,
            destroyImage,
            destroyProduct,
            productImageStore
        }
    }
}
</script>