<template>
    <div class="backdrop">
        <div
            class="bg-base-100 text-center w-[90%] h-fit m-auto mt-[3%] mb-[2%] overflow-auto rounded-md"
        >
            <div class="flex flex-col">
                <div class="text-end justify-end p-2">
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
                <div v-if="$page.props.flash.message"></div>
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <div class="border-2 border-green-400 flex flex-row">
                            <div class="border-2 border-yellow-500 m-2">
                                <p>
                                    Likewise the bounds and place of personnel
                                    training contributes to increasing the
                                    quality of existing financial and
                                    administrative conditions.
                                </p>
                            </div>
                            <div class="border-2 border-blue-500 m-2">
                                <p>
                                    However, one should not forget further
                                    development of various forms of activity
                                    allows to appreciate the value of
                                    strengthening the democratic system.
                                </p>
                            </div>
                            <!-- {{ OrderInfo }} -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["OrderInfo"],
    setup() {
        return {};
    },
    methods: {
        closeModal() {
            this.$emit("close");
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
