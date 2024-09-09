<template>
    <Modal ref="modalChangeRoleRef" class="items-end ml-auto" title="Alterar cargo" buttonColor="bg-gray-500" :closeButton="false"
        :acceptFunction="changeRole">
        <div class="mb-5">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cargo</label>
            <select id="category" v-model="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Selecione o cargo</option>
                <option v-for="role in roles.data" :key="role.id" :value="role.id">{{ role.name }}</option>
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
    name: 'ChangeRole',
    components: {
        Modal
    },
    props: {
      data: Object,
    },
    setup(props) {
        const modalChangeRoleRef    = ref(null);
        const userStore             = useUsersStore();
        const users                 = computed(() => useUsersStore().users);
        const roles                 = computed(() => useRolesStore().roles);
        const role_id               = ref(null)

        onMounted(() => {
            useRolesStore().getRoles();
        });

        const changeRole = () => {
            userStore.setRole(props.data.id, role_id.value).then(() => {
                notify({
                    title: "Deu certo",
                    text: "Cargo atualizado com sucesso",
                    type: "success",
                });
                modalChangeRoleRef.value?.hideModal();
            })
        }

        return {
            users,
            roles,
            role_id,
            changeRole,
            modalChangeRoleRef,
        }
    }
}
</script>