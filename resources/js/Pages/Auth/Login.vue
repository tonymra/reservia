<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {  Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <Link href="/">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Reservia" />
            </Link>
            <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12">
                <BreezeValidationErrors class="mb-4" />

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>

                <form  @submit.prevent="submit" class="space-y-6">
                    <div>
                        <BreezeLabel for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address </BreezeLabel>
                        <div class="mt-2">
                            <BreezeInput id="email" v-model="form.email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div>
                        <BreezeLabel for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</BreezeLabel>
                        <div class="mt-2">
                            <BreezeInput id="password" v-model="form.password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <BreezeCheckbox name="remember" v-model:checked="form.remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label for="remember" class="ml-3 block text-sm leading-6 text-gray-900">Remember me</label>
                        </div>

                        <div class="text-sm leading-6">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</Link>
                        </div>
                    </div>

                    <div>
                        <BreezeButton  class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</BreezeButton>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>
