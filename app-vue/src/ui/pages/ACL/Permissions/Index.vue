<template>
    <div class="container">
        <Breadcrumb title="Permissões"></Breadcrumb>

        <div
        class="w-full p-2 text-center bg-white rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-full">
            <div class="bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">
                                <Spinner v-if="permissionStore.loading" :loading="permissionStore.loading" />
                            </th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b">Nome</th>
                            <th class="px-4 py-2 text-white bg-gray-800 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white dark:bg-gray-800 dark:border-gray-700" v-for="permission in permissions.data"
                            :key="product?.id">
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ permission?.name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    routeName="permissions.index"
                    :pagination="permissions"
                    @changePage="changePage"
                ></Pagination>
            </div>
        </div>
    </div>
</template>
<script>
import { onMounted, computed } from 'vue';
import { usePermissionStore } from '../../../../store/permissions';
import Breadcrumb from '../../../components/Breadcrumb.vue';
export default {
    name: 'Permissions',
    components: {
        Breadcrumb
    },
    setup() {
        const permissionStore  = usePermissionStore();
        const permissions      = computed(() => permissionStore.permissions);
        onMounted(() => {
            usePermissionStore().getPermissions();
        });

        return {
            permissions,
            permissionStore
        }
    }
}
</script>