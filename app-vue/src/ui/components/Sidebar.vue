<template>
    <div>
      <ul class="space-y-2 font-medium">
        <template v-for="(items, groupName) in groupedSidebar" :key="groupName">
          <template v-if="groupName !== 'geral' && shouldRenderGroup(items)">
            <li>
              <button type="button" v-if="items.title"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                @click="toggleDropdown(groupName)">
                <i :class="items.icon"></i>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ items.title }}</span>
                <svg :class="{ 'transform rotate-180': isDropdownOpen(groupName) }" class="w-3 h-3" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>
              <ul v-show="isDropdownOpen(groupName)" class="py-2 space-y-2">
                <template v-for="(item, index) in items?.items" :key="index">
                  <li v-if="hasPermission(item)">
                    <router-link :to="{ name: item.to }"
                      class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                      :class="{ 'bg-gray-100 dark:bg-gray-700': isRouteActive(item.to) }">
                      <span class="ml-3">{{ item.title }}</span>
                    </router-link>
                  </li>
                </template>
              </ul>
            </li>
          </template>
          <template v-else-if="groupName !== 'geral' && shouldRenderGroup(items)">
            <li>
              <button type="button" v-if="items.title"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                @click="toggleDropdown(groupName)">
                <i :class="items.icon"></i>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ items.title }}</span>
                <svg :class="{ 'transform rotate-180': isDropdownOpen(groupName) }" class="w-3 h-3" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
                </svg>
              </button>
              <ul v-show="isDropdownOpen(groupName)" class="py-2 space-y-2">
                <template v-for="(item, index) in items?.items" :key="index">
                  <li v-if="hasPermission(item)">
                    <router-link :to="{ name: item.to }"
                      class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                      :class="{ 'bg-gray-100 dark:bg-gray-700': isRouteActive(item.to) }">
                      <span class="ml-3">{{ item.title }}</span>
                    </router-link>
                  </li>
                </template>
              </ul>
            </li>
          </template>
          <template v-else>
            <template v-for="(item, index) in items.items" :key="index">
              <li v-if="hasPermission(item)">
                <router-link :to="{ name: item.to }" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white"
                  :class="{ 'bg-gray-100 dark:bg-gray-700': isRouteActive(item.to) }">
                  <i :class="item.icon"></i>
                  <span class="ml-3">{{ item.title }}</span>
                </router-link>
              </li>
            </template>
          </template>
        </template>
      </ul>
    </div>
  </template>
  
  <script>
  import { onMounted, ref, computed } from "vue";
  import router from '../../routes';
  import sidebar from "../../config/sidebar.ts";
  
  export default {
    name: "Sidebar",
    props: {
      user: null
    },
    setup(props) {
      const loading       = ref(false);
      const openDropdowns = ref([]);
      const user          = props?.user;
  
    //   const logout = () => {
    //     loading.value = true;
    //     store.dispatch("logout")
    //       .then(() => router.push({ name: "login" }))
    //       .finally(() => (loading.value = false));
    //   };
  
      const isRouteActive = (routeName) => {
        return router.currentRoute.value.name === routeName;
      };
    
      const toggleDropdown = (groupName) => {
        const index = openDropdowns.value.indexOf(groupName);
        if (index === -1) {
          openDropdowns.value.push(groupName);
        } else {
          openDropdowns.value.splice(index, 1);
        }
      };
  
      const isDropdownOpen = (groupName) => {
        return openDropdowns.value.includes(groupName);
      };
  
      const groupedSidebar = computed(() => {
        const grouped = {};
        for (const group in sidebar.menu) {
          if (sidebar.menu.hasOwnProperty(group)) {
            if (group.toLowerCase() === 'geral') {
              grouped['geral'] = { title: 'Geral', items: sidebar.menu[group].items };
            } else {
              grouped[group] = sidebar.menu[group];
            }
          }
        }
        return grouped;
      });
  
      const hasPermission = (item) => {
        if (item.to === 'home' && user) {
          return true;
        }
        // Verifica se o item tem permissão de acesso
        if (user?.email === import.meta.env.VITE_APP_USER_EMAIL_ADMIN && item.can === null) {
          return true; // Se a permissão for nula, todos têm acesso
        }
  
        // Se o usuário tiver acesso geral como administrador, retorne true
        if (user?.email === import.meta.env.VITE_APP_USER_EMAIL_ADMIN) {
          return true;
        }
        
        // return user?.permissions.includes(item.can);
        return user?.permissions.some(permission => permission.name === item.can);
      };
  
      const shouldRenderGroup = (group) => {
        if (group.can === 'super-admin') {
          // Verifica se o usuário é super-admin para renderizar o grupo de Controle de Acesso
          return user?.roles.some(role => role?.name === 'super-admin');
        } else {
          // Verifica se o usuário tem a permissão específica para acessar o grupo
          // return user?.permissions.includes(group.can);
          return user?.permissions.some(permission => permission.name === group.can);
        }
      };
  
      return {
        user,
        // logout,
        groupedSidebar,
        isRouteActive,
        toggleDropdown,
        isDropdownOpen,
        hasPermission,
        shouldRenderGroup
      };
    },
  };
  </script>