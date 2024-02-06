<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Room
            </h2>
        </template>

        <div class="py-12">



            <div class="space-y-10 divide-y divide-gray-900/10">
                <!-- Add Room Form -->
                <div class="flex justify-center">
                    <form  class="space-y-6 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl w-full max-w-4xl" @submit.prevent="submitForm">
                        <div class="px-4 py-6 sm:p-8">
                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <!-- Room Number -->
                                <div class="sm:col-span-4">
                                    <label for="room_number" class="block text-sm font-medium leading-6 text-gray-900">Room Number</label>
                                    <input type="text"  v-model="form.room_number" name="room_number" id="room_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.room_number" v-text="form.errors.room_number" class="text-red-500 text-xs mt-1"></div>
                                </div>

                                <!-- Room Type -->
                                <div class="sm:col-span-4">
                                    <label for="room_type" class="block text-sm font-medium leading-6 text-gray-900">Room Type</label>
                                    <select id="room_type"   v-model="form.room_type" name="room_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option>Please select...</option>
                                        <option>Single</option>
                                        <option>Double</option>
                                        <option>Suite</option>
                                    </select>
                                    <div v-if="form.errors.room_type" v-text="form.errors.room_type" class="text-red-500 text-xs mt-1"></div>
                                </div>

                                <!-- Price -->
                                <div class="sm:col-span-4">
                                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                    <input type="text"   v-model="form.price" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.price" v-text="form.errors.price" class="text-red-500 text-xs mt-1"></div>
                                </div>

                                <!-- Description -->
                                <div class="sm:col-span-12">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                    <textarea id="description"   v-model="form.description" name="description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 text-xs mt-1"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                            <Link :href="route('rooms.index')"><button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button></Link>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Room</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";

// Define the initial form state
const form = useForm({
    room_number: '',
    room_type: '',
    price: '',
    description: ''
});

// Function to handle form submission
const submitForm = () => {
    form.post(route('rooms.store'), {

      onSuccess: () => {
       form.reset('room_number', 'room_type', 'price', 'description');
         },
    });
};
</script>

