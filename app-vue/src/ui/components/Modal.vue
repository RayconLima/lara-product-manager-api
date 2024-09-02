<template>
    <div>
      <DynamicButton @click="toggleModal" :color="buttonColor">
        {{ title }}
      </DynamicButton>
  
      <transition name="modal" v-if="isModalVisible">
        <div
          class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-full p-4 overflow-x-hidden overflow-y-auto">
          <div class="relative w-full max-w-2xl">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                  {{ title }}
                </h3>
                <button @click="hideModal"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                  <i class="fa-solid fa-xmark text-red-500"></i>
                </button>
              </div>
              <!-- Modal body -->
              <div class="p-6 space-y-6 overflow-y-auto max-h-96">
                <slot />
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button @click="acceptFunction" type="button"
                  class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Salvar
                </button>
                <button @click="hideModal" type="button"
                  class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                  Fechar
                </button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import DynamicButton from './DynamicButton.vue'
import { string } from 'yup';
  export default {
    name: "Modal",
    components: {
      DynamicButton
    },
    props: {
      title: String,
      buttonColor: {
        type: string,
        default: "bg-blue-500"
      },
      acceptFunction: Function,
    },
    emits: ['close-modal'],
    setup() {
      const isModalVisible = ref(false);
  
      const toggleModal = () => {
        isModalVisible.value = !isModalVisible.value;
      }
  
      const hideModal = () => {
        isModalVisible.value = false;
      }
  
      return {
        isModalVisible,
        toggleModal,
        hideModal
      }
    }
  };
  </script>
  
  <style>
  .modal-enter-active,
  .modal-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    opacity: 0;
  }</style>./DynamicButton.vue