<script setup>
import DialogModal from '@/components/DialogModal.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { watchEffect, ref, computed } from "vue";
import FormLayout from '../../Layouts/FormLayout.vue';
import axios from 'axios';
import SecondaryButton from "../../Components/SecondaryButton.vue";
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    employees: Object,
    product: Object,
    staffDetails: Object,
    countries: Object,
})
const showPeople = ref(false);
const showStaff = ref(false);

const type = ref("user");
const search = ref("");

const form = useForm({
    productName: props.product.product_name,
    casNo: props.product.cas_no,
    structure: null,
    description: props.product.description,
    type: props.product.type,
    category: props.product.category,
    staff: ref([]),
    docs: null,
    sale: props.product.sale_show === 1 ? true : false,
    quote: '',
    people: ref([]),
    country: props.product.country,
    state: props.product.state,
    city: props.product.city
})


const states = ref(null);
const cities = ref(null);

const getStates = () => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
            form.state = null;
            form.city = null;
            cities.value = null;
        });
    }
};

watchEffect(() => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
        });
    }


    if (form.state) {
        axios.get(route("cities", { state: form.state })).then((res) => {
            cities.value = res.data.length > 0 ? res.data : null;
        });
    }
});

const getCities = () => {
    if (form.state) {
        axios.get(route("cities", { state: form.state })).then((res) => {
            cities.value = res.data.length > 0 ? res.data : null;
        });
    }
};

const filtered = computed(() => {
    if (search.value !== "") {
        if (type.value === "user") {
            return props.contacts.filter((item) => {
                return search.value
                    .toLowerCase()
                    .split(" ")
                    .every((v) => item.name.toLowerCase().includes(v));
            });
        } else if (type.value === "company") {
            return props.contacts.filter((item) => {
                return search.value
                    .toLowerCase()
                    .split(" ")
                    .every((v) => item.company.name.toLowerCase().includes(v));
            });
        }
    } else {
        return props.contacts;
    }
});

const updateProduct = () => {
    form.post(route('product.update', { product: props.product }), {
        onSuccess: (res) => {
            setTimeout(() => {
                Inertia.get(route('profile.display', { id: props.product.user_id }))    
            }, 1000);
            
        },
    });
}

const removeStaff = (staff) => {
    axios.patch(route('product.update', { type: 'remove_staff', product: props.product, staff: staff }))
        .then(res => {
            window.location.reload();
        })
}

const removeStructure = () => {
    form.structure = 'no image'
    props.product.structure = null
    props.product.structure_url = null
    document.getElementById('structure').value = null;
}

const removeDocs = () => {
    form.docs = 'no doc'
    props.product.docs = null
    props.product.docs_url = null
    document.getElementById('docs').value = null;
}

const isImage = (fileName) => {
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    const extension = fileName.split('.').pop().toLowerCase();
    return imageExtensions.includes(extension);
}

const isPDF = (fileName) => {
    const extension = fileName.split('.').pop().toLowerCase();
    return extension === 'pdf';
}

const isDocx = (fileName) => {
    const extension = fileName.split('.').pop().toLowerCase();
    return extension === 'docx';
}

</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<template>
    <FormLayout title="Update Sale">
        <div class="max-w-[40rem]">
            <div class="justify-center hidden w-full p-4 md:flex ">
                <p class="text-xl font-bold">Update Product</p>
            </div>
            <div class="px-[2rem] py-[1rem] bg-white">
                <form @submit.prevent="updateProduct">
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
                        <input type="file" name="structure" @input="form.structure = $event.target.files[0]"
                            id="structure" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx">
                        <button v-if="form.structure && form.structure != 'no image'" type="button" class="text-red-800 bg-white rounded"
                            @click="removeStructure">X</button>
                        <InputError class="mt-2" :message="form.errors.structure" />
                        <div>
                            <button v-if="product.structure" type="button" class="ml-12 text-red-800 bg-white rounded"
                                @click="removeStructure">X</button>
                            <!-- <a :href="product.structure_url" target="_blank">
                                <img :src="product.structure_url" alt="structure" class="h-[15rem]">
                            </a> -->
                            <a :href="product.structure_url" target="_blank" v-if="product.structure">
                                <img :src="product.structure_url" alt="structure" class="h-[15rem]" />
                            </a>
                        </div>
                    </div>

                    <div class="flex gap-4 mt-2">
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
                            <InputError class="mt-2" :message="form.errors.casNo" />
                        </div>
                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea type="text" class="block w-full mt-1" v-model="form.description"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div></div>
                            <div class="flex flex-col items-center w-full">
                                <!-- <InputLabel for="staff" value="Add Staff" /> -->
                                <button type="button" @click="showStaff = true"
                                    class="w-full py-2 text-white bg-blue-400 rounded-lg">Add Staff</button>
                            </div>
                            <div></div>
                        </div>

                        <div class="mt-2">
                            <p class="text-lg">Staff Added</p>
                            <div class="grid grid-cols-1 gap-2 p-2 md:grid-cols-2">
                                <!-- {{ staffDetails }} -->
                                <div v-for="staff in staffDetails"
                                    class="flex justify-between p-2 bg-white border border-gray-200 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <img :src="staff.profile_photo_url" alt="" class="h-[2rem] rounded-full">
                                        <p>{{ staff.name }}</p>
                                    </div>
                                    <button type="button" @click="removeStaff(staff)">X</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <InputLabel for="docs" value="Docs" />
                            <input type="file" name="docs" @input="form.docs = $event.target.files[0]" id="docs"
                                accept=".pdf, .jpg, .jpeg, .png, .doc, .docx">
                            <button v-if="form.docs && form.docs != 'no doc'" type="button" class="text-red-800 bg-white rounded"
                                @click="removeDocs">X</button>
                            <InputError class="mt-2" :message="form.errors.docs" />
                            <div>
                                <button v-if="product.docs" type="button" class="mt-2 ml-12 text-red-800 bg-white rounded"
                                    @click="removeDocs">X</button>
                                <!-- <a :href="product.docs_url" target="_blank">{{ product.docs }}</a> -->
                                <a :href="`${product.docs_url}`" target="_blank" v-if="product.docs">
                                    <img :src="product.docs_url" width="80" height="90" v-if="isImage(product.docs)" />
                                    <div v-else-if="isPDF(product.docs)">
                                    <embed :src="product.docs_url" width="80" height="90" type="application/pdf"
                                         />
                                         <span class="text-blue-400">Preview</span>
                                    </div>
                                    <img :src="'/assests/images/docfile.png'" width="80" height="90" class="mt-10 ml-5"
                                        v-else-if="isDocx(product.docs)" />

                                    <!-- <p>{{ product.docs }}</p> -->
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <InputLabel for="country" value="Country" />
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.country" required
                                @change="getStates">
                                <option disabled>
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
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.state"
                                @change="getCities" required>
                                <option disabled>
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
                                <option selected disabled>
                                    Select City
                                </option>
                                <option v-for="city in cities" :value="city.id">
                                    {{ city.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3">
                        <div></div>
                        <PrimaryButton class="mt-4 w-full flex justify-center rounded-lg font-bold p-2 mb-[5rem]">Submit
                        </PrimaryButton>
                        <div></div>
                    </div>
                </form>
            </div>
        </div>

        <DialogModal :show="showStaff" @close="showStaff = !showStaff">
            <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add Staff</p>
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
