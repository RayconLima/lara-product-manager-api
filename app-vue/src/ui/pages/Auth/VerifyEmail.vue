<template>
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
        <h1 class="text-xl text-center font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Verificar email
        </h1>
        <h3 v-if="isLoading"
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Verificando....
        </h3>

        <div v-else-if="!isReady" class="dark:text-red-500 text-center">
            Ops! Parece que esse token está inválido!
        </div>

        <h3 v-else class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Email Verificado
            Obrigado, {{ state.data.name }} por verificar seu email!
        </h3>
    </div>
</template>
<script setup>
import { useRoute } from 'vue-router';
import AuthService from '../../../infra/services/auth.service';
import { useAsyncState } from '@vueuse/core';
const route = useRoute()
const token = route.query.token

const { state, isReady, isLoading } = useAsyncState(
    AuthService.verifyEmailfromToken(token)
)
</script>