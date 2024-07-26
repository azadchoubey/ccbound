<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import ArrowLeftIcon from '../Icons/ArrowLeftIcon.vue';
import TextInput from '../components/TextInput.vue';

const props = defineProps({
    contacts: Object,
})

const type = ref('user');
const search = ref('')


const filtered = computed(() => {
    if (search.value !== '') {
        if (type.value === 'user') {
            return props.contacts.filter((item) => {
                return search.value.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
            })
        } else if (type.value === 'company') {
            return props.contacts.filter((item) => {
                return search.value.toLowerCase().split(' ').every(v => item.company.name.toLowerCase().includes(v))
            })
        }
    } else {
        return props.contacts;
    }
})


</script>

<template>
    <AppLayout title="Contacts">
        <div class="lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]">
            <Link :href="route('settings')">
            <ArrowLeftIcon />
            </Link>
        </div>
        <div class="px-2">
            <div class="bg-white mt-2 p-2">
                <div class="flex gap-2">
                    <select v-model="type" class="rounded-lg">
                        <option value="user">User</option>
                        <option value="company">Company</option>
                    </select>
                    <TextInput type="text" class="flex-1" v-model="search" :placeholder="`Search ${type}`" />
                </div>
            </div>

            <div class="mt-2">
                <div v-for="contact in filtered" class="bg-white p-2 mt-2">
                    <div class="flex items-center gap-2">
                        <img :src="contact.profile_photo_url" alt="" class="h-[5rem]">
                        <div>
                            <Link :href="route('profile.display', { id: contact.id })" class="block text-xl font-bold">{{
                                contact.name }}</Link>
                            <div class="flex items-center gap-2">
                                <Link :href="route('company.show', { id: contact.company.id })" class="text-sm">{{
                                    contact.company.name }}</Link>
                                <p>{{ contact.email }}</p>
                                <p>{{ contact.number }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
