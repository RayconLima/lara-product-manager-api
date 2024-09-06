<template>
    <Modal ref="modalUpdateUserRef" class="items-end ml-auto" title="Alterar cargo" buttonColor="bg-gray-500" :closeButton="false"
        :acceptFunction="setRole">
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
            <select id="category" v-model="roleSelected" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Selecione o cargo</option>
                <option v-for="role in roles.data" :key="role.id" :value="role.name">{{ role.name }}</option>
            </select>
        </div>
    </Modal>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import Modal from '../../components/Modal.vue';
import { notify } from '@kyvg/vue3-notification';
import { useUsersStore } from "../../../store/users";
import { useRolesStore } from "../../../store/roles";
export default {
    name: 'UpdateUser',
    components: {
        Modal
    },
    props: {
      data: Object,
    },
    setup(props) {
        const modalUpdateUserRef    = ref(null);
        const userStore             = useUsersStore();
        const users                 = computed(() => useUsersStore().users);
        const roles                 = computed(() => useRolesStore().roles);
        const roleSelected          = ref('')

        onMounted(() => {
            useRolesStore().getRoles();
        });

        const setRole = () => {
            userStore.setRole(roleSelected.value)
        }

        return {
            users,
            roles,
            setRole,
            roleSelected,
            modalUpdateUserRef,
        }
    }
}
</script>