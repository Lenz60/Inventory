<template>
    <AuthenticatedLayout>
        <Head title="Inventory Input" />
        <div class="flex flex-col text-center" data-theme="halloween">
            <div class="text-xl text-neutral-content leading-tight m-5">
                <h1>Furniture Input</h1>
            </div>
            <div class="m-5 p-3 bg-base-300 card">
                <div class="flex flex-col m-2">
                    <div class="bg-primary-content flex flex-col m-2 p-5 card">
                        <div class="p-2 flex flex-col">
                            <div>
                                <h1>Input new furnitures</h1>
                            </div>
                            <form @submit.prevent="submit">
                                <div class="p-2 flex flex-row rounded-md">
                                    <div class="w-[50%] items-center p-2">
                                        <div class="flex flex-col p-2">
                                            <div v-if="!radioCode">
                                                <div v-if="form.code">
                                                    <!-- <p>{{ form.code }} image</p> -->
                                                    <div
                                                        v-if="previewCodeImg"
                                                        class="flex flex-col items-center"
                                                    >
                                                        <img
                                                            class="w-[30%] h-[30%]"
                                                            :src="
                                                                'storage/' +
                                                                codeSelectedImg
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
                                                            Use new image
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
                                                                form.errors
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
                                                            Use stored image
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <ImageForm
                                                    @imageForm="
                                                        ExistedCodeNewImage
                                                    "
                                                ></ImageForm>
                                                <InputError
                                                    class="mt-2 text-start"
                                                    :message="form.errors.image"
                                                />
                                            </div>
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <div class="text-start">
                                                <h1 class="m-2">Code</h1>
                                            </div>
                                            <div class="flex flex-row">
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
                                                        class="mt-2 text-start"
                                                        :message="
                                                            form.errors.code
                                                        "
                                                    />
                                                </div>
                                                <div v-else>
                                                    <select
                                                        id="codeSelect"
                                                        v-model="form.code"
                                                        class="select select-md select-primary w-full max-w-xs"
                                                        @change="codeSelected()"
                                                        required
                                                    >
                                                        <option
                                                            disabled
                                                            selected
                                                        >
                                                            Existing Code
                                                        </option>
                                                        <option
                                                            v-for="(
                                                                code, index
                                                            ) in furnitureCode"
                                                            :key="index"
                                                        >
                                                            {{ code }}
                                                        </option>
                                                    </select>
                                                    <InputError
                                                        class="mt-2 text-start"
                                                        :message="
                                                            form.errors.code
                                                        "
                                                    />
                                                </div>
                                                <!-- Radio Group -->
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
                                                        <label class="ml-2"
                                                            >New data</label
                                                        >
                                                    </div>
                                                    <div class="flex flex-row">
                                                        <input
                                                            type="radio"
                                                            name="radioCode"
                                                            class="radio radio-sm radio-primary bg-inherit enabled:hover:border-info enabled:checked:bg-primary"
                                                            value="exist"
                                                            @change="onChange()"
                                                        />
                                                        <label class="ml-2"
                                                            >Existing
                                                            data</label
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Description
                                            </h1>
                                            <TextInput
                                                id="description"
                                                v-model="form.description"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
                                                :message="
                                                    form.errors.description
                                                "
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Category
                                            </h1>
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
                                                class="mt-2 text-start"
                                                :message="form.errors.category"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Wood Type
                                            </h1>
                                            <select
                                                id="woodtype"
                                                v-model="form.woodtype"
                                                class="select select-md select-primary w-full max-w-xs"
                                            >
                                                <option
                                                    v-if="isRoot"
                                                    value="Root"
                                                    selected
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
                                                :message="form.errors.woodtype"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
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
                                                :message="form.errors.color"
                                            />
                                        </div>
                                    </div>
                                    <div class="w-[50%] items-center p-2">
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Width
                                            </h1>
                                            <input
                                                id="width"
                                                v-model="form.width"
                                                type="number"
                                                placeholder="0"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
                                                :message="form.errors.width"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Length
                                            </h1>
                                            <input
                                                id="length"
                                                v-model="form.length"
                                                type="number"
                                                placeholder="0"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
                                                :message="form.errors.length"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Height
                                            </h1>
                                            <input
                                                id="height"
                                                v-model="form.height"
                                                type="number"
                                                placeholder="0"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
                                                :message="form.errors.height"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Stock
                                            </h1>
                                            <input
                                                id="stock"
                                                v-model="form.stock"
                                                type="number"
                                                placeholder="0"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
                                                :message="form.errors.stock"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Price
                                            </h1>
                                            <input
                                                id="price"
                                                v-model="form.price"
                                                type="number"
                                                placeholder="0"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2 text-start"
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
                            <div>
                                <!-- <div v-if="filename == ''"> -->
                                <button
                                    type="button"
                                    class="btn m-4 px-10 btn-success"
                                    :disabled="form.processing"
                                    @click="toggleImportModal()"
                                >
                                    Import
                                </button>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="bg-primary-content card m-2 p-5">
                        <div class="flex justify-end">
                            <div
                                class="w-fit input input-bordered flex items-center gap-2 h-fit"
                            >
                                <input
                                    v-model="search"
                                    type="text"
                                    class="grow input"
                                    placeholder="Search"
                                />
                                <div @click="">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16"
                                        fill="currentColor"
                                        class="w-4 h-4 opacity-70"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="selectedFurnitures.length > 0"
                            class="flex justify-start p-2"
                        >
                            <button class="btn btn-error" @click="bulkDelete">
                                Bulk Delete
                            </button>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-control">
                                                <input
                                                    type="checkbox"
                                                    @change="
                                                        selectAllFurnitures(
                                                            filteredItems
                                                        )
                                                    "
                                                    v-model="selectAll"
                                                    class="checkbox checkbox-sm checkbox-primary bg-transparent"
                                                />
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Wood Type</th>
                                        <th>Width</th>
                                        <th>length</th>
                                        <th>Height</th>
                                        <th>Stock</th>
                                        <th>Color</th>
                                        <th>Price</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(furniture, no) in filteredItems"
                                        class="hover:bg-neutral"
                                    >
                                        <td>
                                            <div class="form-control">
                                                <input
                                                    type="checkbox"
                                                    class="checkbox checkbox-sm checkbox-primary bg-transparent"
                                                    :checked="selectAll"
                                                    @change="
                                                        selectDelete(furniture)
                                                    "
                                                />
                                            </div>
                                        </td>
                                        <td>{{ no + 1 }}</td>
                                        <!-- <td>{{ furniture.image }}</td> -->
                                        <td class="w-auto">
                                            <div
                                                v-if="
                                                    furniture.image?.includes(
                                                        'placeholder'
                                                    ) ?? 'placeholder'
                                                "
                                            >
                                                <div
                                                    class="w-[100px] h-[100px]"
                                                >
                                                    <img
                                                        class="w-fit h-fit"
                                                        :src="
                                                            'https://loremflickr.com/100/100/furniture?random=' +
                                                            no
                                                        "
                                                        :alt="furniture.image"
                                                    />
                                                </div>
                                            </div>
                                            <div v-else>
                                                <div
                                                    class="w-[100px] h-[100px]"
                                                >
                                                    <img
                                                        class="w-fit h-fit"
                                                        :src="
                                                            'storage/' +
                                                            furniture.image
                                                        "
                                                        :alt="furniture.image"
                                                    />
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ furniture.code }}</td>
                                        <td>{{ furniture.description }}</td>
                                        <td>{{ furniture.category }}</td>
                                        <td>{{ furniture.wood_type }}</td>
                                        <td>{{ furniture.width }}cm</td>
                                        <td>{{ furniture.length }}cm</td>
                                        <td>{{ furniture.height }}cm</td>
                                        <td>{{ furniture.stock }}</td>
                                        <td>{{ furniture.color }}</td>
                                        <td>${{ furniture.price }}</td>
                                        <td>
                                            <button
                                                class="btn btn-md btn-outline btn-info"
                                                @click="toggleModal(furniture)"
                                            >
                                                Update
                                            </button>
                                        </td>
                                        <td>
                                            <button
                                                class="btn btn-md btn-outline btn-error"
                                                @click="
                                                    deleteSelected(
                                                        furniture.uuid
                                                    )
                                                "
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
            <UpdateModal
                :Furnitures="furnitures"
                :SelectedFurniture="furniturePayload"
                :Errors="errors"
                @close="toggleModal()"
                class="w-full h-full overflow-auto"
            >
            </UpdateModal>
        </div>
        <div v-if="showImportModal">
            <ImportModal @close="toggleImportModal()"></ImportModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import NumberInput from "@/Components/NumberInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import UpdateModal from "@/Pages/Input/Modal/Update.vue";
