<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rooms
            </h2>
        </template>

        <div class="py-12">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <SuccessMessage :message="flash.success" />
                    <div class="sm:flex-auto">

                    </div>
                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <Link :href="route('rooms.create')" class="inline-block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Add room
                        </Link>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Room Number</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Room Type</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="room in props.rooms.data" :key="room.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ room.room_number }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ room.price }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ room.room_type }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link :href="route('rooms.edit', room.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                                            <button @click="confirmDelete(room.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
    <Pagination :links="props.rooms.links" />
</template>


<script setup>
import { ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head,Link,  usePage} from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import SuccessMessage from "@/Components/Shared/SuccessMessage.vue";
import {Inertia} from "@inertiajs/inertia";


const page = usePage();
const flash = page.props.value.flash || {};
const props = usePage().props;

const confirmDelete = (roomId) => {
    if (confirm('Are you sure you want to delete this room?')) {
        Inertia.delete(route('rooms.destroy', roomId), {
            onSuccess: () => {
                // Optionally, you can add success handling here, such as showing a success message
            }
        });
    }
};

console.log("Flash log: " + JSON.stringify(flash, null, 2));
// Log the rooms to see the structure
console.log("Rooms" + props.rooms);

// Since props is reactive, you can directly use props.rooms in your template
// No need to wrap it with ref() unless you're manipulating it
</script>
