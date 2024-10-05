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
                                        <td
                                            class="w-fit h-full text-center"
                                            @click.stop
                                        >
                                            <div class="flex h-full flex-col">
                                                <div>
                                                    {{ order.invoice_status }}
                                                </div>
                                                <div
                                                    class="w-full item-center justify-center flex flex-row"
                                                >
                                                    <div
                                                        v-if="statePdfLoading"
                                                        class="p-2"
                                                    >
                                                        <span
                                                            class="loading loading-spinner text-success"
                                                        ></span>
                                                    </div>
                                                    <div v-else>
                                                        <button
                                                            @click="
                                                                processInvoice(
                                                                    order.id,
                                                                    'send'
                                                                )
                                                            "
                                                            :disabled="
                                                                statePdfLoading
                                                            "
                                                            data-tip="Send/resend Invoice"
                                                            class="tooltip tooltip-info mx-2 btn btn-sm p-1 btn-ghost hover:border hover:border-primary w-fit h-fit"
                                                        >
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 512 512"
                                                                width="30"
                                                                height="30"
                                                                fill="#FFFF"
                                                            >
                                                                <path
                                                                    d="M16.1 260.2c-22.6 12.9-20.5 47.3 3.6 57.3L160 376l0 103.3c0 18.1 14.6 32.7 32.7 32.7c9.7 0 18.9-4.3 25.1-11.8l62-74.3 123.9 51.6c18.9 7.9 40.8-4.5 43.9-24.7l64-416c1.9-12.1-3.4-24.3-13.5-31.2s-23.3-7.5-34-1.4l-448 256zm52.1 25.5L409.7 90.6 190.1 336l1.2 1L68.2 285.7zM403.3 425.4L236.7 355.9 450.8 116.6 403.3 425.4z"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div
                                                        v-if="statePdfLoading"
                                                        class="p-2"
                                                    >
                                                        <span
                                                            class="loading loading-spinner text-primary"
                                                        ></span>
                                                    </div>
                                                    <div v-else>
                                                        <button
                                                            @click="
                                                                processInvoice(
                                                                    order.id,
                                                                    'download'
                                                                )
                                                            "
                                                            data-tip="Download Invoice"
                                                            class="tooltip tooltip-info w-fit h-fit btn btn-sm btn-ghost p-1 hover:border hover:border-primary"
                                                            :disabled="
                                                                statePdfLoading
                                                            "
                                                        >
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 512 512"
                                                                width="30"
                                                                height="30"
                                                                fill="#FFFF"
                                                            >
                                                                <path
                                                                    d="M64 464l48 0 0 48-48 0c-35.3 0-64-28.7-64-64L0 64C0 28.7 28.7 0 64 0L229.5 0c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3L384 304l-48 0 0-144-80 0c-17.7 0-32-14.3-32-32l0-80L64 48c-8.8 0-16 7.2-16 16l0 384c0 8.8 7.2 16 16 16zM176 352l32 0c30.9 0 56 25.1 56 56s-25.1 56-56 56l-16 0 0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-48 0-80c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24l-16 0 0 48 16 0zm96-80l32 0c26.5 0 48 21.5 48 48l0 64c0 26.5-21.5 48-48 48l-32 0c-8.8 0-16-7.2-16-16l0-128c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16l-16 0 0 96 16 0zm80-112c0-8.8 7.2-16 16-16l48 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 32 32 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-32 0 0 48c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-64 0-64z"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
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
        // console.log(props.order_items);

        const itemsModal = ref(false);
        const infoModal = ref(false);
        const statePdfLoading = ref(false);
        const stateSentPdfLoading = ref(false);

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
                //Set default message to 404 so that sweetalert not showing two times
                usePage().props.flash.message = "";
                // router.get(route("order.index"));
            } else if (usePage().props.flash.message == "noWhatsapp:404") {
                Swal.fire({
                    icon: "error",
                    title: "No Whatsapp account found",
                    text: "Please login to your whatsapp account first",
                    showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.get(route("device.index"));
                    }
                });
                statePdfLoading.value = false;
                usePage().props.flash.message = "";
            } else if (usePage().props.flash.message == "noWhatsapp:500") {
                Swal.fire({
                    icon: "error",
                    title: "Whatsapp client server is error or not available",
                    text: "Please contact the developer",
                    showConfirmButton: true,
                });
                statePdfLoading.value = false;
                usePage().props.flash.message = "";
            } else if (usePage().props.flash.message == "invoiceSent:200") {
                Swal.fire({
                    icon: "success",
                    title: "Invoice Sent",
                    text: "Invoice sent to customer",
                    showConfirmButton: false,
                    timer: 1500,
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.get(route("order.index"));
                    }
                });
                statePdfLoading.value = false;
                usePage().props.flash.message = "";
            } else if (usePage().props.flash.message == "invoiceSent:500") {
                Swal.fire({
                    icon: "error",
                    title: "Internal server error",
                    text: "Please relogin the whatsapp account",
                    showConfirmButton: false,
                    timer: 1500,
                }).then((result) => {
                    if (result.isConfirmed) {
                        router.get(route("order.index"));
                    }
                });
                statePdfLoading.value = false;
                usePage().props.flash.message = "";
            }
        });

        const filteredItems = computed(() => {
            // Set the payment status selected when changed
            props.orders.forEach((order) => {
                order.selectedOption = order.payment_status;
                order.isSelectChanged = false;
                order.filteredOptions = options.filter(
                    (option) => option !== order.payment_status
                );
            });
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
            statePdfLoading,
            stateSentPdfLoading,
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
                // console.log(this.selectedOrderInfo);
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
        async processInvoiceFunction(orderId, context) {
            const save = await router.post(route("order.invoice"), {
                _method: "post",
                context: context,
                id: orderId,
            });
        },
        async processInvoice(orderId, context) {
            if (context == "download") {
                this.statePdfLoading = true;
                const save = await this.processInvoiceFunction(
                    orderId,
                    context
                );
                if (save) {
                    this.statePdfLoading = false;
                }
            }
            this.statePdfLoading = true;
            const sent = await this.processInvoiceFunction(orderId, context);
            if (sent) {
                this.statePdfLoading = false;
            }
            // router.post(route("order.invoice"), {
            //     _method: "post",
            //     context: context,
            //     id: orderId,
            // });
        },
    },
};
</script>

<style lang="scss" scoped></style>
