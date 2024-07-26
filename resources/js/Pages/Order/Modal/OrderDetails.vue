<template>
    <div class="backdrop border-2 border-yellow-500">
        <div
            class="bg-base-100 text-center w-[90%] h-fit m-auto mt-[3%] mb-[2%] overflow-auto rounded-md border-2 border-green-500"
        >
            <div class="flex flex-col border-2 border-blue-400">
                <div class="text-end justify-end p-2">X</div>
                <div class="p-5">
                    <div class="collapse bg-base-200">
                        <input type="checkbox" />
                        <div class="collapse-title text-xl font-medium">
                            Click me to show/hide content
                        </div>
                        <div class="collapse-content">
                            <p>hello</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    setup() {
        return {};
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
