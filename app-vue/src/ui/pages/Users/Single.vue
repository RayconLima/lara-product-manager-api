<template>
    <div class="container">
        <Breadcrumb title="Usuários" routeName="users.index" routeSingleName="users.show" :data="user" />
        <div class="mb-4 w-full mr-4">
            <div class="container flex justify-between bg-white rounded-md shadow-md">
                <div>
                    <ul class="container p-4">
                        <h1 class="px-2 py-2 font-bold">Informações</h1>
                        <h2><span class="px-2 py-2 font-semibold">Nome:</span> {{ user?.name }}</h2>
                        <li><span class="px-2 py-2 font-semibold">E-mail:</span> {{ user?.email }}</li>
                    </ul>
                </div>
                <SetRole :data="user" />
            </div>
            <div class="container flex bg-white rounded-md shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Label</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="permission in user.permissions"
                            :key="product?.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ permission?.name }}
                            </td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ permission?.label }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import { computed, onMounted } from 'vue';
import { useUsersStore } from '../../../store/users';
import Breadcrumb from '../../components/Breadcrumb.vue';
import SetRole from './Role.vue'
import { useRoute } from 'vue-router';
export default {
    name: 'Single User',
    components: {
        Breadcrumb,
        SetRole
    },
    setup() {
        const userStore = useUsersStore();
        const user      = computed(()   => userStore.user);
        const route     = useRoute();

        onMounted(() => {
            userStore.getUser(route.params.id);
        });

        return {
            user
        }
    }
}
</script>
