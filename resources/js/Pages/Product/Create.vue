<script setup>
import DialogModal from '@/components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { watchEffect, ref } from 'vue';
import FormLayout from '../../Layouts/FormLayout.vue';
import SecondaryButton from "../../Components/SecondaryButton.vue";

const props = defineProps({
    employees: Object,
    countries: Object,
})

const showStaff = ref(false);
const form = useForm({
    productName: '',
    casNo: '',
    structure: null,
    description: '',
    type: '',
    category: '',
    staff: ref([]),
    docs: null,
    country: '',
    state: '',
    city: ''
})

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


const addProduct = () => {
    form.post(route('product.store'), {
        onSuccess: (res) => {
            console.log('res' + res.props)
        },
    });
}

const removeStructure = () => {
    form.structure = null
    document.getElementById('structure').value = null;
}

const removeDocs = () => {
    form.docs = null
    document.getElementById('docs').value = null;
}
const handleFileUpload = (event) => {
      form.docs = Array.from(event.target.files);
    };
</script>

<template>
    <FormLayout title="Add Product" :navigation="route('company.manage')">
        <div class="max-w-[40rem]">
            <div class="justify-between hidden px-2 mt-2 md:flex">
                <p class="flex justify-center w-full px-2 text-xl font-semibold">Add Product</p>
            </div>

            <div class="px-[2rem] py-[1rem] bg-white">
                <form @submit.prevent="addProduct">
                    <div class="mb-2">
                        <div class="flex">
                            <InputLabel for="product_name" value="Product Name" />
                            <span class="text-sm text-red-600">*</span>
                        </div>
                        <TextInput id="product_name" v-model="form.productName" type="text" class="block w-full mt-1"
                            required />
                        <InputError class="mt-2" :message="form.errors.productName" />
                    </div>

                    <div class="mb-2">
                        <div class="flex">
                            <InputLabel for="cas_no" value="CAS No" />
                            <span class="text-sm text-red-600">*</span>
                        </div>
                        <TextInput id="cas_no" v-model="form.casNo" type="text"
                            class="block w-full mt-1" required />
                        <InputError class="mt-2" :message="form.errors.casNo" />
                    </div>

                    <div>
                        <InputLabel for="structure" value="Structure" />
                        <input type="file" name="structure" @input="form.structure = $event.target.files[0]" id="structure" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx">
                        <button  v-if="form.structure" class="text-red-800 bg-white rounded" @click="removeStructure">X</button>
                        <InputError class="mt-2" :message="form.errors.structure" />
                    </div>

                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <InputLabel for="purity_required" value="Type" />
                            <select v-model="form.type">
                                <option value="campaign">
                                    Campaign
                                </option>
                                <option value="regular">
                                    Regular
                                </option>
                            </select>  
                        </div>

                    </div>
                    <div class="grid items-center grid-cols-1 gap-4 my-2">
                        <div>
                            <InputLabel for="purity_required" value="Category" />
                            <select v-model="form.category">
                                <option>API</option>
                                <option>API INTERMEDIATE</option>
                                <option>FINE CHEMICAL</option>
                                <option>API IMPURITY</option>
                                <option>CRO MOLECULE</option>
                                <option>SPECIALITY CHEMICAL</option>
                            </select>
                        </div>
                        <div>
                            <InputLabel for="category" value="Category (If not in the list)" />
                            <TextInput id="cas_no" type="text" class="block w-full mt-1" v-model="form.category" />
                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>
                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea type="text" class="block w-full mt-1" v-model="form.description" required></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div></div>
                            <div class="flex flex-col items-center w-full">
                                <!-- <InputLabel for="staff" value="Add Staff" /> -->
                                <button type="button" @click="showStaff = true"
                                    class="w-full py-2 text-white bg-blue-400 rounded-lg">
                                    Add Staff
                                </button>
                            </div>
                            <div></div>
                        </div>
                        
                        <div>
                            <InputLabel for="docs" value="Docs" />
                            <input type="file" name="docs" multiple @input="handleFileUpload"  id="docs" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx">
                            <button  v-if="form.docs" class="text-red-800 bg-white rounded" @click="removeDocs">X</button>
                            <InputError class="mt-2" :message="form.errors.docs" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="country" value="Country" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.country" required>
                                <option value="" selected disabled>
                                    Select Country
                                </option>
                                <option v-for="country in countries" :value="country.id">
                                    {{ country.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.country" />
                        </div>

                        <div v-if="states">
                            <InputLabel for="state" value="State" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.state" required>
                                <option value="" selected disabled>
                                    Select State
                                </option>
                                <option v-for="state in states" :value="state.id">
                                    {{ state.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>

                        <div v-if="cities">
                            <InputLabel for="city" value="City" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.city">
                                <option value="" selected disabled>
                                    Select City
                                </option>
                                <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <PrimaryButton class="mt-4 w-[10rem] flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600">Submit
                        </PrimaryButton>
                    </div>

                </form>
            </div>
        </div>


        <DialogModal :show="showStaff" @close="showStaff = false">
            <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add People</p>
                    <div v-for="employee in employees" class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="staff" :value="employee.id" v-model="form.staff">
                        <label for="name">{{ employee.name }}</label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <SecondaryButton @click="showStaff = !showStaff" class="mr-2">OK</SecondaryButton>
                </div>
            </template>
        </DialogModal>
    </FormLayout>
</template>
