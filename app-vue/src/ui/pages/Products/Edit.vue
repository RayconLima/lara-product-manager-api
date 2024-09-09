
<template>
    <Modal ref="modalUpdateProductRef" class="items-end" buttonColor="bg-orange-500" title="Alterar" :closeButton="false"
        :acceptFunction="updateProduct">
        <div class="mb-5">
            <label for="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
            <input id="label" v-model="form.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
            <select id="category" v-model="form.category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Selecione a categoria</option>
                <option v-for="category in categories.data" :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
        </div>
        <div class="mb-5">
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço</label>
            <input id="price" type="text" v-model="form.price"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
        <div class="mb-5">
            <label for="expiration_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data de validade</label>
            <input id="expiration_date" type="date" v-model="form.expiration_date"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
            <input id="description" type="text" v-model="form.description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
    </Modal>
</template>
<script>
import { ref, watch, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useProductStore } from "../../../store/products";
import { useCategoryStore } from "../../../store/categories";   
export default {
    name: 'EditProduct',
    components: {
        Modal
    },
    props: {
      data: Object,
    },
    setup(props) {
        const modalUpdateProductRef     = ref(null);
        const productStore              = useProductStore();
        const categoryStore             = useCategoryStore();
        const categories                = computed(() => useCategoryStore().categories);
        const form                      = ref({
            name            : props.data.name,
            category_id     : props.data.category?.id,
            price           : props.data.price,
            expiration_date : props.data.expiration_date,
            description     : props.data.description,
        });

        onMounted(() => {
            useCategoryStore().getCategories();
        });
        
        const updateProduct = async () => {
            await productStore.updateProduct(props.data.id, {...form.value, price: form.value.price.replace(",", ".")})
                .then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Produto atualizado com sucesso",
                        type: "success",
                    });
                    modalUpdateProductRef.value?.hideModal();
                })
                .catch((e) => {
                    notify({
                        title: "Deu ruim",
                        text: e?.data?.message,
                        type: "warning",
                    });
                })
                .finally(() => {
                    productStore.getProducts();
                });
        }

        return {
            categories,
            form,
            updateProduct,
            modalUpdateProductRef,
        }
    }
}
</script>