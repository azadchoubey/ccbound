<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
const props = defineProps({
    users: Object,
})

</script>

<template>
    <AppLayout title="Contacts">
        <div class="px-2">
            <p></p>
            <div class="mt-2">
                <!-- component -->
                <section class="container mx-auto font-mono">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-white uppercase border-b border-gray-600">
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Company</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr v-for="user in users" class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        :src="user.profile_photo_url"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-black">{{ user.name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm border">{{ user.company.name }}</td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">{{ user.company.status }} </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm border">{{ user.created_at.slice(0,10) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
