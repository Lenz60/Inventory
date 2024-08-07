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
                                        <th>Update payment status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr
                                        v-for="(order, no) in orders"
                                        :key="order.id"
                                        class="hover:cursor-pointer hover:bg-neutral"
                                    >
                                        <td @click="showDetailModal(order.id)">
                                            {{ no + 1 }}
                                        </td>
                                        <td @click="showDetailModal(order.id)">
                                            {{ order.name }}
                                        </td>
                                        <td @click="showDetailModal(order.id)">
                                            {{ order.id }}
                                        </td>
                                        <td @click="showDetailModal(order.id)">
                                            {{ order.track_code }}
                                        </td>
                                        <td>
                                            <select
                                                class="select select-info w-fit"
                                                v-model="order.selectedOption"
                                                @change="
                                                    // items.isSelectChanged = true
                                                    updateStatus(
                                                        $event,
                                                        order.id
                                                    )
                                                "
                                            >
                                                <option
                                                    :value="
                                                        order.payment_status
                                                    "
                                                >
                                                    {{ order.payment_status }}
                                                </option>
                                                <option
                                                    v-for="(
                                                        option, index
                                                    ) in order.filteredOptions"
                                                    :key="index"
                                                    :value="option"
                                                >
                                                    {{ option }}
                                                </option>
                                            </select>
                                        </td>
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
                :OrderItem="selectedOrderItems"
            ></DetailsModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DetailsModal from "@/Pages/Order/Modal/OrderDetails.vue";
import { router, usePage } from "@inertiajs/vue3";
import { ref, onUpdated } from "vue";
import Swal from "sweetalert2";
export default {
    components: {
        AuthenticatedLayout,
        DetailsModal,
    },
    props: ["orders", "order_items"],
    setup(props) {
        const options = ["Pending", "Paid"];
        const selectedOrderItems = ref([]);

        props.orders.forEach((order) => {
            order.selectedOption = order.payment_status;
            order.isSelectChanged = false;
            order.filteredOptions = options.filter(
                (option) => option !== order.payment_status
            );
        });
        const showModal = ref(false);

        onUpdated(() => {
            // const { props } = usePage();
            // const message = usePage().props.flash.message;
            // console.log(props.flash.message);
            if (usePage().props.flash.message == "updatePayment:200") {
                Swal.fire({
                    icon: "success",
                    title: "Order payment status updated successfully",
                    showConfirmButton: false,
                    timer: 1500,
                });
                // router.get(route("order.index"));
                //Set default message to 404 so that sweetalert not showing two times
                usePage().props.flash.message = "update:404";
            }
        });
        return { orders: props.orders, showModal, selectedOrderItems, options };
    },
    methods: {
        showDetailModal(orderId) {
            this.selectedOrderItems = this.order_items.filter(
                (item) => item.order_id === orderId
            );
            this.showModal = !this.showModal;
        },
        async updateStatus(e, Id) {
            const status = e.target.value;
            const orderId = Id.toString();

            await router.post(route("order.update"), {
                _method: "patch",
                update: "payment",
                id: orderId,
                status: status,
            });
        },
    },
};
</script>

<style lang="scss" scoped></style>
