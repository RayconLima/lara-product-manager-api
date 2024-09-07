<template>
    <h1
        class="text-xl font-bold text-center leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Nova Senha
    </h1>

    <form class="space-y-4 md:space-y-6" @submit.stop.prevent="submit">
        <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Nova senha
            </label>
            <input type="text" id="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                :class="[
                    'bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                    { 'focus:border-blue border-2 dark:border-red-500': errors.password }
                ]" placeholder="********" v-model="password"
                :error-messages="errors.password">
            <span class="text-red-500" v-if="!!errors">{{ errors.password }}</span>
        </div>
        <button type="submit"
            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">

            <div v-if="isSubmitting" class="flex items-center justify-center">
                <Spinner />
                <span class="ml-2">Salvando....</span>
            </div>

            <span>Salvar</span>
        </button>
    </form>
</template>
<script>
import { object, string } from 'yup';
import { useRouter } from "vue-router";
import { useField, useForm } from 'vee-validate';
import { notify } from "@kyvg/vue3-notification";
import Spinner from '../../../components/Spinner.vue';
import AuthService from '../../../../infra/services/auth.service';

export default {
    props: {
        token: {
            type: String,
            default: ''
        }
    },
    setup(props) {
        const router = useRouter();
        const schema = object({
            password: string().required().min(6).label('Senha'),
        })

        const {
            handleSubmit,
            errors,
            isSubmitting
        } = useForm({
            validationSchema: schema,
            initialValues: {
                token   : props.token || '',
                password: '',
            }
        });

        const submit = handleSubmit(async (values) => {
            try {
                await AuthService.resetPassword({token: values.token, password: values.password})
                    .then(() => {
                        notify({
                            title: "Deu certo!",
                            type: "success",
                        });
                    })
                    .finally(() => {
                        router.push({ name: "login" })
                    })
            } catch (e) {
                notify({
                    title: "Falha ao autenticar",
                    text: 'Falha na requisição',
                    type: "warn",
                });
            }
        });

        const { value: password } = useField('password')

        return {
            password,
            submit,
            errors,
            isSubmitting
        }
    }
}
</script>