<template>
  <nav aria-label="Page navigation example">
    <ul class="inline-flex -space-x-px text-sm">
      <li v-if="meta?.current_page > 1" class="page-number" @click.prevent="changePage(meta?.current_page - 1)">
        <router-link :to="{ name: routeName, query: { page: meta?.current_page - 1 } }" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</router-link>
      </li>
      <li v-for="(page, index) in pagesArray" :key="index" @click.prevent="changePage(page)">
        <router-link :to="{ name: routeName, query: { page: page } }" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            {{ page }}
        </router-link>
      </li>
      <li v-if="meta?.current_page < meta?.last_page" class="page-number" @click.prevent="changePage(meta?.current_page + 1)">
        <router-link :to="{ name: routeName, query: { page: meta?.current_page + 1 } }" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white">Next</router-link>
      </li>
    </ul>
  </nav>
</template>

<script>
import { computed, ref, watch } from 'vue';
export default {
  name: 'Pagination',
  props: {
    routeName: {
      type: String,
      default: 'home',
      required: true,
    },
    pagination: {
      type: Object,
      required: true,
      default: () => ({
        data: [],
        links: {
          first: '',
          last: '',
          next: '',
          prev: '',
        },
        meta: {
          current_page: 1,
          from: 1,
          last_page: 1,
          links: [],
          path: '',
          per_page: 0,
          to: 0,
          total: 0,
        },
      }),
    },
  },
  setup(props, { emit }) {
    const changePage = (page) => emit('changePage', page);

    const pagesArray = ref([]);

    watch(() => props?.pagination?.meta, () => {
      pagesArray.value = [];
      for (let page = 1; page <= props?.pagination?.meta?.last_page; page++) {
        pagesArray.value.push(page);
      }
    });
    
    const routeName = computed(() => props.routeName);
    const meta = computed(() => props.pagination.meta);

    return {
      changePage,
      pagesArray,
      routeName,
      meta,
    };
  },
};
</script>
