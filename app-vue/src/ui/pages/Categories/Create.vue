<template>
    <Modal ref="modalCreateCategoryRef" class="items-end ml-auto" title="Nova categoria" :closeButton="false"
        :acceptFunction="newCategory">
        <div class="mb-5">
            <label for="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
            <input id="label" v-model="form.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
    </Modal>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useCategoryStore } from "../../../store/categories";   
export default {
    name: 'CreateCategory',
    components: {
        Modal
    },
    setup() {
        const modalCreateCategoryRef    = ref(null);
        const categoryStore             = useCategoryStore();
        const categories                = computed(() => useCategoryStore().categories);
        const form                      = ref({
            name            : '',
        });

        const newCategory = () => {
            categoryStore.saveCategory(form.value)
                .then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Categoria registrado com sucesso",
                        type: "success",
                    });
                    modalCreateCategoryRef.value?.hideModal();
                })
                .catch((e) => {
                    notify({
                        title: "Deu ruim",
                        text: e?.data?.message,
                        type: "warning",
                    });
                })
                .finally(() => {
                    categoryStore.getCategories();
                });
        }

        return {
            categories,
            form,
            newCategory,
            modalCreateCategoryRef,
        }
    }
}
</script>