<template>
    <Head title="Create Reservation" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Create Reservation
            </h2>
        </template>

        <div class="py-12">



            <div class="space-y-10 divide-y divide-gray-900/10">
                <!-- Add Reservation Form -->
                <div class="flex justify-center">
                    <form class="space-y-6 bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl w-full lg:max-w-7xl" @submit.prevent="submitForm">

                    <div class="px-4 py-6 sm:p-8 lg:p-12">

                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-x-6 gap-y-8">

                            <!-- First Name -->
                            <div class="sm:col-span-3">
                                <label for="firstname" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                                <input type="text" v-model="form.firstname" name="firstname" id="firstname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.firstname" v-text="form.errors.firstname" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Last Name -->
                            <div class="sm:col-span-3">
                                <label for="lastname" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                                <input type="text" v-model="form.lastname" name="lastname" id="lastname" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.lastname" v-text="form.errors.lastname" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Phone -->
                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone</label>
                                <input type="text" v-model="form.phone" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.phone" v-text="form.errors.phone" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Email -->
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                <input type="email" v-model="form.email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
                            </div>


                            <!-- Address -->
                            <div class="sm:col-span-6">
                                <label for="address" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
                                <input type="text" v-model="form.address" name="address" id="address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.address" v-text="form.errors.address" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Province -->
                            <div class="sm:col-span-2">
                                <label for="state" class="block text-sm font-medium leading-6 text-gray-900">Province</label>
                                <select id="state" v-model="form.state" name="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option disabled value="">Please select a province</option>
                                    <option value="Eastern Cape">Eastern Cape</option>
                                    <option value="Free State">Free State</option>
                                    <option value="Gauteng">Gauteng</option>
                                    <option value="KwaZulu-Natal">KwaZulu-Natal</option>
                                    <option value="Limpopo">Limpopo</option>
                                    <option value="Mpumalanga">Mpumalanga</option>
                                    <option value="Northern Cape">Northern Cape</option>
                                    <option value="North West">North West</option>
                                    <option value="Western Cape">Western Cape</option>
                                </select>
                                <div v-if="form.errors.state" v-text="form.errors.state" class="text-red-500 text-xs mt-1"></div>
                            </div>


                            <!-- State -->
                            <div class="sm:col-span-2">
                                <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                                <input type="text" v-model="form.city" name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.city" v-text="form.errors.city" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Zip Code -->
                            <div class="sm:col-span-2">
                                <label for="zipcode" class="block text-sm font-medium leading-6 text-gray-900">Zip Code</label>
                                <input type="text" v-model="form.zipcode" name="zipcode" id="zipcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <div v-if="form.errors.zipcode" v-text="form.errors.zipcode" class="text-red-500 text-xs mt-1"></div>
                            </div>


                            <!-- Adults -->
                            <div class="sm:col-span-3">
                                <label for="adults" class="block text-sm font-medium leading-6 text-gray-900">Adults</label>
                                <input type="number" v-model="form.adults" name="adults" id="adults" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0">
                                <div v-if="form.errors.adults" v-text="form.errors.adults" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Children -->
                            <div class="sm:col-span-3">
                                <label for="children" class="block text-sm font-medium leading-6 text-gray-900">Children</label>
                                <input type="number" v-model="form.children" name="children" id="children" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0">
                                <div v-if="form.errors.children" v-text="form.errors.children" class="text-red-500 text-xs mt-1"></div>
                            </div>


                            <!-- Check-in Date -->
                                <div class="sm:col-span-3">
                                    <label for="check_in" class="block text-sm font-medium leading-6 text-gray-900">Check-in Date</label>
                                    <input type="date" v-model="form.check_in" name="check_in" id="check_in" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.check_in" v-text="form.errors.check_in" class="text-red-500 text-xs mt-1"></div>
                                </div>

                                <!-- Check-out Date -->
                                <div class="sm:col-span-3">
                                    <label for="check_out" class="block text-sm font-medium leading-6 text-gray-900">Check-out Date</label>
                                    <input type="date" v-model="form.check_out" name="check_out" id="check_out" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <div v-if="form.errors.check_out" v-text="form.errors.check_out" class="text-red-500 text-xs mt-1"></div>
                                </div>

                            <!-- Room Selection -->
                            <div class="sm:col-span-3">
                                <label for="room_id" class="block text-sm font-medium leading-6 text-gray-900">Room</label>
                                <select id="room_id" v-model="form.room_id" name="room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option disabled value="">Please select a room</option>
                                    <option v-for="room in rooms" :key="room.id" :value="room.id">{{ room.room_number }} {{ room.room_type }}</option>
                                </select>
                                <div v-if="form.errors.room_id" v-text="form.errors.room_id" class="text-red-500 text-xs mt-1"></div>
                            </div>

                            <!-- Shuttle Service -->
                            <div class="sm:col-span-3">
                                <label for="shuttle" class="flex items-center">
                                    <input type="checkbox" v-model="form.shuttle" name="shuttle" id="shuttle" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    Shuttle Service
                                </label>
                            </div>

                            <!-- Parking -->
                            <div class="sm:col-span-3">
                                <label for="parking" class="flex items-center">
                                    <input type="checkbox" v-model="form.parking" name="parking" id="parking" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    Parking
                                </label>
                            </div>

                            <!-- Breakfast -->
                            <div class="sm:col-span-3">
                                <label for="breakfast" class="flex items-center">
                                    <input type="checkbox" v-model="form.breakfast" name="breakfast" id="breakfast" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    Breakfast
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="sm:col-span-12">
                                <label for="notes" class="block text-sm font-medium leading-6 text-gray-900">Notes</label>
                                <textarea id="notes" v-model="form.notes" name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                            </div>


                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                            <Link :href="route('reservations.index')"><button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button></Link>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Reservation</button>
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
const props = defineProps({
    rooms: Array,
});

// Define the initial form state
const form = useForm({
    room_id: '',
    price: '',
    description: '',
    adults: 0,
    children: 0,
    status: '',
    notes: '',
    check_in: '',
    check_out: '',
    firstname: '',
    lastname: '',
    phone: '',
    email: '',
    address: '',
    city: '',
    state: '',
    zipcode: '',
    shuttle: false,
    parking: false,
    breakfast: false
});

// Function to handle form submission
const submitForm = () => {
    console.log('Submitting form', form);
    form.post(route('reservations.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>

