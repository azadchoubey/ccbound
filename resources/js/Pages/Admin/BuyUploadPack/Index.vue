<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import DialogModal from "../../../Components/DialogModal.vue";
import TextInput from "../../../components/TextInput.vue";
import InputLabel from "../../../components/InputLabel.vue";
import PrimaryButton from "../../../components/PrimaryButton.vue";
import SecondaryButton from "../../../components/SecondaryButton.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import axios from "axios";
defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  price: Object,
});

const updatePack = ref(false);

const newPrice = ref();

const update = () => {
  if (newPrice === null || newPrice.value === "" || newPrice.value === undefined) {
    return
  }
  axios.patch(route('admin.uploadpack.update', { price: newPrice.value }))
    .then(res => {
      window.location.reload();
    })
}
</script>

<template>
  <AdminLayout title="Buy Upload Pack">
    <div class="px-[2rem]">
      <div class="flex items-center justify-between mb-6">

        <Link class="mt-2 btn-indigo" :href="route('admin.uploadpack.showlist')">
        <span>Upload</span>
        <span class="hidden md:inline">&nbsp;Products</span>
        </Link>
      </div>
      <div class="inline-block p-2 bg-white rounded-md shadow">
        <p class="my-5"> <span class="font-bold ">Cost per product:</span> ₹ {{ price.price }}/-</p>
        <button @click="updatePack = true" class="p-2 mt-10 text-sm text-white bg-blue-600 rounded-lg">Update</button>
      </div>
    </div>
  </AdminLayout>

  <DialogModal :show="updatePack" @close="updatePack = false">
    <template #content>
      <div class="mt-4">
        <InputLabel for="update_pack" value="Update Pack" />
        <TextInput type="text" v-model="newPrice" />
      </div>
    </template>
    <template #footer>
      <SecondaryButton @click="updatePack = false">
        Ok
      </SecondaryButton>
      <SecondaryButton @click="updatePack = false">
        Cancel
      </SecondaryButton>

      <PrimaryButton @click="update" class="ml-4">
        Submit
      </PrimaryButton>
    </template>
  </DialogModal>
</template>
