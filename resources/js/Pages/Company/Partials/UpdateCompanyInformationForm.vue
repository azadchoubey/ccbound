<script setup>
import ActionMessage from "@/Components/ActionMessage.vue";
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watchEffect } from "vue";

const props = defineProps({
  company: Object,
  countries: Array,
});

const form = useForm({
  _method: "PUT",
  name: props.company.name,
  website: props.company.website,
  type: props.company.type,
  country: props.company.country,
  state: props.company.state,
  city: props.company.city,
  address: props.company.address,
});

const logoForm = useForm({
  logo: null,
})

const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
  if (photoInput.value) {
    logoForm.logo = photoInput.value.files[0];
  }
  form.patch(route("company.update", { company: props.company }), {
    preserveScroll: true,
    onSuccess: () => clearPhotoFileInput(),
  });
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

  if (photoInput.value) {
    logoForm.logo = photoInput.value.files[0];

    // console.table(logoForm);
    // return;

    logoForm.post(route("company.updatelogo", { company: props.company }), {
      preserveScroll: true,
      onSuccess: () => clearPhotoFileInput(),
    });
  }
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};

const states = ref(null);
const cities = ref(null);
 
watchEffect(() => {
  if (form.country) {
    axios.get(route("states", { country: form.country })).then((res) => {
      states.value = res.data.length > 0 ? res.data : null;
      // form.state = null;
      // form.city = null;
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

</script>

<template>
  <FormSection @submitted="updateProfileInformation">
    <template #title> Company Information </template>

    <template #description> Update your company's information. </template>

    <template #form>
      <!-- Profile Photo -->
      <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
        <!-- Profile Photo File Input -->
        <input ref="photoInput" type="file" class="hidden" @change="updatePhotoPreview" />

        <InputLabel for="company_logo" value="Company Logo" />

        <!-- Current Profile Photo -->
        <div v-show="!photoPreview" class="mt-2">
          <img :src="props.company.logo_url" :alt="props.company.name" class="w-20 h-20 rounded-full" />
        </div>

        <!-- New Profile Photo Preview -->
        <div v-show="photoPreview" class="mt-2">
          <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
            :style="'background-image: url(\'' + photoPreview + '\');'" />
        </div>
        <InputError :message="logoForm.errors.logo" class="mt-2" />

        <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
          Select A New logo-resize
        </SecondaryButton>

        <InputError :message="form.errors.photo" class="mt-2" />
      </div>

      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="name" value="Name" />
        <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autocomplete="name" />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="website_url" value="Webiste Url" />
        <TextInput id="email" type="url" v-model="form.website" class="block w-full mt-1" />
        <InputError :message="form.errors.website" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="manufacturer_trader" value="Manufacturer/Trader" />
        <select
          class="w-full border border-gray-300 rounded-md focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          v-model="form.type" requried>
          <option value="" selected disabled>Select Type</option>
          <option value="Manufacturer">Manufacturer</option>
          <option value="Trader">Trader</option>
        </select>
        <InputError :message="form.errors.type" class="mt-2" />
      </div>
      <div class="col-span-3 sm:col-span-3">
        <InputLabel for="country" value="Country" />
        <select class="w-full border border-gray-200 rounded-lg" v-model="form.country" required>
          <option disabled>Select Country</option>
          <option v-for="country in countries" :value="country.id">
            {{ country.name }}
          </option>
        </select>
        <InputError :message="form.errors.country" class="mt-2" />
      </div>

      <div class="col-span-3 sm:col-span-3" v-if="states || form.state">
        <InputLabel for="state" value="State" />
        <select class="w-full border border-gray-200 rounded-lg" v-model="form.state" requried>
          <option disabled>Select State</option>
          <option v-for="state in states" :value="state.id">
            {{ state.name }}
          </option>
        </select>
        <InputError :message="form.errors.state" class="mt-2" />
      </div>

      <div class="col-span-3 sm:col-span-3" v-if="cities || form.city">
        <InputLabel for="city" value="City" />
        <select class="w-full border border-gray-200 rounded-lg" v-model="form.city">
          <option disabled>Select City</option>
          <option v-for="city in cities" :value="city.id">
            {{ city.name }}
          </option>
        </select>
        <InputError :message="form.errors.city" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <InputLabel for="address" value="Address" />
        <TextInput id="address" type="text" v-model="form.address" class="block w-full mt-1" autocomplete="address" />
        <InputError :message="form.errors.address" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <ActionMessage :on="form.recentlySuccessful" class="mr-3"> Saved. </ActionMessage>

      <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
        Save
      </PrimaryButton>
    </template>
  </FormSection>
</template>
