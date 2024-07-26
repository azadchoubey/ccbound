<script setup>
import ToastListItem from '@/Components/ToastListItem.vue';
import toast from '@/Stores/Toast';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/inertia-vue3';
import { onUnmounted } from "vue";

const page = usePage();
let removeFinishEventListener = Inertia.on('finish', () => {
    if (page.props.value.toast) {
        toast.add({
            message: page.props.value.toast
        })
    }
})

onUnmounted(() => { removeFinishEventListener() })

const remove = (index) => {
    toast.remove(index, 1)
}
</script>

<template>
    <div class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs">
        <ToastListItem v-for="(item, index) in toast.items" :key="item.key" :message="item.message"
            @remove="remove(index)" />
    </div>
</template>