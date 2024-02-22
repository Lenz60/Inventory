<template>
    <div @click.self="closeModal()" class="backdrop">
        <div
            class="bg-white justify-center items-center text-center w-[80%] m-auto mt-[100px]"
        >
            <slot>
                <h1 class="text-lg text-neutral font-bold">
                    This is default content of this modal
                </h1>
                <p>there is no data passed through</p>
                <p>This is where update layout is exists</p>
            </slot>
        </div>
    </div>
</template>

<script>
export default {
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
