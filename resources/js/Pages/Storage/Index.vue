<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DocumentIcon from "../../Icons/DocumentIcon.vue";
import FolderIcon from "../../Icons/FolderIcon.vue";
import ImageIcon from "../../Icons/ImageIcon.vue";
import VideoIcon from "../../Icons/VideoIcon.vue";
</script>

<template>
    <AppLayout title="Storage">
        <div class="px-2">
            <div class="bg-[#4c6aed] rounded-xl px-4 py-6">
                <div class="flex justify-between text-white">
                    <div class="rounded-full bg-gradient-to-b from-white/60 to-transparent p-4">
                        <DocumentIcon class="h-10 w-10" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="font-semibold">Available Space</p>
                        <p>10GB used of 15GB</p>
                    </div>
                    <div>
                        <p class="text-sm bg-white/50 px-3 py-1 rounded-xl">137 files</p>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <p class="text-3xl font-bold">Categories</p>
                <div class="grid grid-cols-3 gap-4 mt-3">
                    <div class="bg-blue-400/10 py-4 flex flex-col items-center justify-center rounded-xl">
                        <FolderIcon class="h-10 w-10 text-cyan-400" />
                        <p class="text-sm">23 Documents</p>
                    </div>

                    <div class="bg-blue-400/10 py-4 flex flex-col items-center justify-center rounded-xl">
                        <ImageIcon class="h-10 w-10 text-purple-400" />
                        <p class="text-sm">23 Images</p>
                    </div>

                    <div class="bg-blue-400/10 py-4 flex flex-col items-center justify-center rounded-xl">
                        <VideoIcon class="h-10 w-10 text-cyan-400" />
                        <p class="text-sm">23 Vidoes</p>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <p class="text-3xl font-bold">Recent Files</p>
                <div v-for="n in 5" class="bg-blue-400/20 flex items-center gap-2 p-3 rounded-xl mt-2">
                    <ImageIcon class="h-10 w-10"/>
                    <p class="font-bold">whatimage12012023.jpg</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
