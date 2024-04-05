<template>
    <div>
        <!-- {{ tempUrl }} -->
        <div v-if="tempUrl" class="p-5">
            <h2 class="m-2">Preview Image</h2>
            <img class="m-auto w-[30%] h-[30%]" :src="tempUrl" alt="" />
        </div>
        <div class="flex flex-col">
            <h1 class="text-start m-2">Image</h1>
            <input
                id="image"
                @change="setImage"
                type="file"
                class="file-input file-input-sm rounded-md file-input-bordered file-input-primary w-full max-w-xs"
            />
            <!-- <InputError class="mt-2 text-start" :message="form.errors.image" /> -->
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
export default {
    components: {
        InputError,
    },
    setup() {
        const tempUrl = ref("");
        return { tempUrl };
    },
    methods: {
        setImage(event) {
            const file = event.target.files;
            //emit here
            this.$emit("imageForm", file[0]);
            // this.$emit("tempUrlChange", URL.createObjectURL(file[0]));
            this.tempUrl = URL.createObjectURL(file[0]);
            // this.form.image = file[0];
            // //Preview Image
            // this.tempUrl = URL.createObjectURL(this.form.image);
            // console.log(this.tempUrl);
        },
    },
};
</script>

<style lang="scss" scoped></style>
