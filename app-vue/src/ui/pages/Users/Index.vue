<template>
    <div class="container">
        <Breadcrumb title="Usuários">
            <CreateUser />
        </Breadcrumb>

        <div
            class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">

            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">
                                <Spinner v-if="userStore.loading" :loading="userStore.loading" />
                            </th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">E-mail</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="user in users.data"
                            :key="user?.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ user?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ user?.email }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <button class="px-1 py-1 font-bold text-white bg-red-500 rounded hover hover:bg-red-700" v-can="'destroy_user'" @click.stop.prevent="destroyUser(user.id)">Remover</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import CreateUser from './Create.vue'
import Breadcrumb from '../../components/Breadcrumb.vue';
import Spinner from '../../components/Spinner.vue';
import { computed, onMounted } from 'vue';
import { useUserStore } from "../../../store/users";

export default {
    name: 'Users',
    components: {
        Spinner,
        Breadcrumb,
        CreateUser
    },
    setup() {
        const userStore = useUserStore();
        const users     = computed(() => useUserStore().users);

        onMounted(() => {
            useUserStore().getUsers();
        });

        // const destroyUser = (id) => {
        //     userStore.destroyUser(id).finally(() => {
        //         useProductStore().getUsers();
        //     })
        // }

        return {
            users,
            userStore,
            // destroyUser
        }
    }
}
</script>