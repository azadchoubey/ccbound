<script setup>
import { watchEffect, ref } from "vue";
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
  countries: Object,
});


const form = useForm({
  _method: "PUT",
  name: props.user.name,
  email: props.user.email,
  hide_email: props.user.hide_email === 1 ? true : false,
  number: props.user.number,
  hide_number: props.user.hide_number === 1 ? true : false,
  country: props.user.country,
  state: props.user.state,
  city: props.user.city,
  address: props.user.address,
  photo: null,
});

const states = ref(null);
const cities = ref(null);

watchEffect(() => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
            form.state = null;
            form.city = null;
            cities.value = null;
        });
    }
});

watchEffect(() => {
    if (form.state) {
        axios.get(route("cities", { state: form.state })).then((res) => {
            cities.value = res.data.length > 0 ? res.data : null;
        });
    }
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
  <FormSection @submit.prevent="updateProfileInformation">
    <template #title> Profile Information </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <template #form>
      <!-- Profile Photo -->
      <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->
        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

        <InputLabel for="photo" value="Photo" />

        <!-- Current Profile Photo -->
        <div v-show="!photoPreview" class="mt-2">
          <img
            :src="user.profile_photo_url"
            :alt="user.name"
            class="object-cover w-20 h-20 rounded-full"
          />
        </div>

        <!-- New Profile Photo Preview -->
        <div v-show="photoPreview" class="mt-2">
          <span
            class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
            :style="'background-image: url(\'' + photoPreview + '\');'"
          />
        </div>

        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
          Select A New Photo
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
          v-model="form.name"
          type="text"
          class="block w-full mt-1"
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="block w-full mt-1"
        />
        <InputError :message="form.errors.email" class="mt-2" />
        <div class="flex items-center gap-2 mt-1">
          <input type="checkbox" v-model="form.hide_email">
          <p>Hide Email</p>
        </div>
        <div
          v-if="
            $page.props.jetstream.hasEmailVerification && user.email_verified_at === null
          "
        >
          <p class="mt-2 text-sm">
            Your email address is unverified.

            <Link
              :href="route('verification.send')"
              method="post"
              as="button"
              class="text-gray-600 underline hover:text-gray-900"
              @click.prevent="sendEmailVerification"
            >
              Click here to re-send the verification email.
            </Link>
          </p>

          <div
            v-show="verificationLinkSent"
            class="mt-2 text-sm font-medium text-green-600"
          >
            A new verification link has been sent to your email address.
          </div>
        </div>
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="number" value="Number" />
        <TextInput
          id="number"
          type="text"
          v-model="form.number"
          class="block w-full mt-1"
          autocomplete="number"
        />
        <InputError :message="form.errors.name" class="mt-2" />
        <div class="flex items-center gap-2 mt-1">
            <input type="checkbox" v-model="form.hide_number">
            <p>Hide Number</p>
          </div>  
        <div
          v-if="user.number_verified_at === null"
        >
          <p class="mt-2 text-sm">
            Your mobile number is unverified.

            <Link
              :href="route('mobile.verifyform')"
              class="text-gray-600 underline hover:text-gray-900"
            >
              Click here to re-send the otp.
            </Link>
          </p>
        </div>
      </div>

      <div class="col-span-3 sm:col-span-3">
        <InputLabel for="country" value="Country" />
        <select class="w-full mt-1 border border-gray-200 rounded-lg" v-model="form.country">
          <option value="" selected disabled>Select Country</option>
          <option v-for="country in countries" :value="country.id">{{ country.name }}</option>
        </select>
        <InputError :message="form.errors.country" class="mt-2" />
      </div>

      <div v-if="states" class="col-span-3 sm:col-span-3">
        <InputLabel for="state" value="State" />
        <select class="w-full mt-1 border border-gray-200 rounded-lg" v-model="form.state">
          <option value="" selected disabled>Select State</option>
          <option v-for="state in states" :value="state.id">{{ state.name }}</option>
        </select>
        <InputError :message="form.errors.state" class="mt-2" />
      </div>

      <div v-if="cities" class="col-span-3 sm:col-span-3">
        <InputLabel for="city" value="City" />
        <select class="w-full mt-1 border border-gray-200 rounded-lg" v-model="form.city">
          <option value="" selected disabled>Select city</option>
          <option v-for="city in cities" :value="city.id">{{ city.name }}</option>
        </select>
        <InputError :message="form.errors.city" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="address" value="Address" />
        <TextInput
          id="address"
          type="text"
          v-model="form.address"
          class="block w-full mt-1"
          autocomplete="address"
        />
        <InputError :message="form.errors.address" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3"> Saved. </ActionMessage>

      <PrimaryButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        class="bg-blue-600"
      >
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
