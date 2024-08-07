<template>
    <!-- <div @click.self="closeModal()" class="backdrop"> -->
    <div class="backdrop">
        <div
            class="bg-base-100 text-center w-[90%] h-fit m-auto mt-[3%] mb-[2%] overflow-auto rounded-md"
        >
            <div class="flex flex-col">
                <div class="w-full px-2 pt-2 justify-end text-end">
                    <button
                        class="btn btn-sm btn-square btn-outline"
                        @click="closeModal()"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-row">
                    <div class="w-full">
                        <slot class="w-full h-full">
                            <div class="p-5 flex flex-row">
                                <div class="flex flex-col w-full">
                                    <div
                                        class="font-semibold text-xl text-neutral-content leading-tight mb-5"
                                    >
                                        <h1>Update existing data</h1>
                                    </div>
                                    <div>
                                        <form @submit.prevent="update">
                                            <div
                                                class="p-2 flex flex-row card bg-primary-content rounded-md"
                                            >
                                                <div
                                                    class="w-[50%] items-center p-2"
                                                >
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <div v-if="form.image">
                                                            <!-- <p>{{ form.code }} image</p> -->
                                                            <div
                                                                v-if="
                                                                    previewCodeImg
                                                                "
                                                                class="flex flex-col items-center"
                                                            >
                                                                <img
                                                                    class="w-[30%] h-[30%]"
                                                                    :src="
                                                                        'storage/' +
                                                                        currentImage
                                                                    "
                                                                    alt=""
                                                                />
                                                                <button
                                                                    class="mt-4 btn btn-info btn-sm w-fit"
                                                                    type="button"
                                                                    @click="
                                                                        uploadNewImg()
                                                                    "
                                                                >
                                                                    Use new
                                                                    image
                                                                </button>
                                                            </div>
                                                            <div
                                                                v-else
                                                                class="flex flex-col justify-center"
                                                            >
                                                                <ImageForm
                                                                    @imageForm="
                                                                        ExistedCodeNewImage
                                                                    "
                                                                ></ImageForm>
                                                                <InputError
                                                                    class="mt-2 text-start"
                                                                    :message="
                                                                        form
                                                                            .errors
                                                                            .image
                                                                    "
                                                                />
                                                                <button
                                                                    class="mt-4 btn w-fit btn-info btn-sm items-center"
                                                                    type="button"
                                                                    @click="
                                                                        uploadNewImg()
                                                                    "
                                                                >
                                                                    Use stored
                                                                    image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <div>
                                                            <h1
                                                                class="m-2 text-start"
                                                            >
                                                                Code
                                                            </h1>
                                                        </div>
                                                        <div
                                                            class="flex flex-row"
                                                        >
                                                            <div
                                                                v-if="radioCode"
                                                            >
                                                                <TextInput
                                                                    id="codeText"
                                                                    v-model="
                                                                        form.code
                                                                    "
                                                                    type="text"
                                                                    placeholder="Type here"
                                                                    class="input input-bordered input-primary w-full max-w-xs"
                                                                    required
                                                                />
                                                                <InputError
                                                                    class="mt-2 text-start"
                                                                    :message="
                                                                        Errors.sCode
                                                                    "
                                                                />
                                                            </div>
                                                            <div v-else>
                                                                <select
                                                                    id="codeSelect"
                                                                    v-model="
                                                                        form.code
                                                                    "
                                                                    class="select select-md select-primary w-full max-w-xs"
                                                                    required
                                                                >
                                                                    <option
                                                                        disabled
                                                                        selected
                                                                    >
                                                                        Existing
                                                                        Code
                                                                    </option>
                                                                    <option
                                                                        v-for="(
                                                                            code,
                                                                            index
                                                                        ) in furnitureCode"
                                                                        :key="
                                                                            index
                                                                        "
                                                                    >
                                                                        {{
                                                                            code
                                                                        }}
                                                                    </option>
                                                                </select>
                                                                <InputError
                                                                    class="mt-2 text-start"
                                                                    :message="
                                                                        Errors.sCode
                                                                    "
                                                                />
                                                                <!-- Radio Group -->
                                                            </div>
                                                            <div
                                                                class="ml-5 flex flex-col"
                                                            >
                                                                <div
                                                                    class="flex flex-row"
                                                                >
                                                                    <input
                                                                        type="radio"
                                                                        name="radioCode"
                                                                        class="mb-2 radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                                        value="new"
                                                                        @change="
                                                                            onChange(
                                                                                $event
                                                                            )
                                                                        "
                                                                        checked
                                                                    />
                                                                    <label
                                                                        for="radio"
                                                                        class="ml-2"
                                                                        >New
                                                                        data</label
                                                                    >
                                                                </div>
                                                                <div
                                                                    class="flex flex-row"
                                                                >
                                                                    <input
                                                                        type="radio"
                                                                        name="radioCode"
                                                                        class="radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                                        value="exist"
                                                                        @change="
                                                                            onChange(
                                                                                $event
                                                                            )
                                                                        "
                                                                    />
                                                                    <label
                                                                        for="radio"
                                                                        class="ml-2"
                                                                        >Existing
                                                                        data</label
                                                                    >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Description
                                                        </h1>
                                                        <TextInput
                                                            id="description"
                                                            v-model="
                                                                form.description
                                                            "
                                                            type="text"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sDescription
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Category
                                                        </h1>
                                                        <select
                                                            id="category"
                                                            v-model="
                                                                form.category
                                                            "
                                                            @change="
                                                                categoryChange
                                                            "
                                                            class="select select-md select-primary w-full max-w-xs"
                                                        >
                                                            <option
                                                                v-for="category in categories"
                                                            >
                                                                {{ category }}
                                                            </option>
                                                        </select>
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sCategory
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Wood Type
                                                        </h1>
                                                        <select
                                                            id="woodtype"
                                                            v-model="
                                                                form.woodtype
                                                            "
                                                            class="select select-md select-primary w-full max-w-xs"
                                                        >
                                                            <option
                                                                v-if="isRoot"
                                                                value="Root"
                                                            >
                                                                Root
                                                            </option>
                                                            <option
                                                                v-else
                                                                v-for="notRoot in notRootType"
                                                            >
                                                                {{ notRoot }}
                                                            </option>
                                                        </select>
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sWoodtype
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Color
                                                        </h1>
                                                        <TextInput
                                                            id="description"
                                                            v-model="form.color"
                                                            type="text"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sColor
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="w-[50%] items-center p-2"
                                                >
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Width
                                                        </h1>
                                                        <NumberInput
                                                            id="width"
                                                            v-model="form.width"
                                                            type="number"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                            required
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sWidth
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Length
                                                        </h1>
                                                        <NumberInput
                                                            id="length"
                                                            v-model="
                                                                form.length
                                                            "
                                                            type="number"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                            required
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sLength
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Height
                                                        </h1>
                                                        <NumberInput
                                                            id="height"
                                                            v-model="
                                                                form.height
                                                            "
                                                            type="number"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                            required
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sHeight
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Stock
                                                        </h1>
                                                        <NumberInput
                                                            id="stock"
                                                            v-model="form.stock"
                                                            type="number"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                            required
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sStock
                                                            "
                                                        />
                                                    </div>
                                                    <div
                                                        class="flex flex-col p-2"
                                                    >
                                                        <h1
                                                            class="m-2 text-start"
                                                        >
                                                            Price
                                                        </h1>
                                                        <NumberInput
                                                            id="price"
                                                            v-model="form.price"
                                                            type="number"
                                                            placeholder="Type here"
                                                            class="input input-bordered input-primary w-full max-w-xs"
                                                            required
                                                        />
                                                        <InputError
                                                            class="mt-2 text-start"
                                                            :message="
                                                                Errors.sPrice
                                                            "
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
                                                <p
                                                    v-if="
                                                        form.recentlySuccessful
                                                    "
                                                    class="text-sm text-neutral-content"
                                                >
                                                    Saved.
                                                </p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import ImageForm from "@/Pages/Input/Components/ImageForm.vue";
