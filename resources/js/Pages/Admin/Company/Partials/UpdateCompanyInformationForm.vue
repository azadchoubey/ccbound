<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
  user: Object,
});

const form = useForm({
  _method: "PUT",
  name: props.user.name,
  email: props.user.email,
  photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
  if (photoInput.value) {
    form.photo = photoInput.value.files[0];
  }

  form.post(route("user-profile-information.update"), {
    errorBag: "updateProfileInformation",
    preserveScroll: true,
    onSuccess: () => clearPhotoFileInput(),
  });
};

const sendEmailVerification = () => {
  verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
  photoInput.value.click();
};

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0];

  if (!photo) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};

const deletePhoto = () => {
  Inertia.delete(route("current-user-photo.destroy"), {
    preserveScroll: true,
    onSuccess: () => {
      photoPreview.value = null;
      clearPhotoFileInput();
    },
  });
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};
</script>

<template>
  <FormSection @submitted="updateProfileInformation">
    <template #title> Company Information </template>

    <template #description> Update your company's information. </template>

    <template #form>
      <!-- Profile Photo -->
      <div
        v-if="$page.props.jetstream.managesProfilePhotos"
        class="col-span-6 sm:col-span-4"
      >
        <!-- Profile Photo File Input -->
        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

        <InputLabel for="company_logo" value="Company Logo" />

        <!-- Current Profile Photo -->
        <div v-show="!photoPreview" class="mt-2">
          <img
            :src="`https://www.b2bresolute.com/wp-content/uploads/2020/12/logo-resize.png`"
            :alt="user.name"
            class="rounded-full h-[3rem] object-cover"
          />
        </div>

        <!-- New Profile Photo Preview -->
        <div v-show="photoPreview" class="mt-2">
          <span
            class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
            :style="'background-image: url(\'' + photoPreview + '\');'"
          />
        </div>

        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
          Select A New logo-resize
        </SecondaryButton>

        <SecondaryButton
          v-if="user.profile_photo_path"
          type="button"
          class="mt-2"
          @click.prevent="deletePhoto"
        >
          Remove Photo
        </SecondaryButton>

        <InputError :message="form.errors.photo" class="mt-2" />
      </div>

      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Name" />
        <TextInput
          id="name"
          value="Resolute B2B"
          type="text"
          class="mt-1 block w-full"
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="website_url" value="Webiste Url" />
        <TextInput
          id="email"
          type="url"
          value="https://resoluteb2b.com"
          class="mt-1 block w-full"
        />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="manufacturer_trader" value="Manufacturer/Trader" />
        <select
          name=""
          id=""
          class="w-full border border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        >
          <option value="manufacturer">Manufacturer</option>
          <option value="trader">Trader</option>
        </select>
        <InputError :message="form.errors.email" class="mt-2" />
      </div>
      <div class="col-span-3 sm:col-span-3">
        <InputLabel for="country" value="Country" />
        <select name="" id="" class="w-full rounded-lg border border-gray-200">
          <option value="India">India</option>
        </select>
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div class="col-span-3 sm:col-span-3">
        <InputLabel for="state" value="State" />
        <select name="" id="" class="w-full rounded-lg border border-gray-200">
          <option value="Telangana">Telangana</option>
        </select>
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div class="col-span-3 sm:col-span-3">
        <InputLabel for="city" value="City" />
        <select name="" id="" class="w-full rounded-lg border border-gray-200">
          <option value="Hyderabad">Hyderabad</option>
        </select>
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="address" value="Address" />
        <TextInput
          id="address"
          type="text"
          value="521 "
          class="mt-1 block w-full"
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3"> Saved. </ActionMessage>

      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
