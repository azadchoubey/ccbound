<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <AdminLayout title="Edit">
    <div class="px-[2rem]">
      <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
        <p class="text-xl font-bold">Add Upload Pack</p>
        <form>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="pack_code" value="Pack code (Optional)" />
              <TextInput id="name" type="text" class="mt-1 block w-full" autofocus />
              <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
            </div>
            <div>
              <InputLabel for="price" value="Price" />
              <TextInput id="price" type="number" class="mt-1 block w-full" required />
              <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
            </div>
            <div>
              <InputLabel for="products" value="Products" />
              <TextInput id="products" type="number" class="mt-1 block w-full" required />
              <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
            </div>
          </div>
          <PrimaryButton class="mt-2"> Edit Pack </PrimaryButton>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
