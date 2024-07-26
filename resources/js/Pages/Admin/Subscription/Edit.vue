<script setup>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
  subscription: Object,
});

const form = useForm({
  price: props.subscription.price,
  months: props.subscription.months,
  days: props.subscription.days,
})

const submit = () => {
  form.patch(route('admin.subscription.update', { subscription: props.subscription }));
};
</script>
]
<template>
  <AdminLayout title="Edit">
    <div class="px-[2rem]">
      <div class="bg-white p-[2rem] mt-2 max-w-[45rem]">
        <p class="text-xl font-bold">Add admin</p>
        <form @submit.prevent="submit">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <InputLabel for="price" value="Price" />
              <TextInput id="price" type="number" class="mt-1 block w-full" v-model="form.price" required autofocus />
              <InputError class="mt-2" :message="form.errors.price" />
            </div>
            <div>
              <InputLabel for="duration_months" value="Duration(Months)" />
              <TextInput id="duration_months" type="number" class="mt-1 block w-full" v-model="form.months" required />
              <InputError class="mt-2" :message="form.errors.months" />
            </div>
            <div>
              <InputLabel for="duration_days" value="Duration Days" />
              <TextInput id="duration_months" type="number" class="mt-1 block w-full" v-model="form.days" required />
              <InputError class="mt-2" :message="form.errors.days" />
            </div>
          </div>
          <PrimaryButton class="mt-2"> Update </PrimaryButton>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
