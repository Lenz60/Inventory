<template>
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
            </div>
            <div class="flex flex-row">
                <div class="w-full">
                    <div v-if="!filename">
                        <div class="pb-5">
                            <h1 class="p-2">Input Excel File</h1>
                            <input
                                type="file"
                                ref="file"
                                name="importExcel"
                                id="importExcel"
                                @change="onFileSelected"
                                class="file-input file-input-sm rounded-md file-input-bordered file-input-primary w-full max-w-xs"
                            />
                        </div>
                    </div>
                    <div v-else>
                        <h1>{{ filename }}</h1>
                        <button
                            class="btn m-4 px-10 btn-success"
                            :disabled="form.processing"
                            @click="xlsToLaravel(excelImport)"
                        >
                            Import
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

export default {
    setup() {
        const filename = ref(false);
        const excelImport = useForm({
            file: "",
        });
        const form = useForm({});
        return { filename, excelImport, form };
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        onFileSelected(e) {
            this.filename = e.target.files[0].name;
            this.excelImport.file = e.target.files[0];
            console.log(this.filename);
        },
        xlsToLaravel(e) {
            this.excelImport.post(route("input.import"));
            this.$emit("close");
            // router.get(route("input.import"));
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
