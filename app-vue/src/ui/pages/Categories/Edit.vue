
<template>
    <Modal ref="modalUpdateCategoryRef" class="items-end" buttonColor="bg-orange-500" title="Alterar" :closeButton="false"
        :acceptFunction="updateCategory">
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
            <input id="name" v-model="form.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
    </Modal>
</template>
<script>
import { ref, watch, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useCategoryStore } from "../../../store/categories";   
export default {
    name: 'EditCategory',
    components: {
        Modal
    },
    props: {
      data: Object,
    },
    setup(props) {
        const modalUpdateCategoryRef    = ref(null);
        const categoryStore             = useCategoryStore();
        const categories                = computed(() => useCategoryStore().categories);
        const form                      = ref({
            name            : props.data.name,
        });

        onMounted(() => {
            useCategoryStore().getCategories();
        });
        
        const updateCategory = async () => {
            await categoryStore.updateCategory(props.data.id, form.value)
                .then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Categoria atualizada com sucesso",
                        type: "success",
                    });
                    modalUpdateCategoryRef.value?.hideModal();
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
            updateCategory,
            modalUpdateCategoryRef,
        }
    }
}
</script>