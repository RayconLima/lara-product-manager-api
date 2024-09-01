<template>
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <router-link to="/" class="flex ml-2 md:mr-24">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" :alt="title"
                            :title="title" />
                        <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">
                            {{ title }}
                        </span>
                    </router-link>
                </div>
                <div class="flex items-center">
                    <div class="items-center ml-3">
                        <div class="flex items-center">
                            <button type="button" @click="openProfileMenu"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full"
                                    :src="user?.image_url ?? 'https://flowbite.com/docs/images/people/profile-picture-5.jpg'"
                                    alt="user photo">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div v-if="openUserMenu"
        class="z-50 mt-16 mr-4 text-base bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
        id="dropdown-user" style="position: absolute; top: 0; right: 0;">
        <div class="px-4 py-4">
            <p class="text-sm text-gray-900 dark:text-white">
                {{ user?.name }}
            </p>
            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">
                {{ user?.email }}
            </p>
        </div>
        <ul class="py-1 w-full">
            <li>
                <router-link to="/profile"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Meu perfil
                </router-link>
            </li>
            <li>
                <a href="#"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Settings</a>
            </li>
            <li>
                <a @click.prevent="logout"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">Sair</a>
            </li>
        </ul>
    </div>
</template>
<script>
import { ref, computed, onMounted } from 'vue';
import { useMeStore } from '../../store/me';
import { useAuthStore } from '../../store/auth';
import { useRouter } from 'vue-router';

export default {
    name: 'Navbar',
    setup() {
        const openUserMenu = ref(false);
        const authStore = useAuthStore()
        const router = useRouter();
        const currentPage = ref('');
        const meStore = useMeStore()
        const user = computed(() => meStore?.user);
        const title = import.meta.env.VITE_APP_NAME;


        onMounted(() => {
            meStore.getMe();
        })

        const logout = () => {
            authStore.logout().finally(() => router.go());
        }

        const openProfileMenu = () => {
            openUserMenu.value = !openUserMenu.value;
        }

        return {
            logout,
            openProfileMenu,
            openUserMenu,
            currentPage,
            user: user.value,
            title
        }
    }
};
</script>