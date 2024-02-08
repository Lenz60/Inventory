<template>
    <AuthenticatedLayout>
        <div class="flex flex-col text-center">
            <div class="border-2 border-green-500 m-5">
                <h1>This is a page where you can insert and see furniture</h1>
            </div>
            <div class="border-2 border-blue-400 m-5">
                <h3>Add new data</h3>
                <div class="border-2 border-red-500 flex flex-col m-2">
                    <div
                        class="border-2 border-purple-500 flex flex-row m-2 p-5"
                    >
                        <div
                            class="border-2 border-green-500 w-[50%] items-center p-2"
                        >
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                        </div>
                        <div
                            class="border-2 border-green-500 w-[50%] items-center p-2"
                        >
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
                            <div
                                class="flex flex-row p-2 border-2 border-cyan-300"
                            >
                                <h1 class="m-2">Description:</h1>
                                <input
                                    type="text"
                                    placeholder="Type here"
                                    class="input input-bordered input-primary w-full max-w-xs"
                                />
                            </div>
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
export default {
    components: {
        AuthenticatedLayout,
    },
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
