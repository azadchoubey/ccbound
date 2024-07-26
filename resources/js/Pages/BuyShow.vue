<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Contacts">
        <div class="px-2">
            <p></p>
            <div class="mt-2">
                <!-- component -->
                <section class="container mx-auto font-mono">
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr
                                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-show uppercase border-b border-gray-600">
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Status</th>
                                        <th class="px-4 py-3">Pack purchased</th>
                                        <th class="px-4 py-3">Earned Money</th>
                                        <th class="px-4 py-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-black">Sufyan</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 text-ms font-semibold border">22</td>
                                        <td class="px-4 py-3 text-ms font-semibold border">22</td>
                                        <td class="px-4 py-3 text-sm border">6/4/2000</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-black">Stevens</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-sm">
                                                Pending </span>
                                        </td>
                                        <td class="px-4 py-3 text-md font-semibold border">27</td>
                                        <td class="px-4 py-3 text-md font-semibold border">27</td>
                                        <td class="px-4 py-3 text-sm border">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Nora</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-xs border">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-sm">
                                                Pending </span>
                                        </td>
                                        <td class="px-4 py-3 text-md font-semibold border">17</td>
                                        <td class="px-4 py-3 text-md font-semibold border">17</td>
                                        <td class="px-4 py-3 text-sm border">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Ali</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">23</td>
                                        <td class="px-4 py-3 border text-md font-semibold">23</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Khalid</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-sm">
                                                Pending </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">20</td>
                                        <td class="px-4 py-3 border text-md font-semibold">20</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Nasser</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">29</td>
                                        <td class="px-4 py-3 border text-md font-semibold">29</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Mohammed</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">38</td>
                                        <td class="px-4 py-3 border text-md font-semibold">38</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Saad</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">19</td>
                                        <td class="px-4 py-3 border text-md font-semibold">19</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                    <tr class="text-gray-700">
                                        <td class="px-4 py-3 border">
                                            <div class="flex items-center text-sm">
                                                <div class="relative w-8 h-8 mr-3 rounded-full">
                                                    <img class="object-cover w-full h-full rounded-full"
                                                        src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260"
                                                        alt="" loading="lazy" />
                                                    <div class="absolute inset-0 rounded-full shadow-inner"
                                                        aria-hidden="true"></div>
                                                </div>
                                                <div>
                                                    <p class="font-semibold">Sami</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border text-xs">
                                            <span
                                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm">
                                                Subscribed </span>
                                        </td>
                                        <td class="px-4 py-3 border text-md font-semibold">19</td>
                                        <td class="px-4 py-3 border text-md font-semibold">19</td>
                                        <td class="px-4 py-3 border text-sm">6/10/2020</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AppLayout>
</template>
