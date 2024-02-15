<template>
    <AuthenticatedLayout>
        <div class="flex flex-col text-center">
            <div class="border-2 border-green-500 m-5">
                <h1>This is a page where you can insert and see furniture</h1>
            </div>
            <div class="border-2 border-blue-400 m-5">
                <h3>Add Furniture</h3>
                <div class="border-2 border-red-500 flex flex-col m-2">
                    <div
                        class="border-2 flex flex-col border-purple-500 m-2 p-5"
                    >
                        <div class="mb-5">
                            <button class="btn btn-outline btn-secondary">
                                Add existing data
                            </button>
                        </div>
                        <div class="border-2 border-blue-400 p-2 flex flex-col">
                            <div>
                                <h1>Add new data</h1>
                            </div>
                            <div
                                class="border-2 border-yellow-400 p-2 flex flex-row"
                            >
                                <div
                                    class="border-2 border-green-500 w-[50%] items-center p-2"
                                >
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Image :</h1>
                                        <input
                                            type="file"
                                            class="file-input file-input-sm rounded-md file-input-bordered file-input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Code :</h1>
                                        <div v-if="radioCode == 'new'">
                                            <input
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                        </div>
                                        <div v-else>
                                            <select
                                                class="select select-md select-primary w-full max-w-xs"
                                            >
                                                <option disabled selected>
                                                    Existing Code
                                                </option>
                                                <option>TW-01</option>
                                                <option>TW-02</option>
                                                <option>TW-03</option>
                                                <option>TW-04</option>
                                            </select>
                                        </div>
                                        <!-- Radio Group -->
                                        <div class="ml-5 flex flex-col">
                                            <div class="flex flex-row">
                                                <input
                                                    type="radio"
                                                    name="radioCode"
                                                    class="mb-2 radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                    value="new"
                                                    @change="onChange($event)"
                                                    checked
                                                />
                                                <label for="radio" class="ml-2"
                                                    >New data</label
                                                >
                                            </div>
                                            <div class="flex flex-row">
                                                <input
                                                    type="radio"
                                                    name="radioCode"
                                                    class="radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                    value="exist"
                                                    @change="onChange($event)"
                                                />
                                                <label for="radio" class="ml-2"
                                                    >Existing data</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Description :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Category :</h1>
                                        <select
                                            class="select select-md select-primary w-full max-w-xs"
                                        >
                                            <option disabled selected>
                                                Insert category
                                            </option>
                                            <option>Indoor</option>
                                            <option>Outdoor</option>
                                            <option>Handicraft</option>
                                            <option>Root</option>
                                        </select>
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Wood Type :</h1>
                                        <select
                                            class="select select-md select-primary w-full max-w-xs"
                                        >
                                            <option disabled selected>
                                                Insert wood type
                                            </option>
                                            <option>Teak Wood</option>
                                            <option>Tiger Wood</option>
                                            <option>Mahogany Wood</option>
                                            <option>Root</option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="border-2 border-green-500 w-[50%] items-center p-2"
                                >
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Width :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Depth :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Height :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Stock :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                    <div
                                        class="flex flex-row p-2 border-2 border-cyan-300"
                                    >
                                        <h1 class="m-2">Price :</h1>
                                        <input
                                            type="text"
                                            placeholder="Type here"
                                            class="input input-bordered input-primary w-full max-w-xs"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-2 border-red-200 m-5 p-5">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Job</th>
                                        <th>Favorite Color</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr class="hover:bg-neutral">
                                        <th>1</th>
                                        <td>Cy Ganderton</td>
                                        <td>Quality Control Specialist</td>
                                        <td>Blue</td>
                                    </tr>
                                    <!-- row 2 -->
                                    <tr class="hover:bg-neutral">
                                        <th>2</th>
                                        <td>Hart Hagerty</td>
                                        <td>Desktop Support Technician</td>
                                        <td>Purple</td>
                                    </tr>
                                    <!-- row 3 -->
                                    <tr class="hover:bg-neutral">
                                        <th>3</th>
                                        <td>Brice Swyre</td>
                                        <td>Tax Accountant</td>
                                        <td>Red</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-2 border-yellow-300">Text 2</div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
export default {
    components: {
        AuthenticatedLayout,
    },
    setup() {
        const radioCode = ref("new");
        return { radioCode };
    },
    methods: {
        onChange(event) {
            this.radioCode = event.target.value;
            // console.log(this.radioCode);
        },
    },
};
</script>

<style lang="scss" scoped></style>
