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
                            <form @submit.prevent="submit">
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
                                                id="image"
                                                @change="previewFiles"
                                                type="file"
                                                class="file-input file-input-sm rounded-md file-input-bordered file-input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.image"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Code :</h1>
                                            <div v-if="radioCode">
                                                <input
                                                    id="codeText"
                                                    v-model="form.code"
                                                    type="text"
                                                    placeholder="Type here"
                                                    class="input input-bordered input-primary w-full max-w-xs"
                                                    required
                                                />
                                                <InputError
                                                    class="mt-2"
                                                    :message="form.errors.code"
                                                />
                                            </div>
                                            <div v-else>
                                                <select
                                                    id="codeSelect"
                                                    v-model="form.code"
                                                    class="select select-md select-primary w-full max-w-xs"
                                                    required
                                                >
                                                    <option disabled selected>
                                                        Existing Code
                                                    </option>
                                                    <option>TW-01</option>
                                                    <option>TW-02</option>
                                                    <option>TW-03</option>
                                                    <option>TW-04</option>
                                                </select>
                                                <InputError
                                                    class="mt-2"
                                                    :message="form.errors.code"
                                                />
                                                <!-- Radio Group -->
                                            </div>
                                            <div class="ml-5 flex flex-col">
                                                <div class="flex flex-row">
                                                    <input
                                                        type="radio"
                                                        name="radioCode"
                                                        class="mb-2 radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                        value="new"
                                                        @change="
                                                            onChange($event)
                                                        "
                                                        checked
                                                    />
                                                    <label
                                                        for="radio"
                                                        class="ml-2"
                                                        >New data</label
                                                    >
                                                </div>
                                                <div class="flex flex-row">
                                                    <input
                                                        type="radio"
                                                        name="radioCode"
                                                        class="radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                        value="exist"
                                                        @change="
                                                            onChange($event)
                                                        "
                                                    />
                                                    <label
                                                        for="radio"
                                                        class="ml-2"
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
                                                id="description"
                                                v-model="form.description"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors.description
                                                "
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Category :</h1>
                                            <select
                                                id="category"
                                                v-model="form.category"
                                                @change="categoryChange"
                                                class="select select-md select-primary w-full max-w-xs"
                                            >
                                                <option
                                                    v-for="category in categories"
                                                >
                                                    {{ category }}
                                                </option>
                                                <!-- <option disabled selected>
                                                    Insert category
                                                </option>
                                                <option>Indoor</option>
                                                <option>Outdoor</option>
                                                <option>Handicraft</option>
                                                <option>Root</option> -->
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.category"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Wood Type :</h1>
                                            <select
                                                id="woodtype"
                                                v-model="form.woodtype"
                                                class="select select-md select-primary w-full max-w-xs"
                                            >
                                                <option
                                                    v-if="isRoot"
                                                    value="Root"
                                                >
                                                    Root
                                                </option>
                                                <option
                                                    v-if="!isRoot"
                                                    v-for="notRoot in notRootType"
                                                >
                                                    {{ notRoot }}
                                                </option>
                                                <!-- <div v-if="selectedCategory">
                                                    <option>Root</option>
                                                </div>
                                                <div v-else>
                                                    <option>Teak Wood</option>
                                                    <option>Tiger Wood</option>
                                                    <option>
                                                        Mahogany Wood
                                                    </option>
                                                </div> -->
                                                <!-- <option disabled selected>
                                                    Insert wood type
                                                </option>
                                                <option>Teak Wood</option>
                                                <option>Tiger Wood</option>
                                                <option>Mahogany Wood</option>
                                                <option>Root</option> -->
                                            </select>
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.woodtype"
                                            />
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
                                                id="width"
                                                v-model="form.width"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.width"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Depth :</h1>
                                            <input
                                                id="depth"
                                                v-model="form.depth"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.depth"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Height :</h1>
                                            <input
                                                id="height"
                                                v-model="form.height"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.height"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Stock :</h1>
                                            <input
                                                id="stock"
                                                v-model="form.stock"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.stock"
                                            />
                                        </div>
                                        <div
                                            class="flex flex-row p-2 border-2 border-cyan-300"
                                        >
                                            <h1 class="m-2">Price :</h1>
                                            <input
                                                id="price"
                                                v-model="form.price"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.price"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <PrimaryButton
                                        class="ml-4"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        Input
                                    </PrimaryButton>
                                </div>
                            </form>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
export default {
    components: {
        AuthenticatedLayout,
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
    },
    setup() {
        const radioCode = ref(true);
        const categories = ["Indoor", "Outdoor", "Handicraft", "Root"];
        const notRootType = ["Indoor", "Outdoor", "Handicraft"];
        const isRoot = ref(false);
        const selectedCategory = ref("");
        // const form = useForm({
        //     image: "",
        //     codeText: "",
        //     codeSelect: "",
        //     description: "",
        //     category: "",
        //     woodtype: "",
        //     width: "",
        //     depth: "",
        //     height: "",
        //     stock: "",
        //     price: "",
        // });
        const form = useForm({
            image: "",
            code: "",
            description: "",
            category: "",
            woodtype: "",
            width: "",
            depth: "",
            height: "",
            stock: "",
            price: "",
        });

        const submit = () => {
            form.post(route("input.create"));
        };

        // if (radioCode) {
        //     delete form.codeSelect;
        // }

        return {
            radioCode,
            submit,
            form,
            categories,
            selectedCategory,
            notRootType,
            isRoot,
        };
    },
    methods: {
        previewFiles(event) {
            // console.log(event.target.files[0]);
            const file = event.target.files;
            this.form.image = file[0];
            // this.form.image = "image";
            // console.log(this.form);
        },
        onChange(event) {
            this.radioCode = !this.radioCode;
            // if (this.radioCode) {
            //     this.form.codeText = "";
            //     delete this.form.codeSelect;
            // } else {
            //     this.form.codeSelect = "";
            //     delete this.form.codeText;
            // }
            this.form.reset("code");
            console.log(this.radioCode);
            console.log(this.form);
        },
        categoryChange(event) {
            if (event.target.options.selectedIndex > -1) {
                this.selectedCategory = event.target.value;
                if (this.selectedCategory == "Root") {
                    this.isRoot = true;
                } else {
                    this.isRoot = false;
                }
                console.log(this.isRoot);
                console.log(this.selectedCategory);
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
