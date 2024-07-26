
<script setup>
import EditIcon from '@/Icons/EditIcon.vue';
import EllipsisHorizontal from '@/Icons/EllipsisHorizontal.vue';
import EyeIcon from '@/Icons/EyeIcon.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { onMounted, onUnmounted, ref } from 'vue';
import DialogModal from '../../../../components/DialogModal.vue';
import SecondaryButton from '../../../../components/SecondaryButton.vue';

const props = defineProps({
    payout: Object,
})
const showDropDown = ref(false)
const showDetails = ref(false)
const closeOnEscape = (e) => {
    if (showDropDown.value && e.key === 'Escape') {
        showDropDown.value = false;
    }
};

const update = (status) => {
    axios.post(route('admin.payout.update', { payout: props.payout, status: status }))
        .then(res => {
            if (res.status === 200) {
                console.log(res.data)
                window.location.reload()
            }
        })
}


onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));
</script>
<template>
    <div v-show="showDropDown" class="fixed inset-0 z-40" @click="showDropDown = false" />
    <tr class="hover:bg-gray-100 focus-within:bg-gray-100">
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.created_at.slice(0, 10) }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.user.name }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.amount }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.bank }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.account_number }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">{{ payout.ifsc_code }}</p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
            <p class="px-2  rounded-xl">{{ payout.user.wallet.amount }}</p>
            </p>
        </td>
        <td class="border-t">
            <p class="flex items-center px-6 py-4 font-semibold">
            <p class="px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl">{{ payout.status }}</p>
            </p>
        </td>
        <td class="border-t relative flex flex-col justify-center items-center pt-2.5">
            <button @click="showDropDown = !showDropDown">
                <EllipsisHorizontal />
            </button>
            <div v-if="showDropDown"
                class="absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem] shadow-lg">
                <button @click="showDetails = true"
                    class="flex items-center gap-1 py-1 text-sm font-bold border-b border-gray-200 text-slate-900">
                    <EyeIcon class="h-[1rem]" />
                    <p>More Details</p>
                </button>
                <button @click="update('completed')" v-if="payout.status === 'pending'"
                    class="flex items-center gap-1 py-1 text-sm font-bold border-b border-gray-200 text-slate-900">
                    <EditIcon class="h-[0.8rem]" />
                    <p>Completed</p>
                </button>
                <button @click="update('rejected')" v-if="payout.status === 'pending'"
                    class="flex items-center gap-1 py-1 text-sm font-bold text-slate-900 ">
                    <EditIcon class="h-[0.8rem]" />
                    <p>Rejected</p>
                </button>
            </div>
        </td>
    </tr>
    <DialogModal :show="showDetails" @close="showDetails = false">
        <template #content>
            <div class="mt-4">
                <p class="mb-2">Payout Details</p>
                <div class="grid grid-cols-2 gap-2">
                    <div>Name: {{ payout.user.name }}</div>
                    <div>Bank: {{ payout.bank }}</div>
                    <div>Account Number: {{ payout.account_number }}</div>
                    <div>Account Branch: {{ payout.account_branch }}</div>
                    <div>IFSC Code: {{ payout.ifsc_code }}</div>
                    <div>GST Number: {{ payout.gst_number }}</div>
                    <div>PAN Number: {{ payout.pan_number }}</div>
                    <div>Aadhar Number: {{ payout.aadhar_number }}</div>
                </div>
            </div>
        </template>
        <template #footer>
            <SecondaryButton @click="showDetails = false">
                Ok
            </SecondaryButton>
            <SecondaryButton @click="showDetails = false">
                Close
            </SecondaryButton>
        </template>
    </DialogModal>
</template>