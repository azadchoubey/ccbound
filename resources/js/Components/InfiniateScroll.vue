<script setup>
import { onMounted } from 'vue';

const emit = defineEmits(['loadMore'])

onMounted(() => {
    window.addEventListener('scroll', _.debounce((e) => {
        let pixelsFromBottom = document.documentElement.offsetHeight - document.documentElement.scrollTop - window.innerHeight
        if (pixelsFromBottom < 200) {
            emit('loadMore')
        }
    }, 100))
})
</script>
<template>
    <div>
        <slot></slot>
    </div>
</template>