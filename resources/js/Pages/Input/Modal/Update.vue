<template>
    <div @click.self="closeModal()" class="backdrop">
        <div
            class="bg-base-100 justify-center items-center text-center w-[90%] h-fit p-5 m-auto mt-[3%] mb-[2%] overflow-auto rounded-md"
        >
            <slot class="w-fit h-fit">
                <div class="p-2 flex flex-col">
                    <div
                        class="font-semibold text-xl text-neutral-content leading-tight mb-5"
                    >
                        <h1>Update existing data</h1>
                    </div>
                    <form @submit.prevent="submit">
                        <div
                            class="p-2 flex flex-row card bg-neutral rounded-md"
                        >
                            <div class="w-[50%] items-center p-2">
                                <div class="flex flex-col p-2">
                                    <div class="p-5">
                                        <!-- Makes Check, if open first time, take img url from db and display it -->
                                        <!-- If there is a change in image, change preview to current selected image -->
                                        <img
                                            class="m-auto"
                                            v-if="tempUrl"
                                            :src="tempUrl"
                                            alt=""
                                        />
                                    </div>
                                    <div class="flex flex-row">
                                        <h1 class="m-2">Image :</h1>
                                        <input
                                            id="image"
                                            @change="setImage"
                                            type="file"
                                            class="file-input file-input-sm rounded-md file-input-bordered file-input-primary w-full max-w-xs"
                                        />
                                        <InputError
                                            class="mt-2"
                                            :message="form.errors.image"
                                        />
                                    </div>
                                </div>
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Code :</h1>
                                    <div v-if="radioCode">
                                        <TextInput
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
                                                v-for="furniture in Furnitures"
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
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Description :</h1>
                                    <TextInput
                                        id="description"
                                        v-model="form.description"
                                        type="text"
                                        placeholder="Type here"
                                        class="input input-bordered input-primary w-full max-w-xs"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.description"
                                    />
                                </div>
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Category :</h1>
                                    <select
                                        id="category"
                                        v-model="form.category"
                                        @change="categoryChange"
                                        class="select select-md select-primary w-full max-w-xs"
                                    >
                                        <option v-for="category in categories">
                                            {{ category }}
                                        </option>
                                    </select>
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.category"
                                    />
                                </div>
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Wood Type :</h1>
                                    <select
                                        id="woodtype"
                                        v-model="form.woodtype"
                                        class="select select-md select-primary w-full max-w-xs"
                                    >
                                        <option v-if="isRoot" value="Root">
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
                            <div class="w-[50%] items-center p-2">
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Width :</h1>
                                    <TextInput
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
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Depth :</h1>
                                    <TextInput
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
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Height :</h1>
                                    <TextInput
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
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Stock :</h1>
                                    <TextInput
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
                                <div class="flex flex-row p-2">
                                    <h1 class="m-2">Price :</h1>
                                    <TextInput
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
                                class="btn m-4 px-10 btn-info"
                                :disabled="form.processing"
                            >
                                <div v-if="form.processing">
                                    <span
                                        class="loading loading-spinner loading-sm text-primary"
                                        >Update</span
                                    >
                                </div>
                                <div v-else>
                                    <span>Update</span>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </slot>
        </div>
    </div>
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
    props: ["SelectedFurniture", "Furnitures"],
    components: {
        AuthenticatedLayout,
        PrimaryButton,
        TextInput,
        InputLabel,
        InputError,
    },
    setup(props) {
        const radioCode = ref(true);
        const categories = ["Indoor", "Outdoor", "Handicraft", "Root"];
        const notRootType = ["Teak wood", "Tiger wood", "Mahogany wood"];
        const isRoot = ref(false);
        const selectedCategory = ref("");
        let tempUrl = ref("");

        const form = ref(
            useForm({
                image: props.SelectedFurniture.image,
                code: props.SelectedFurniture.code,
                description: props.SelectedFurniture.description,
                category: props.SelectedFurniture.category,
                woodtype: props.SelectedFurniture.wood_type,
                width: props.SelectedFurniture.width,
                depth: props.SelectedFurniture.width,
                height: props.SelectedFurniture.height,
                stock: props.SelectedFurniture.stock,
                price: props.SelectedFurniture.price,
            })
        );

        console.log(props.SelectedFurniture.wood_type);

        const submit = () => {
            form.post(route("input.update"));
        };

        return {
            form,
            radioCode,
            categories,
            notRootType,
            isRoot,
            selectedCategory,
            tempUrl,
        };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        setImage(event) {
            const file = event.target.files;
            this.form.image = file[0];
            this.tempUrl = URL.createObjectURL(this.form.image);
            console.log(this.tempUrl);
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
    },
};
</script>

<style scoped>
.modal {
    width: 400px;
    padding: 20px;
    margin: 100px auto;
    background: white;
    border-radius: 10px;
    text-align: center;
}
.backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
}
</style>
