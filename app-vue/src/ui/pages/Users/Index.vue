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
                            <th class="px-8 py-2 text-white bg-gray-800 border-b">
                                <Spinner v-if="userStore.loading" :loading="userStore.loading" />
                            </th>
                            <th class="px-8 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-8 py-2 text-white bg-gray-800 border-b">E-mail</th>
                            <th class="px-8 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="user in users.data"
                            :key="user?.id">
                            <th class="px-4 py-2 text-white border-b"></th>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ user?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ user?.email }}
                            </td>
                            <td scope="row" class="px-3 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex justify-between">
                                    <router-link class="px-1 py-1 font-bold text-white bg-blue-500 rounded hover hover:bg-blue-700" :to="{ name: 'users.show', params: { id: user.id } }">Visualizar</router-link>
                                    <SetRole :data="user" />
                                    <button class="ml-2 px-1 py-1 font-bold text-white bg-red-500 rounded hover hover:bg-red-700" v-can="'destroy_user'" @click.stop.prevent="destroyUser(user.id)">Remover</button>
                                </div>
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
import SetRole from './Role.vue'
import { computed, onMounted } from 'vue';
import Spinner from '../../components/Spinner.vue';
import { useUsersStore } from "../../../store/users";
import Breadcrumb from '../../components/Breadcrumb.vue';

export default {
    name: 'Users',
    components: {
        Spinner,
        Breadcrumb,
        CreateUser,
        SetRole
    },
    setup() {
        const userStore = useUsersStore();
        const users     = computed(() => userStore.users);

        onMounted(() => {
            userStore.getUsers();
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
</script>./Role.vue