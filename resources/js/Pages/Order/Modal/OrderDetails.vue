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
                <div class="p-5">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Furniture Image</th>
                                    <th>Furniture Name</th>
                                    <th>Furniture Color</th>
                                    <th>Furniture Status</th>
                                    <th>Qty Order</th>
                                    <th>Total Price</th>
                                    <th>Update Production Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- row 1 -->
                                <tr
                                    v-for="(items, no) in OrderItem"
                                    :key="items.id"
                                    class="hover:cursor-pointer hover:bg-neutral"
                                >
                                    <td>
                                        {{ no + 1 }}
                                    </td>
                                    <td>
                                        <div class="w-fit h-fit">
                                            <img
                                                class="w-20 h-20"
                                                :src="'storage/' + items.image"
                                                :alt="items.image"
                                            />
                                        </div>
                                    </td>
                                    <td>{{ items.description }}</td>
                                    <td>{{ items.color }}</td>
                                    <div v-if="items.preorder === 'true'">
                                        <td>Pre-Order</td>
                                    </div>
                                    <div v-else>
                                        <td>In Stock</td>
                                    </div>
                                    <td>{{ items.qty }}</td>
                                    <td>${{ items.total_price }}</td>
                                    <td>
                                        <select
                                            class="select select-info w-fit"
                                            v-model="items.selectedOption"
                                            @change="
                                                items.isSelectChanged = true
                                            "
                                        >
                                            <option>In Production</option>
                                            <option>Opening</option>
                                            <option>Treated</option>
                                            <option>Finishing</option>
                                            <option>Wrapped</option>
                                            <option>Shipped</option>
                                        </select>
                                        <input
                                            type="checkbox"
                                            class="checkbox checkbox-sm checkbox-info rounded-sm"
                                            v-if="items.isSelectChanged"
                                        />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    props: ["OrderItem"],
    setup(props) {
        console.log(props.OrderItem);
        props.OrderItem.forEach((item) => {
            item.selectedOption = "In Production";
            item.isSelectChanged = false;
        });
        return { OrderItem: props.OrderItem };
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
