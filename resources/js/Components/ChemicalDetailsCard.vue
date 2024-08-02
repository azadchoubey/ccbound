<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from 'vue';
import BuildingIcon from '../Icons/BuildingIcon.vue';
import MapPinIcon from "../Icons/MapPinIcon.vue";
import UserIcon from '../Icons/UserIcon.vue';
import DialogModal from '@/Components/DialogModal.vue';
import ChatIcon from '../Icons/ChatIcon.vue';
import { formatDate } from '../Helpers/helpers';
defineProps({
    details: Object,
    id: String,
    link: String,
    doc_type: String
});

const readMore = ref(false);

const showImage = ref(false);

const isImage = (fileName) => {
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    const extension = fileName.split('.').pop().toLowerCase();
    return imageExtensions.includes(extension);
}

const isPDF = (fileName) => {
    const extension = fileName.split('.').pop().toLowerCase();
    return extension === 'pdf';
}

const isDocx = (fileName) => {
    const extension = fileName.split('.').pop().toLowerCase();
    return extension === 'docx';
}


</script>
<style scoped>
.pdf-container {
    width: 600px;
    height: 500px;
    overflow: hidden;
}

.pdf-container embed {
    width: 100%;
    height: 100%;
    border: none;
}
</style>
<template>
    <div class="w-full bg-white">
        <div class="px-2 pt-2">
            <div class="block">
                <div :class="`flex items-start justify-between gap-1`">
                    <div>
                        <Link :href="link" class="block text-lg font-bold">{{ details?.product_name }}</Link>
                        <span class="text-sm text-gray-400" v-if="details && details?.type">{{
                    details.type.toUpperCase() }}</span>
                        <span v-if="details.type && details.category"> | </span>
                        <span class="text-sm text-blue-400" v-if="details && details?.category">{{
                    details.category.toUpperCase() }}</span>
                        <Link :href="link" class="block mt-2 text-sm font-bold">
                        </Link>
                        <Link :href="link">{{ details?.cas_no }}</Link>
                        <p v-if="!readMore && details?.description !== null" class="text-sm">
                            <Link :href="link">{{ details.description.slice(0, 100) }}...</Link> <span v-if="!readMore"
                                @click="readMore = !readMore" class="font-semibold cursor-pointer">..read more</span>
                        </p>
                        <p v-if="readMore && details.description !== null" class="text-sm">
                            <Link :href="link"> {{ details.description }} </Link> <span v-if="readMore"
                                @click="readMore = !readMore" class="font-semibold cursor-pointer">..read less</span>
                        </p>
                    </div>
                    <a :href="details.docs_url" target="_blank" v-if="details.docs" class="mt-10 mb-2">
                        <img :src="details.docs_url" width="80" height="90" v-if="isImage(details.docs)" class="mr-5" />
                        <div v-else-if="isPDF(details.docs)">
                            <embed :src="details.docs_url" width="80" height="90" type="application/pdf" class="mr-5" />
                            <span class="text-blue-400">Preview</span>
                        </div>
                        <img :src="'/assests/images/docfile.png'" width="50" height="70" class="mt-10 mr-5"
                            v-else-if="isDocx(details.docs)" />

                        <!-- <p>{{ details.docs }}</p> -->

                    </a>
                    <img @click="showImage = !showImage" :src="details.structure_url"
                        class="h-[7rem] w-[7rem] md:w-[10rem] md:h-[10rem]" alt="">
                </div>
            </div>
            <div v-if="details.quantity_required && details.purity_required"
                class="grid grid-cols-2 border-t border-gray-200">
                <div v-if="details.quantity_required" class="flex flex-col items-center">
                    <p class="text-sm"><span class="font-bold">Quantity</span>: {{ details.quantity_required }} </p>
                </div>
                <div v-if="details.purity_required" class="flex flex-col items-center">
                    <p class="text-sm"><span class="font-bold">Purity</span>: {{ details.purity_required }} </p>
                </div>
            </div>
            <p class="text-sm">{{ formatDate(details.updated_at.slice(0, 10)) }}</p>
        </div>
        <div class="p-2 flex justify-between px-[1rem]" v-if="details.user.company.id != id">
            <Link :href="link" class="flex">
            <div class="flex items-center px-8 py-1 text-white bg-blue-600 rounded-xl">
                <!-- <ChatIcon :classname="'w-10 h-10'" class="text-blue-400 " /> -->
                <p>
                    Chat
                </p>
            </div>
            </Link>
            <div class="flex">
                <UserIcon class="text-orange-400" />
                <p>
                    <Link :href="route('profile.display', { id: details.user.id ? details.user.id : 0 })"
                        class="text-sm">
                    {{ details.user.name ? details.user.name : '' }}
                    </Link>
                </p>
            </div>

            <div class="flex">
                <BuildingIcon class="text-yellow-900" />
                <p>
                    <Link :href="route('company.show', { id: details.user.company.id })" class="text-sm">{{
                    details.user.company.name }}</Link>
                </p>
            </div>
            <p>
            <div class="flex items-center">
                <MapPinIcon class="text-green-600" />
                <p class="text-sm">{{ details.location }}</p>
            </div>
            </p>
        </div>
    </div>

    <DialogModal :show="showImage" @close="showImage = !showImage">
        <template #content>
            <div class="flex justify-center w-full mt-4">
                <img :src="details.structure_url" alt="">
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="showImage = !showImage">
                Ok
            </SecondaryButton>
            <SecondaryButton @click="showImage = !showImage">
                Cancel
            </SecondaryButton>
        </template>
    </DialogModal>
</template>
