<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '../../Layouts/AppLayout.vue';
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
    users: Object,
});

const form = useForm({})

const updateRole = (user, role) => {
    form.post(route('user.updaterole', { user: user, role: role }), {
        onFinish: () => window.location.reload,
    });
};

const updateStatus = (user, status) => {
    axios.patch(route('user.update', { user: user, status: status, type: "update_status" }))
        .then(res => {
            window.location.reload();
        })
}
</script>

<template>
    <AppLayout title="Settings">
        <h1 class="mb-8 text-3xl font-bold">Users</h1>
        <div class="flex items-center justify-between mb-6">
            <Link class="btn-indigo" :href="route('user.create')">
            <span>Create</span>
            <span class="hidden md:inline">&nbsp;User</span>
            </Link>
        </div>
        <div class="bg-white rounded-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="pb-4 pt-6 px-6">Date</th>
                        <th class="pb-4 pt-6 px-6">Name</th>
                        <th class="pb-4 pt-6 px-6">Email</th>
                        <th class="pb-4 pt-6 px-6">Number</th>
                        <th class="pb-4 pt-6 px-6 text-center" colspan="4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.data" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4 focus:text-indigo-500">{{ user.created_at.slice(0, 10) }}
                            </p>
                        </td>
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4 focus:text-indigo-500">{{ user.name }}</p>
                        </td>
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4" tabindex="-1">{{ user.email }}</p>
                        </td>
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4" tabindex="-1">{{ user.number }}</p>
                        </td>
                        <td class="border-t">
                            <a :href="route('profile.display', { id: user.id })" target="_blank"
                                class="flex items-center px-4 hover:underline text-blue-600" tabindex="-1">View</a>
                        </td>
                        <td class="border-t">
                            <Link :href="route('user.edit', { user: user.id })"
                                class="flex items-center px-4 hover:underline text-green-600" tabindex="-1">Edit</Link>
                        </td>
                        <td class="border-t space-x-2">
                            <button v-if="user.active === 0" @click="updateStatus(user, 1)"
                                class="text-green-600">Activate</button>
                            <button v-if="user.active === 1" @click="updateStatus(user, 0)"
                                class="text-red-600">Deactivate</button>
                        </td>
                        <!-- <td class="border-t">
                            <Link class="flex items-center px-4 hover:underline text-red-600" tabindex="-1">Delete</Link>
                        </td> -->
                        <td class="border-t">
                            <button v-if="user.role === 'user'" @click="updateRole(user, 'admin')"
                                class="flex items-center px-4 hover:underline text-blue-600" tabindex="-1">Make
                                Admin</button>
                            <button v-if="user.role === 'admin'" @click="updateRole(user, 'user')"
                                class="flex items-center px-4 hover:underline text-blue-600" tabindex="-1">Make
                                User</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- <pagination class="mt-6" :links="organizations.links" /> -->
    </AppLayout>
</template>
