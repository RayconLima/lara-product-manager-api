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
                    </ul>
                </div>
            </div>

            <div class="container flex bg-white rounded-md shadow-md mt-4">
            <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-4" >
                <div v-for="image in images.data" :key="image.id">
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
import { useProductStore } from "../../../store/products";
import { useProductImageStore } from "../../../store/product-images";
import { formatMoney } from '../../../config/utils/helpers';
export default {
    name: 'Single',
    components: {
        Breadcrumb,
        CreateProduct
    },
    setup() {
        const productStore          = useProductStore();
        const productImageStore     = useProductImageStore();
        const product               = computed(()   => useProductStore().product);
        const images                = computed(()   => productImageStore.images);
        const route                 = useRoute();

        onMounted(() => {
            useProductStore().getProduct(route.params.id);
            useProductImageStore().getImages();
        });

        const destroyProduct = (id) => {
            productStore.destroyProduct(id)
        }

        return {
            images,
            product,
            formatMoney,
            destroyProduct
        }
    }
}
</script>