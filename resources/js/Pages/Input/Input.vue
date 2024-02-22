<template>
    <AuthenticatedLayout>
        <div class="flex flex-col text-center">
            <div class="border-2 border-green-500 m-5">
                <h1>This is a page where you can insert and see furniture</h1>
            </div>
            <div class="border-2 border-blue-400 m-5">
                <div class="border-2 border-red-500 flex flex-col m-2">
                    <div
                        class="border-2 flex flex-col border-purple-500 m-2 p-5"
                    >
                        <div class="border-2 border-blue-400 p-2 flex flex-col">
                            <div>
                                <!-- <h1>Add new data</h1> -->
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
                                                    <option
                                                        v-for="furniture in furnitures"
                                                    >
                                                        {{ furniture.code }}
                                                    </option>
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
                                    <button
                                        class="btn m-4 px-10 btn-primary"
                                        :disabled="form.processing"
                                    >
                                        <div v-if="form.processing">
                                            <span
                                                class="loading loading-spinner loading-sm text-primary"
                                                >Input</span
                                            >
                                        </div>
                                        <div v-else>
                                            <span>Input</span>
                                        </div>
                                    </button>
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
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Wood Type</th>
                                        <th>Width</th>
                                        <th>Depth</th>
                                        <th>Height</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(furniture, no) in furnitures"
                                        class="hover:bg-neutral"
                                    >
                                        <td>{{ no + 1 }}</td>
                                        <td>{{ furniture.image }}</td>
                                        <td>{{ furniture.code }}</td>
                                        <td>{{ furniture.description }}</td>
                                        <td>{{ furniture.category }}</td>
                                        <td>{{ furniture.wood_type }}</td>
                                        <td>{{ furniture.width }}cm</td>
                                        <td>{{ furniture.depth }}cm</td>
                                        <td>{{ furniture.height }}cm</td>
                                        <td>{{ furniture.stock }}</td>
                                        <td>${{ furniture.price }}</td>
                                        <td>
                                            <button
                                                class="btn btn-outline btn-info"
                                                @click="toggleUpdateModal"
                                            >
                                                Update
                                            </button>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-outline btn-error"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showUpdateModal">
            <UpdateModal @close="toggleUpdateModal()" class="w-full h-full">
            </UpdateModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import UpdateModal from "@/Pages/Input/Modal/Update.vue";
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
        UpdateModal,
    },
    props: ["furnitures"],
    setup(props) {
        const radioCode = ref(true);
        const categories = ["Indoor", "Outdoor", "Handicraft", "Root"];
        const notRootType = ["Indoor", "Outdoor", "Handicraft"];
        const isRoot = ref(false);
        const selectedCategory = ref("");
        // const isLoading = ref(true);
        const showUpdateModal = ref(false);

        // console.log(props.furnitures);

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

        return {
            radioCode,
            submit,
            form,
            categories,
            selectedCategory,
            notRootType,
            isRoot,
            showUpdateModal,
        };
    },
    methods: {
        previewFiles(event) {
            const file = event.target.files;
            this.form.image = file[0];
        },
        onChange(event) {
            this.radioCode = !this.radioCode;
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
        toggleUpdateModal() {
            this.showUpdateModal = !this.showUpdateModal;
            console.log(this.showUpdateModal);
        },
    },
};
</script>

<style lang="scss" scoped></style>
