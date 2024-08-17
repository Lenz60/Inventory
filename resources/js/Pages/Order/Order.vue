<template>
    <Head title="Order Manager" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-300 overflow-hidden shadow-sm card">
                    <div>
                        <div class="overflow-x-auto">
                            <div class="flex justify-end p-2 m-2">
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
                            <table class="table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Region</th>
                                        <th>Track code</th>
                                        <th>Update payment status</th>
                                        <th>Invoice status</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr
                                        v-for="(order, no) in filteredItems"
                                        :key="order.id"
                                        class="hover:cursor-pointer hover:bg-neutral"
                                        @click="showDetailModal(order.id)"
                                    >
                                        <td>{{ no + 1 }}</td>
                                        <td>{{ order.name }}</td>
                                        <td>{{ order.country }}</td>
                                        <td>{{ order.region }}</td>
                                        <td>{{ order.track_code }}</td>
                                        <td>
                                            <select
                                                @click.stop
                                                :class="
                                                    order.selectedOption ===
                                                    'Paid'
                                                        ? 'select select-success w-fit'
                                                        : 'select select-info w-fit'
                                                "
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
                                        <td>{{ order.invoice_status }}</td>
                                        <td
                                            @click.stop
                                            @click="showInfoModal(order.id)"
                                        >
                                            <button class="btn btn-info">
                                                Detail Info
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
        <div v-if="itemsModal">
            <DetailsModal
                @close="showDetailModal()"
                :OrderItem="selectedOrderItems"
            ></DetailsModal>
        </div>
        <div v-if="infoModal">
            <InfoModal
                @close="showInfoModal()"
                :OrderInfo="selectedOrderInfo"
            ></InfoModal>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DetailsModal from "@/Pages/Order/Modal/OrderDetails.vue";
import InfoModal from "@/Pages/Order/Modal/OrderInfo.vue";
import { router, usePage, Head } from "@inertiajs/vue3";
import { ref, onUpdated, computed } from "vue";
import Swal from "sweetalert2";
import { _ } from "lodash";

export default {
    components: {
        AuthenticatedLayout,
        DetailsModal,
        InfoModal,
        Head,
    },
    props: ["orders", "order_items", "order_info"],
    setup(props) {
        const options = ["Pending", "Paid"];
        const selectedOrderItems = ref([]);
        const selectedOrderInfo = ref([]);
        const search = ref("");
        console.log(props.order_items);

        props.orders.forEach((order) => {
            order.selectedOption = order.payment_status;
            order.isSelectChanged = false;
            order.filteredOptions = options.filter(
                (option) => option !== order.payment_status
            );
        });
        const itemsModal = ref(false);
        const infoModal = ref(false);

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

        const filteredItems = computed(() => {
            return _.orderBy(
                props.orders.filter(
                    (order) =>
                        order.name
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        order.country
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        order.region
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        order.track_code
                            .toLowerCase()
                            .includes(search.value.toLowerCase()) ||
                        order.payment_status
                            .toLowerCase()
                            .includes(search.value.toLowerCase())
                ),
                ["created_at"],
                ["desc"]
            );
        });
        return {
            orders: props.orders,
            itemsModal,
            infoModal,
            selectedOrderItems,
            selectedOrderInfo,
            options,
            filteredItems,
            search,
        };
    },
    methods: {
        filterOrderItems(context, orderId) {
            if (context == "Detail") {
                return this.order_items.filter(
                    (item) => item.order_id === orderId
                );
            } else {
                return this.order_info.filter(
                    (info) => info.order_id === orderId
                );
            }
        },
        showDetailModal(orderId) {
            if (orderId === "") {
                this.itemsModal = !this.itemsModal;
            } else {
                this.selectedOrderItems = this.filterOrderItems(
                    "Detail",
                    orderId
                );
                this.itemsModal = !this.itemsModal;
            }
        },
        showInfoModal(orderId) {
            if (orderId === "") {
                this.infoModal = !this.infoModal;
            } else {
                this.selectedOrderInfo = this.filterOrderItems("Info", orderId);
                console.log(this.selectedOrderInfo);
                this.infoModal = !this.infoModal;
            }
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
