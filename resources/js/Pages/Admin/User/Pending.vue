<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import TableRow from "./Partials/PendingTableRow.vue";
defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <AdminLayout title="Pending">
    <div class="px-[1rem]">
      <div class="w-full py-2">
        <InputLabel for="search" value="Search" />
        <TextInput type="text" class="w-full" />
      </div>
      <div class="bg-white rounded-md shadow overfl">
        <table class="w-full whitespace-nowrap">
          <thead>
            <tr class="text-left font-bold">
              <th class="pb-4 pt-6 px-6">Date</th>
              <th class="pb-4 pt-6 px-6">Name</th>
              <th class="pb-4 pt-6 px-6">Email</th>
              <th class="pb-4 pt-6 px-6">Number</th>
              <th class="pb-4 pt-6 px-6">Activation Status</th>
              <th class="pb-4 pt-6 px-6 flex justify-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <TableRow v-for="n in 10" />
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
