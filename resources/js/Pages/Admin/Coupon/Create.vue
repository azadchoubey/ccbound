<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";
defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});

const form = useForm({
  discount: null,
})

const submit = () => {
  form.post(route('admin.coupon.store'))
}
</script>

<template>
  <AdminLayout title="Create">
    <div class="px-[2rem]">
      <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
        <p class="text-xl font-bold">Add Coupon</p>
        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="discount" value="Discount" />
              <TextInput id="discount" type="number" class="mt-1 block w-full" v-model="form.discount" min="1" step="0.1"
                required autofocus />
              <InputError class="mt-2" :message="form.errors.discount" />
            </div>
          </div>
          <PrimaryButton class="mt-2"> Add Coupon </PrimaryButton>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
