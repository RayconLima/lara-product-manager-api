<template>
    <Modal ref="modalCreateProductRef" class="items-end ml-auto" title="Novo produto" :closeButton="false"
        :acceptFunction="newProduct">
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
                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
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
        <div class="flex items-center justify-center w-full">
            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                </div>
                <input id="dropzone-file" type="file" @change="handleImageChange" class="hidden" />
            </label>
        </div> 
        <img v-if="imagePreview" :src="imagePreview" alt="Imagem do produto">
    </Modal>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useProductStore } from "../../../store/products";
import { useCategoryStore } from "../../../store/categories";   
export default {
    name: 'CreateProduct',
    components: {
        Modal
    },
    setup() {
        const modalCreateProductRef     = ref(null);
        const productStore              = useProductStore();
        const categoryStore             = useCategoryStore();
        const categories                = computed(() => useCategoryStore().categories);
        const imagePreview              = ref(null);
        const form                      = ref({
            name            : '',
            category_id     : '',
            price           : '',
            expiration_date : '',
            description     : '',
            image           : null
        });

        onMounted(() => {
            useCategoryStore().getCategories();
        });

        const handleImageChange = (event) => {
            const file = event.target.files[0];
            if (!file) return;

            // Create a reader for preview and a separate object for sending
            const previewReader = new FileReader();

            // Handle preview
            previewReader.readAsDataURL(file);
            previewReader.onload = (e) => {
                imagePreview.value = e.target.result; // Update form for preview
            };
            form.value.image = file;
        };

        const newProduct = () => {
            const formData = new FormData();
            formData.append('name', form.value.name);
            formData.append('category_id', form.value.category_id);
            formData.append('price', form.value.price);
            formData.append('expiration_date', form.value.expiration_date);
            formData.append('image', form.value.image);
            productStore.saveProduct(formData)
                .then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Produto registrado com sucesso",
                        type: "success",
                    });
                    modalCreateProductRef.value?.hideModal();
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
            imagePreview,
            newProduct,
            handleImageChange,
            modalCreateProductRef,
        }
    }
}
</script>