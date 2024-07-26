<script setup>
import DialogModal from "@/components/DialogModal.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { watchEffect, watch, ref, computed } from "vue";
import FormLayout from "../../Layouts/FormLayout.vue";

const props = defineProps({
    employees: Object,
    contacts: Object,
    countries: Object,
});
const showPeople = ref(false);
const showStaff = ref(false);

const type = ref("user");
const search = ref("");

const form = useForm({
    productName: "",
    casNo: "",
    quantityRequired: "",
    purityRequired: "",
    structure: null,
    description: "",
    staff: ref([]),
    docs: null,
    enquiry: true,
    quote: null,
    people: ref([]),
    country: "",
    state: "",
    city: "",
});

const states = ref(null);
const cities = ref(null);

watchEffect(() => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
            form.state = null
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

const addEnquiry = () => {
    form.quote = document.getElementById('quote').value;
    form.post(route("enquiry.store"), {
        onSuccess: (res) => {
            console.log("res" + res.props);
        },
    });
};

const removeStructure = () => {
    form.structure = null
    document.getElementById('structure').value = null;
}

const removeDocs = () => {
    form.docs = null
    document.getElementById('docs').value = null;
}
</script>

<template>
    <FormLayout title="Add Enquiry" :navigation="route('enquiry.index')">
        <div class="max-w-[40rem]">
            <div class="justify-center hidden w-full p-4 md:flex">
                <p class="text-xl font-bold">Post In Enquiry</p>
            </div>
            <div class="px-[2rem] py-[1rem] bg-white">
                <form @submit.prevent="addEnquiry">
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
                        <TextInput id="cas_no" v-model="form.casNo" type="text" class="block w-full mt-1" required />
                        <InputError class="mt-2" :message="form.errors.casNo" />
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <div>
                            <InputLabel for="quantity_required" value="Quantity" />
                            <TextInput id="quantity_required" v-model="form.quantityRequired" type="text"
                                class="block w-full mt-1" />
                            <InputError class="mt-2" :message="form.errors.quantityRequired" />
                        </div>

                        <div>
                            <InputLabel for="purity_required" value="Purity" />
                            <TextInput id="purity_required" v-model="form.purityRequired" type="text"
                                class="block w-full mt-1" />
                            <InputError class="mt-2" :message="form.errors.purityRequired" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="structure" value="Structure" />
                        <input type="file" name="structure" @input="form.structure = $event.target.files[0]" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx"
                            id="structure" />
                            <button  v-if="form.structure" class="text-red-800 bg-white rounded" @click="removeStructure">X</button>
                        <InputError class="mt-2" :message="form.errors.structure" />
                    </div>

                    <div class="grid items-center grid-cols-1 gap-4 my-2">
                        <div>
                            <div class="flex">
                                <InputLabel for="description" value="Description" />
                                <span class="text-sm text-red-600">*</span>
                            </div>
                            <textarea type="text" class="block w-full mt-1" v-model="form.description"></textarea>
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
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="enquiries" id="enquiries" v-model="form.enquiry" checked />
                            <label for="enquiries">Do you want to show this post in Enquires Tab?</label>
                        </div>
                        <div>
                            <InputLabel for="docs" value="Docs" />
                            <input type="file" name="docs" @input="form.docs = $event.target.files[0]" id="docs" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx" />
                            <button  v-if="form.docs" class="text-red-800 bg-white rounded" @click="removeDocs">X</button>
                            <InputError class="mt-2" :message="form.errors.docs" />
                        </div>
                    </div>

                    <TextInput id="quote" v-model="form.quote" type="text" class="block w-full mt-1"
                        :value="`Please Quote for ${form.productName} with ${form.purityRequired} for ${form.quantityRequired}`" />{{ form.quote }}
                    <InputError class="mt-2" :message="form.errors.quote" />

                    <div class="grid grid-cols-3">
                        <div></div>
                        <div class="w-full mt-2">
                            <button type="button" @click="showPeople = true"
                                class="w-full py-2 text-white bg-blue-500 rounded-lg">
                                Share with
                            </button>
                        </div>
                        <div></div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <div class="flex">
                                <InputLabel for="country" value="Country" />
                                <span class="text-sm text-red-600">*</span>
                            </div>
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
                            <div class="flex">
                                <InputLabel for="state" value="State" />
                                <span class="text-sm text-red-600">*</span>
                            </div>
                            <select class="w-full border border-gray-200 rounded-lg" v-model="form.state">
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
                            <div class="flex">
                                <InputLabel for="city" value="City" />
                                <span class="text-sm text-red-600">*</span>
                            </div>
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
                    <p class="mt-2 text-red-600">
                        Note: The enquiry will be deactivated after 14 days.
                    </p>
                    <div class="grid grid-cols-3">
                        <div></div>
                        <PrimaryButton class="mt-4 w-full flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600">Submit
                        </PrimaryButton>
                        <div></div>
                    </div>
                </form>
            </div>
        </div>

        <DialogModal :show="showPeople" @close="showPeople = false">
            <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add People</p>

                    <div class="p-2 mt-2 bg-white">
                        <div class="flex gap-2">
                            <select v-model="type" class="rounded-lg">
                                <option value="user">User</option>
                                <option value="company">Company</option>
                            </select>
                            <TextInput type="text" class="flex-1" v-model="search" :placeholder="`Search ${type}`" />
                        </div>
                    </div>
                    <div v-for="contact in filtered" class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="contact" id="contact" :value="contact" v-model="form.people" />
                        <label for="name">{{ contact.name }} @
                            {{ contact.company.name }}</label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="showPeople = false">Done</PrimaryButton>
                </div>
            </template>
        </DialogModal>

        <DialogModal :show="showStaff" @close="showStaff = !showStaff">
            <template #content>
                <div class="mt-4">
                    <p class="mb-2">Add Staff</p>
                    <div v-for="employee in employees" class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="staff" :value="employee.id" v-model="form.staff" />
                        <label for="name">{{ employee.name }}</label>
                    </div>
                </div>
                <div class="flex justify-end">
                    <PrimaryButton @click="showStaff = !showStaff">Done</PrimaryButton>
                </div>
            </template>
        </DialogModal>
    </FormLayout>
</template>
