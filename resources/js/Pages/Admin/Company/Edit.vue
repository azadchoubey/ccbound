<script setup>
import SectionBorder from "@/Components/SectionBorder.vue";
import UpdateCompanyInformationForm from "./Partials/UpdateCompanyInformationForm.vue";
import AdminLayout from "../../../Layouts/AdminLayout.vue";

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <AdminLayout title="Edit ">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
    </template>

    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
          <UpdateCompanyInformationForm :user="$page.props.user" />

          <SectionBorder />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
