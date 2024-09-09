<template>
    <h1 class="text-xl font-bold text-center leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Esqueceu sua senha
    </h1>

    <form class="space-y-4 md:space-y-6" @submit.stop.prevent="submit">
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Insira seu email
            </label>
            <input type="email" id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :class="[
                    'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                    { 'focus:border-blue border-2 dark:border-red-500': errors.email }
                ]" placeholder="name@company.com" v-model="email" :error-messages="errors.email">
            <span class="text-red-500" v-if="!!errors">{{ errors.email }}</span>
        </div>
        <button type="submit" :disabled="isSubmitting"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">

            <div v-if="isSubmitting" class="flex items-center justify-center">
                <Spinner :loading="isSubmitting" />
                <span class="ml-2">Enviando....</span>
            </div>

            <span v-else>Enviar</span>
        </button>
    </form>
</template>
<script>
import { ref } from "vue";
import { object, string } from 'yup';
import { useField, useForm } from 'vee-validate';
import { notify } from "@kyvg/vue3-notification";
import Spinner from '../../../components/Spinner.vue';
import AuthService from '../../../../infra/services/auth.service';

export default {
    name: "ForgotPassword",
    components: {
        Spinner
    },
    emits: ['token-emitted'],
    setup(props, { emit }) {
        const token     = ref('');
        const schema    = object({
            email: string().required().email().label('E-mail'),
        })

        const {
            handleSubmit,
            errors,
            isSubmitting
        } = useForm({
            validationSchema: schema,
            initialValues: {
                email: '',
            }
        });

        const submit = handleSubmit(async (values) => {
            try {
                await AuthService.forgotPassword(values.email)
                    .then((resp) => {
                        notify({
                            title: "Deu certo!",
                            type: "success",
                        });

                        emit('token-emitted', resp.data.data.token);
                        token.value = resp.data.data.token
                    })
            } catch (e) {
                notify({
                    title: "Falha ao autenticar",
                    text: 'Falha na requisição',
                    type: "warn",
                });
            }
        });

        const { value: email } = useField('email')

        return {
            email,
            errors,
            isSubmitting,
            submit
        }
    }
}
</script>