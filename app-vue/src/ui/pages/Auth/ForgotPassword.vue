<template>
    <a href="#" class="flex m-2 justify-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
        Flowbite
    </a>

    <div class="p-6 space-y-2 md:space-y-4 sm:p-8">
        <Forgot ref="forgot" v-if="state == 'forgotPassword'" @token-emitted="setToken" />
        <Reset v-else-if="state == 'resetPassword'" :token="token" />
        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
            Tem conta?
            <router-link class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                :to="{ name: 'login' }">Voltar para o Login</router-link>
        </p>
    </div>
</template>

<script>
import { ref } from "vue";
import Spinner from '../../components/Spinner.vue';
import Forgot from "./Partials/Forgot.vue";
import Reset from "./Partials/Reset.vue";

export default {
    name: "ForgotPassword",
    emits: ['token-emitted'],
    components: {
        Spinner,
        Forgot,
        Reset
    },
    props: {
        state: {
            type: String,
            default: 'forgotPassword'
        }
    },
    setup() {
        const state = ref('forgotPassword');
        const token = ref('');

        function setToken(newToken) {
            token.value = newToken;
            state.value = 'resetPassword';
        }

        return {
            state,
            token,
            setToken
        }
    }
}

</script>