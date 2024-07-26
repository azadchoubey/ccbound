<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  coupon: Object,
});

const form = useForm({
  discount: props.coupon.discount
})

const submit = () => {
  form.patch(route('admin.coupon.update', { coupon: props.coupon }))
}
</script>

<template>
  <AdminLayout title="Edit">
    <div class="px-[2rem]">
      <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
        <p class="text-xl font-bold">Add Coupon</p>
        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="percentage" value="Discount" />
              <TextInput id="percentage" type="number" class="mt-1 block w-full" v-model="form.discount" min="1"
                step="0.1" required autofocus />
              <InputError class="mt-2" :message="form.errors.discount" />
            </div>
          </div>
          <PrimaryButton class="mt-2"> update </PrimaryButton>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
