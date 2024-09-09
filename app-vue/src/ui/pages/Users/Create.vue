<template>
    <Modal ref="modalCreateUserRef" class="items-end ml-auto" title="Novo usuário" :closeButton="false"
        :acceptFunction="newUser">
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome</label>
            <input id="name" v-model="form.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required>
        </div>
        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <input id="email" v-model="form.email" type="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senha</label>
            <input id="password" v-model="form.password" type="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
        <img v-if="avatarPreview" :src="avatarPreview" alt="Avatar do usuário">
    </Modal>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useUsersStore } from "../../../store/users";   
export default {
    name: 'CreateUser',
    components: {
        Modal
    },
    setup() {
        const modalCreateUserRef    = ref(null);
        const userStore             = useUsersStore();
        const users                 = computed(() => useUserStore().users);
        const form                  = ref({
            name        : '',
            email       : '',
            password    : '',
            avatar      : null
        });

        const newUser = () => {
            userStore.saveUser(form.value)
                .then(() => {
                    notify({
                        title: "Deu certo",
                        text: "Usuário registrado com sucesso",
                        type: "success",
                    });
                    modalCreateUserRef.value?.hideModal();
                })
                .catch((e) => {
                    notify({
                        title: "Deu ruim",
                        text: e?.data?.message,
                        type: "warning",
                    });
                })
                .finally(() => {
                    userStore.getUsers();
                });
        }

        return {
            users,
            form,
            newUser,
            modalCreateUserRef,
        }
    }
}
</script>