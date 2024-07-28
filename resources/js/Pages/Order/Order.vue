<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-300 overflow-hidden shadow-sm card">
                    <div>
                        <div class="overflow-x-auto">
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Order ID</th>
                                        <th>Track code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr
                                        v-for="(order, no) in orders"
                                        :key="order.id"
                                        @click="showDetailModal"
                                        class="hover:cursor-pointer hover:bg-neutral"
                                    >
                                        <td>
                                            {{ no + 1 }}
                                        </td>
                                        <td>{{ order.name }}</td>
                                        <td>{{ order.id }}</td>
                                        <td>{{ order.track_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal">
            <DetailsModal
                @close="showDetailModal()"
                :OrderItem="order_items"
            ></DetailsModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DetailsModal from "@/Pages/Order/Modal/OrderDetails.vue";
import { ref } from "vue";
export default {
    components: {
        AuthenticatedLayout,
        DetailsModal,
    },
    props: ["orders", "order_items"],
    setup(props) {
        console.log(props.orders);
        console.log(props.order_items);
        const showModal = ref(false);
        return { showModal };
    },
    methods: {
        showDetailModal() {
            this.showModal = !this.showModal;
        },
    },
};
</script>

<style lang="scss" scoped></style>
