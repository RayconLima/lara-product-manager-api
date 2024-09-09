<template>
    <a href="#" class="flex m-2 justify-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
        Flowbite
    </a>
    <div class="p-6 space-y-2 md:space-y-4 sm:p-8">
        <h1
            class="text-xl font-bold text-center leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Faça o seu cadastro
        </h1>

        <form class="space-y-4 md:space-y-6" @submit.stop.prevent="submit">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Seu nome
                </label>
                <input type="text" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="[
            'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            { 'focus:border-blue border-2 dark:border-red-500': errors.name }
        ]" placeholder="Fulano de tal" v-model="name" :error-messages="errors.name">
                <span class="text-red-500" v-if="!!errors">{{ errors.name }}</span>
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Seu email
                </label>
                <input type="email" id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    :class="[
            'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            { 'focus:border-blue border-2 dark:border-red-500': errors.email }
        ]" placeholder="name@company.com" v-model="email" :error-messages="errors.email">
                <span class="text-red-500" v-if="!!errors">{{ errors.email }}</span>
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Sua senha
                </label>
                <input type="password" id="password" v-model="password" :error-messages="errors.password"
                    placeholder="••••••••" :class="[
            'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
            { 'focus:border-blue border-2 dark:border-red-500': errors.password }
        ]">
                <span class="text-red-500" v-if="!!errors">{{ errors.password }}</span>
            </div>
            <button type="submit" :disabled="isSubmitting"
                class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">

                <div v-if="isSubmitting" class="flex items-center justify-center">
                    <Spinner :loading="isSubmitting" />
                    <span class="ml-2">Salvando....</span>
                </div>

                <span v-else>Salvar</span>

            </button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Tem conta?
                <router-link class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                    :to="{ name: 'login' }">Acesse o Login</router-link>
            </p>
        </form>
    </div>
</template>
<script>
import { object, string } from 'yup'
import { notify } from "@kyvg/vue3-notification";
import { useRouter, useRoute } from "vue-router";
import { useField, useForm } from 'vee-validate';
import Spinner from '../../components/Spinner.vue';
import { useAuthStore } from '../../../store/auth';

export default {
    components: {
        Spinner
    },
    setup() {
        const authStore         = useAuthStore();
        const router            = useRouter();
        const route             = useRoute();

        const schema    = object({
            name    : string().required().min(3).label('Nome Completo'),
            email   : string().required().email().label('E-mail'),
            password: string().required().min(8).matches(
                /^(?=.*[a-zA-Z])(?=.*[0-9])/,
                'Pelo menos uma letra e um número'
            ).label('Senha')
        })

        const { handleSubmit, errors, isSubmitting } = useForm({
            validationSchema: schema,
            initialValues   : {
                name    : '',
                email   : '',
                password: ''
            }
        })

        const submit = handleSubmit(async (values) => {
            try {
                await authStore.register({
                    name        : values.name,
                    email       : values.email,
                    password    : values.password
                });

                notify({
                    title   : "Deu certo!",
                    type    : "success",
                });
                
                router.push({ name: "login" });
            } catch (error) {
                let msgError = "Falha na requisição";
                notify({
                    title   : "Falha ao autenticar",
                    text    : msgError,
                    type    : "warn",
                });
            }
        })

        const { value: name }       = useField('name')
        const { value: email }      = useField('email')
        const { value: password }   = useField('password')

        return {
            name,
            email,
            password,
            errors,
            submit,
            isSubmitting
        }
    }
}
</script>