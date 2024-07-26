<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, usePage } from '@inertiajs/inertia-vue3';
import ArrowLeftIcon from '../Icons/ArrowLeftIcon.vue';

const page = usePage();
const url = location.protocol+"//"+location.host+"/register?referrer="+page.props.value.user.id

const shareData = {
            title: "refer",
            url: location.protocol+"//"+location.host+"/register?referrer="+page.props.value.user.id
        };

const webShare = async () => {
    if (navigator.share) {
        try {
            await navigator.share(shareData);
        } catch (err) {
            console.log(err)
        }
    }
}

const copy = async () => {
    try {
      await navigator.clipboard.writeText(url);
      alert('Content copied to clipboard');
    } catch (err) {
      console.error('Failed to copy: ', err);
    }
  }
</script>

<template>
    <AppLayout title="Refer and Earn">
        <div class="lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]">
                <Link :href="route('settings')">
                    <ArrowLeftIcon />
                </Link>
            </div>
        <div class="px-2 bg-white py-[2rem] mt-2">
            <p class="w-full flex justify-center text-3xl font-bold">Refer & Earn</p>
            <div class="mt-2">
                <div class="w-full flex justify-center">
                    <img src="/assests/images/refer.jpg" class="md:h-[30rem]" alt="">
                </div>

                <div class="mt-2">
                    <p class="w-full text-2xl font-semibold flex justify-center text-center px-[4rem]">Invite your
                        friends and get 250 each</p>
                    <p class="mt-2 w-full text-gray-500 flex justify-center text-center px-[2rem]">Share the below link
                        and ask your friends use this link to signup. Earn when your friend signs up on our app.</p>
                </div>
    

                <div class="mt-10 flex justify-center">
                    <button @click="webShare" class="bg-green-400 w-full md:w-[30rem] py-3 rounded-lg text-white font-bold">Invite</button>
                </div>
                <div class="flex justify-center m-4">
                    <p>OR</p>
                </div>
                <div class="flex justify-center">
                    <button @click="copy" class="bg-green-400 w-full md:w-[30rem] py-3 rounded-lg text-white font-bold">Click to copy</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