import ImageForm from "@/Pages/Input/Components/ImageForm.vue";
import ImportModal from "@/Pages/Input/Modal/Import.vue";
import { Link, useForm, usePage, router, Head } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref, watch, computed, onUpdated, onMounted } from "vue";
import InputError from "@/Components/InputError.vue";
import { _ } from "lodash";
export default {
    components: {
        Head,
        AuthenticatedLayout,
        PrimaryButton,
        TextInput,
        NumberInput,
        InputLabel,
        InputError,
        UpdateModal,
        ImageForm,
        ImportModal,
    },
    props: ["furnitures", "errors"],
    setup(props) {
        const radioCode = ref(true);
        const typeNewCode = ref(true);
        const categories = ["Indoor", "Outdoor", "Handicraft", "Root"];
        const notRootType = ["Teak wood", "Tiger wood", "Mahogany wood"];
        const isRoot = ref(false);
        const selectedCategory = ref("");
        // const isLoading = ref(true);
        const showUpdateModal = ref(false);
        const furniturePayload = ref("");
        let tempUrl = ref("");

        const search = ref("");
        const perPage = ref("");
        const prefixAsset = "storage/";
        const selectAll = ref(false);
        const selectedFurnitures = ref([]);
        const codeSelectedImg = ref("");
        const previewCodeImg = ref(true);
        const showImportModal = ref(false);

        const prefixImage = ref("");

        onMounted(() => {
            console.log(props.furnitures);
        });
        // const excelImport = ref("");
        // const errors = ref(props.errors);
        // console.log(props.furnitures);

        const form = useForm({
            image: "",
            code: "",
            description: "",
            category: "",
            woodtype: "",
            color: "",
            width: "",
            length: "",
            height: "",
            stock: "",
            price: "",
        });

        const submit = () => {
            form.post(route("input.create"), {
                // onFinish: () => form.reset(),
            });
        };

        const furnitureCode = computed(() => {
            const codes = props.furnitures.map((furniture) => furniture.code);
            return [...new Set(codes)];
        });

        onUpdated(() => {
            if (usePage().props.flash.message == "input:200") {
                Swal.fire({
                    icon: "success",
                    title: "Furniture inputed successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
                router.get(route("input.index"));
            } else if (usePage().props.flash.message == "delete:200") {
                Swal.fire({
                    icon: "success",
                    title: "Furniture deleted successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
                router.get(route("input.index"));
                // selectedFurnitures.value = "";
                // router.get(route("input.index"));
            } else if (usePage().props.flash.message == "import:200") {
                Swal.fire({
                    icon: "success",
                    title: "Furniture imported successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });

        const filteredItems = computed(() => {
            return _.orderBy(
                props.furnitures.filter(
                    (furniture) =>
                        furniture.description
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        furniture.category
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        furniture.code
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        furniture.wood_type
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        furniture.color
                            .toLowerCase()
                            .includes(search.value.toLowerCase())
                ),
                ["created_at"],
                ["desc"]
            );
        });

        // watch(search, (value) => {
        //     router.get("/input/", { search: value });
        // });

        return {
            radioCode,
            typeNewCode,
            submit,
            form,
            categories,
            selectedCategory,
            notRootType,
            isRoot,
            showUpdateModal,
            furniturePayload,
            tempUrl,
            search,
            filteredItems,
            prefixAsset,
            selectAll,
            selectedFurnitures,
            codeSelectedImg,
            previewCodeImg,
            showImportModal,
            furnitureCode,
        };
    },
    methods: {
        setImage(event) {
            const file = event.target.files;
            this.form.image = file[0];
            //Preview Image
            this.tempUrl = URL.createObjectURL(this.form.image);
            // console.log(this.tempUrl);
        },
        ExistedCodeNewImage(n) {
            // console.log(n);
            this.form.image = n;
        },
        onChange() {
            //Change between input code manually and existing code
            this.radioCode = !this.radioCode;
            if (this.radioCode) {
                // console.log("true");
                this.form.reset("image");
                this.form.reset("code");
                this.form.reset("description");
                this.form.reset("category");
                this.form.reset("woodtype");
                this.form.reset("color");
                this.form.reset("width");
                this.form.reset("length");
                this.form.reset("height");
                this.form.reset("stock");
                this.form.reset("price");
            }
        },
        codeSelected() {
            console.log(this.form.code);
            const selectedFur = this.furnitures.filter((furniture) =>
                furniture.code
                    .toLowerCase()
                    .includes(this.form.code.toLowerCase())
            );
            console.log(selectedFur[0].category);
            this.codeSelectedImg = selectedFur[0].image;
            this.form.description = selectedFur[0].description;
            this.form.category = selectedFur[0].category;
            this.form.woodtype = selectedFur[0].wood_type;
            this.form.color = selectedFur[0].color;
            this.form.width = selectedFur[0].width;
            this.form.length = selectedFur[0].length;
            this.form.height = selectedFur[0].height;
            this.form.stock = selectedFur[0].stock;
            this.form.price = selectedFur[0].price;
            this.previewCodeImg = true;
            this.form.image = this.codeSelectedImg;
            // console.log(this.codeSelectedImg);
            console.log(this.form.image);
            // console.log(selectedFur[0].image);
        },
        uploadNewImg() {
            this.previewCodeImg = !this.previewCodeImg;
        },
        categoryChange(event) {
            //Check the selected category
            //if selected category is not root
            //then remove root from wood type
            if (event.target.options.selectedIndex > -1) {
                this.selectedCategory = event.target.value;
                if (this.selectedCategory == "Root") {
                    this.isRoot = true;
                    this.form.woodtype = "Root";
                } else {
                    this.isRoot = false;
                    this.form.woodtype = null;
                }
                // console.log(this.isRoot);
                // console.log(this.selectedCategory);
            }
            console.log(this.isRoot);
        },
        toggleModal(furniture) {
            this.showUpdateModal = !this.showUpdateModal;
            // Set the furniture data if the modal is open
            // props.errors.reset();
            if (this.showUpdateModal) {
                this.furniturePayload = {
                    uuid: furniture.uuid,
                    image: furniture.image,
                    code: furniture.code,
                    description: furniture.description,
                    category: furniture.category,
                    woodtype: furniture.wood_type,
                    color: furniture.color,
                    width: parseInt(furniture.width),
                    length: parseInt(furniture.length),
                    height: parseInt(furniture.height),
                    stock: parseInt(furniture.stock),
                    price: parseFloat(furniture.price),
                };
            }
        },
        toggleImportModal() {
            this.showImportModal = !this.showImportModal;
        },
        deleteSelected(uuid) {
            // console.log(uuid);
            Swal.fire({
                title: "Are you sure?",
                text: "The selected item will be deleted",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF8F00",
                cancelButtonColor: "#F35248",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    router.post(route("input.delete"), {
                        _method: "delete",
                        uuid: uuid,
                    });
                }
            });
            // console.log($uuid);
        },
        selectDelete(furniture) {
            const index = this.selectedFurnitures.indexOf(furniture.uuid);
            if (index === -1) {
                this.selectedFurnitures.push(furniture.uuid);
            } else {
                this.selectedFurnitures.splice(index, 1);
            }
            // console.log(this.selectedFurnitures);
        },
        bulkDelete() {
            // console.log(this.selectedFurnitures.length);
            const selectedDeletedFurnitures = this.selectedFurnitures.length;
            Swal.fire({
                title: "Are you sure?",
                text:
                    selectedDeletedFurnitures +
                    " selected item will be deleted",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#FF8F00",
                cancelButtonColor: "#F35248",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    router.post(route("input.bulkdelete"), {
                        _method: "delete",
                        uuids: this.selectedFurnitures,
                    });
                    this.selectedFurnitures.value = [];
                }
            });
        },
        selectAllFurnitures(allFurnitures) {
            // console.log(allFurnitures[0].uuid);
            // console.log(allFurnitures.map((furniture) => furniture.uuid));
            if (this.selectAll) {
                this.selectedFurnitures = allFurnitures.map(
                    (furniture) => furniture.uuid
                );
            } else {
                this.selectedFurnitures = [];
            }
        },
    },
};
</script>

<style scoped>
.swal-button {
    color: #131616;
}
</style>
