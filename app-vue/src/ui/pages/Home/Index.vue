<template>
    <div class="container">
        <Breadcrumb title="Dashboard" />
        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <div class="grid grid-cols-3 gap-4">
                <CardDash title="Quantidade produtos" color="blue" :dataCount="products?.meta?.total"/>
                <CardDash title="Quantidade de categorias" color="green" :dataCount="categories?.meta?.total"/>
            </div>
        </div>
    </div>
</template>
<script>
import { computed, onMounted } from 'vue';
import Breadcrumb from '../../components/Breadcrumb.vue';
import { useProductStore } from '../../../store/products';
import { useCategoryStore } from '../../../store/categories';
import CardDash from '../../components/CardDash.vue';
export default {
    name: 'Home',
    components: {
        Breadcrumb,
        CardDash
    },
    setup() {
        const productStore      = useProductStore();
        const categoryStore     = useCategoryStore();
        const products          = computed(() => productStore.products);
        const categories        = computed(() => categoryStore.categories);

        onMounted(async () => {
            await productStore.getProducts();
            await categoryStore.getCategories();
        });

        return {
            products,
            categories,
        }
    }
}
</script>