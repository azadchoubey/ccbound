<script setup>
import DialogModal from "@/components/DialogModal.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { watchEffect, ref, computed } from "vue";
import FormLayout from "../../Layouts/FormLayout.vue";
import axios from "axios";
import SecondaryButton from "@/components/SecondaryButton.vue";
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    employees: Object,
    sale: Object,
    staffDetails: Object,
    countries: Object,
    contacts: Object,
});
const showPeople = ref(false);
const showStaff = ref(false);

const type = ref("user");
const search = ref("");

const form = useForm({
    productName: props.sale.product_name,
    casNo: props.sale.cas_no,
    quantityRequired: props.sale.quantity_required,
    purityRequired: props.sale.purity_required,
    structure: null,
    description: props.sale.description,
    staff: ref([]),
    docs: null,
    sale: props.sale.sale_show === 1 ? true : false,
    quote: "",
    people: ref([]),
    country: props.sale.country,
    state: props.sale.state,
    city: props.sale.city,
});

const states = ref(null);
const cities = ref(null);

watchEffect(() => {
    if (form.country) {
        axios.get(route("states", { country: form.country })).then((res) => {
            states.value = res.data.length > 0 ? res.data : null;
            // if(form.country!=props.country) {
            //     form.state = null;
            //     form.city = null;
            // }
            
            cities.value = null;
        });
    }
});

watchEffect(() => {
    if (form.state) {
        axios.get(route("cities", { state: form.state })).then((res) => {
            cities.value = res.data.length > 0 ? res.data : null;
            // if(form.state != props.state) {
            //     form.city = null;
            // }
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
const updateSale = () => {
    form.quote = document.getElementById('quote').value;
    form.post(route("sale.update", { sale: props.sale }), {
        onSuccess: (res) => {
            Inertia.get(route('profile.display', { id: props.sale.user_id }))
         },
    });
};

const removeStaff = (staff) => {
    axios
        .post(
            route("sale.update", {
                type: "remove_staff",
                sale: props.sale,
                staff: staff,
            })
        )
        .then((res) => {
            window.location.reload();
        });
};

const removeStructure = () => {
    form.structure = null
    props.sale.structure = null
    props.sale.structure_url = null
    document.getElementById('structure').value = null;
}

const removeDocs = () => {
    form.docs = null
    props.sale.docs = null
    props.sale.docs_url = null
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

<template>
    <FormLayout title="Update Sale">
        <div class="max-w-[40rem]">
            <div class="justify-center hidden w-full p-4 md:flex">
                <p class="text-xl font-bold">Update Sale</p>
            </div>
            <div class="px-[2rem] py-[1rem] bg-white">
                <form @submit.prevent="updateSale">
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
                        <input type="file" name="structure" @input="form.structure = $event.target.files[0]"
                            id="structure" accept=".pdf, .jpg, .jpeg, .png, .doc, .docx" />{{ sale.structure }}
                        <button v-if="form.structure" type="button" class="text-red-800 bg-white rounded"
                            @click="removeStructure">X</button>
                        <InputError class="mt-2" :message="form.errors.structure" />
                        <div>
                            <button v-if="sale.structure" type="button" class="ml-12 text-red-800 bg-white rounded"
                                @click="removeStructure">X</button>
                            <a :href="sale.structure_url" target="_blank" v-if="sale.structure">
                                <img :src="sale.structure_url" alt="structure" class="h-[15rem]" />
                            </a>
                        </div>
                    </div>

                    <div class="grid items-center grid-cols-1 gap-4 my-2">
                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea type="text" class="block w-full mt-1" v-model="form.description"></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <div></div>
                            <div class="flex flex-col items-center w-full">
                                <button type="button" @click="showStaff = true"
                                    class="w-full py-2 text-white bg-blue-400 rounded-lg">
                                    Add Staff
                                </button>
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
                                        <img :src="staff.profile_photo_url" alt="" class="h-[2rem] rounded-full" />
                                        <p>{{ staff.name }}</p>
                                    </div>
                                    <button type="button" @click="removeStaff(staff)">
                                        X
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <InputLabel for="docs" value="Docs" />
                            <input type="file" name="docs" @input="form.docs = $event.target.files[0]" id="docs"
                                accept=".pdf, .jpg, .jpeg, .png, .doc, .docx" />
                            <button v-if="form.docs" type="button" class="text-red-800 bg-white rounded"
                                @click="removeDocs">X</button>
                            <InputError class="mt-2" :message="form.errors.docs" />
                            <div>
                                <button v-if="sale.docs" type="button" class="mt-2 ml-12 text-red-800 bg-white rounded"
                                    @click="removeDocs">X</button>
                                <!-- <a :href="sale.docs_url" target="_blank">{{sale.docs}}</a> -->
                                <!-- <a :href="`${sale.docs_url}`" target="_blank" v-if="sale.docs">
                                    <img :src="'/assests/images/docfile.png'" width="80" height="90"
                                        class="mt-10 ml-5" />
                                </a> -->
                                <a :href="sale.docs_url" target="_blank" v-if="sale.docs" class="mt-10 ml-5">
                                    <img :src="sale.docs_url" width="80" height="90" v-if="isImage(sale.docs)" />
                                    <embed :src="sale.docs_url" width="80" height="90" type="application/pdf"
                                        v-else-if="isPDF(sale.docs)" />
                                    <img :src="'/assests/images/docfile.png'" width="80" height="90" class="mt-10 ml-5"
                                        v-else-if="isDocx(sale.docs)" />

                                    <p>{{ sale.docs }}</p>

                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="enquiries" id="enquiries" v-model="form.sale" checked />
                        <label for="enquiries">Enquiries</label>
                    </div>

                    <TextInput id="quote" v-model="form.quote" type="text" class="block w-full mt-1"
                        :value="`${form.productName}`" />
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
                    <p class="mt-2 text-red-600">
                        Note: The sale will be deactivated after 14 days.
                    </p>
                    <div class="grid grid-cols-3">
                        <div></div>
                        <PrimaryButton
                            class="mt-4 w-full flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600">
                            Submit</PrimaryButton>
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
            </template>
            <template #footer>
                <div class="flex justify-end">
                    <SecondaryButton type="button" @click="showPeople = false">Ok</SecondaryButton>
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
            </template>
            <template #footer>
                <div class="flex justify-end">
                    <SecondaryButton type="button" @click="showStaff = false">Ok</SecondaryButton>
                </div>
            </template>
        </DialogModal>
    </FormLayout>
</template>
