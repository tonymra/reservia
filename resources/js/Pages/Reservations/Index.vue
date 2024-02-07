<template>
    <Head title="Reservations" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Reservations
            </h2>
        </template>

        <div class="py-12">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Success Message -->
                <div v-if="showSuccessMessage" class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                    {{ successMessage }}
                </div>

                <div class="sm:flex sm:items-center">

                    <div class="sm:flex-auto">
                        <input v-model="search" @input="searchReservations" type="text" placeholder="Search reservations..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                    </div>

                    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <Link :href="route('reservations.create')" class="inline-block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Add reservation
                        </Link>
                    </div>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-800 text-white">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Reference</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Guest Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold white">Check In</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold white">Check Out</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold white">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="reservation in props.reservations.data" :key="reservation.id">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ reservation.reference }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ reservation.firstname }} {{ reservation.lastname }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ reservation.check_in }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ reservation.check_out }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ reservation.status }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link :href="route('reservations.edit', reservation.id)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</Link>
                                            <button @click="confirmDelete(reservation.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="props.reservations.links && props.reservations.links.length > 1" class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ props.reservations.from }}</span>
                                to
                                <span class="font-medium">{{ props.reservations.to }}</span>
                                of
                                <span class="font-medium">{{ props.reservations.total }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                <Link v-for="link in props.reservations.links" :key="link.label" :href="link.url" :class="[link.active ? 'z-10 bg-indigo-600 text-white' : 'text-gray-900', 'relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0']" v-html="link.label"></Link>
                            </nav>
                        </div>
                    </div>
                </div>


            </div>


        </div>

    </BreezeAuthenticatedLayout>


</template>


<script setup>
import {ref, watchEffect} from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {Head,Link,  usePage} from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";


const page = usePage();
const { flash } = usePage().props.value;
const props = usePage().props;

const search = ref('');

const searchReservations = () => {
    Inertia.get(route('reservations.index', { search: search.value }), {}, {
        preserveState: true,
        replace: true,
        preserveScroll: true,
    });
};

// Reactive state for showing the success message
const showSuccessMessage = ref(false);
const successMessage = ref('');


watchEffect(() => {
    successMessage.value = page.props.value.flash?.success || '';
});
const confirmDelete = (reservationId) => {
    if (confirm('Are you sure you want to delete this reservation?')) {
        Inertia.delete(route('reservations.destroy', reservationId), {
            onSuccess: () => {
                successMessage.value = 'Reservation deleted successfully.';
                showSuccessMessage.value = true;
                // Optionally reset the message after a delay
                setTimeout(() => {
                    showSuccessMessage.value = false;
                }, 3000); // Hide after 3 seconds
            }
        });
    }
};


console.log("Reservations Index" + props.reservations);

</script>
