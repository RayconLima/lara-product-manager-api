<template>
  <button
    @click="onClick"
    :class="buttonClasses"
    class="px-2 py-1 font-bold text-white rounded hover">
    <slot></slot>
  </button>
</template>

<script>
import { computed } from 'vue';

export default {
  name: 'DynamicButton',
  props: {
    color: {
      type: String,
      default: 'bg-blue-500',
    },
    hoverColor: {
      type: String,
      default: 'bg-blue-500',
    },
    ringColor: {
      type: String,
      default: 'ring-blue-500',
    },
    onClick: {
      type: Function,
      default: () => {}
    }
  },
  setup(props) {
    const buttonClasses = computed(() => {
      return [
        `${props.color}`,
        `hover:${props.color}`,
        `focus:${props.color}`
      ];
    });

    return {
      buttonClasses
    };
  }
};
</script>
