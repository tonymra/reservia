<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Reservations box -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Link :href="route('reservations.index')">
                            <div class="p-6 border-b border-gray-200 cursor-pointer">
                                <h3 class="text-lg font-semibold mb-2">Reservations</h3>
                                <p class="text-gray-600">View and manage reservations</p>
                            </div>
                        </Link>
                    </div>

                    <!-- Rooms box -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <Link :href="route('rooms.index')">
                            <div class="p-6 border-b border-gray-200 cursor-pointer">
                                <h3 class="text-lg font-semibold mb-2">Rooms</h3>
                                <p class="text-gray-600">View and manage rooms</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