import { Link, useForm, router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import { onUpdated, onMounted, computed } from "vue";
import Swal from "sweetalert2";
export default {
    props: ["SelectedFurniture", "Furnitures", "message", "Errors"],
    components: {
        AuthenticatedLayout,
        PrimaryButton,
        TextInput,
        NumberInput,
        InputLabel,
        InputError,
        ImageForm,
    },
    setup(props, context) {
        const radioCode = ref(true);
        const categories = ["Indoor", "Outdoor", "Handicraft", "Root"];
        const notRootType = ["Teak wood", "Tiger wood", "Mahogany wood"];
        const isRoot = ref(false);
        const selectedCategory = ref("");
        let tempUrl = ref("");
        const previewCodeImg = ref(true);
        const currentImage = props.SelectedFurniture.image;

        // console.log(props.SelectedFurniture.color);

        // Declare props as the existing values of the input field
        let form = useForm({
            uuid: props.SelectedFurniture.uuid,
            image: props.SelectedFurniture.image,
            code: props.SelectedFurniture.code,
            description: props.SelectedFurniture.description,
            category: props.SelectedFurniture.category,
            woodtype: props.SelectedFurniture.woodtype,
            color: props.SelectedFurniture.color,
            width: parseInt(props.SelectedFurniture.width),
            length: parseInt(props.SelectedFurniture.length),
            height: parseInt(props.SelectedFurniture.height),
            stock: parseInt(props.SelectedFurniture.stock),
            price: parseFloat(props.SelectedFurniture.price),
        });

        // console.log(props.SelectedFurniture.woodtype);

        // console.log(props.Errors);

        // console.log(props.message);

        const update = () => {
            router.post(route("input.update"), {
                _method: "patch",
                sUuid: form.uuid,
                sImage: form.image,
                sCode: form.code,
                sDescription: form.description,
                sCategory: form.category,
                sWoodtype: form.woodtype,
                sColor: form.color,
                sWidth: form.width,
                sLength: form.length,
                sHeight: form.height,
                sStock: form.stock,
                sPrice: form.price,
            });
        };

        // let msg = usePage().props.flash.message;

        const furnitureCode = computed(() => {
            const codes = props.Furnitures.map((furniture) => furniture.code);
            return [...new Set(codes)];
        });
        onUpdated(() => {
            // console.log(props.errors);
            if (usePage().props.flash.message == "update:200") {
                Swal.fire({
                    icon: "success",
                    title: "Furniture updated successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
                router.get(route("input.index"));
            }
        });

        // Change the wood type to root if the selected category is root
        onMounted(() => {
            if (props.SelectedFurniture.category == "Root") {
                isRoot.value = true;
                form.woodtype = "Root";
                // console.log(isRoot.value);
            } else {
                isRoot.value = false;
                // console.log(isRoot.value);
            }
        });

        return {
            form,
            radioCode,
            categories,
            notRootType,
            isRoot,
            selectedCategory,
            tempUrl,
            update,
            previewCodeImg,
            furnitureCode,
            currentImage,
        };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        setImage(event) {
            let file = event.target.files[0];
            this.form.image = file;
            //Preview Image
            this.tempUrl = URL.createObjectURL(file);
        },
        ExistedCodeNewImage(n) {
            // console.log(n);
            this.form.image = n;
        },
        uploadNewImg() {
            this.previewCodeImg = !this.previewCodeImg;
        },
        onChange(event) {
            //Change between input code manually and existing code
            this.radioCode = !this.radioCode;
            this.form.reset("code");
        },
        woodtypeChange(event) {
            console.log(event.target.value);
        },
        categoryChange(event) {
            //Check the selected category
            //if selected category is not root
            //then remove root from wood type
            console.log(event.target.value);
            if (event.target.options.selectedIndex > -1) {
                this.selectedCategory = event.target.value;
                if (this.selectedCategory == "Root") {
                    this.isRoot = true;
                    this.form.woodtype = "Root";
                    // console.log(this.form.woodtype);
                } else {
                    this.isRoot = false;
                    this.form.woodtype = null;
                }
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
