<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-300 overflow-hidden shadow-sm card">
                    <div
                        class="p-6 border-2 border-yellow-400 text-center flex flex-col text-neutral-content"
                    >
                        <div class="border-2 border-purple-400">
                            <h2>Device Login</h2>
                        </div>
                        <div class="border-2 border-cyan-500 flex flex-row">
                            <div
                                class="w-[40%] text-center items-center border-2 border-green-400 flex flex-col"
                            >
                                <div class="m-5 border-2 border-green-400 p-2">
                                    <div v-if="access">
                                        <img
                                            class="h-52 w-52"
                                            src="https://freepngimg.com/download/success/6-2-success-png-image.png"
                                            alt="QR Code"
                                        />
                                    </div>
                                    <div v-else>
                                        <img
                                            class="h-52 w-52"
                                            v-if="qrCode"
                                            :src="qrCode"
                                            alt="QR Code"
                                        />
                                    </div>
                                </div>
                                <div
                                    v-if="access"
                                    class="border-2 border-blue-500 p-2"
                                >
                                    <button
                                        class="btn btn-error"
                                        @click="logout()"
                                    >
                                        Logout
                                    </button>
                                </div>
                            </div>
                            <div class="w-full border-2 border-yellow-400">
                                <div v-if="deviceName" class="p-5">
                                    <h1>Welcome {{ deviceName }}</h1>
                                    <h2>Your number is {{ deviceNumber }}</h2>
                                </div>
                                <div v-else>
                                    <h1>
                                        You are not logged in <br />
                                        Please login by scanning the QR Code
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, onUpdated } from "vue";
import { usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import axios from "axios";
export default {
    components: {
        AuthenticatedLayout,
    },
    props: ["deviceId", "deviceName"],
    setup(props) {
        const qrCode = ref(null);
        let statusResponse = ref("");
        const id = usePage().props.auth.user.uuid;
        const access = ref(null);
        let deviceNumber = ref("");
        // const deviceName = "TheId";
        const status = ref("");
        let intervalId = null;

        if (props.deviceId) {
            deviceNumber = ref("+" + props.deviceId.split(":")[0]);
        } else {
            deviceNumber = ref(null);
        }

        // console.log(deviceNumber.value);

        return {
            qrCode,
            statusResponse,
            id,
            status,
            intervalId,
            deviceNumber,
            access,
        };
    },
    watch: {
        id: {
            immediate: true,
            async handler(newId) {
                const scan = await this.scan(newId);
                // if (localStorage.getItem("isAuthenticated") === "true") {
                //     // skip the status check if the user is already authenticated
                //     return;
                // }
                // if (this.intervalId) {
                //     clearInterval(this.intervalId);
                // } else {
                //     this.intervalId = setInterval(
                //         () => this.checkStatus(newId),
                //         2000
                //     ); // checks status every 2 seconds
                //     // router.get(route("device.index"));
                // }
            },
        },
    },
    beforeUnmount() {
        if (this.intervalId) {
            // router.get(route("device.index"));
            clearInterval(this.intervalId);
        }
    },
    methods: {
        async checkStatus() {
            try {
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.id}/status`
                );
                if (statusResponse.data.status === "AUTHENTICATED") {
                    // replace 'success' with the actual success status
                    this.qrCode = "AUTHENTICATED";
                    this.access = true;
                    // localStorage.setItem("isAuthenticated", "true"); // set the flag
                    location.reload();
                    // router.get(route("device.index"));
                    // location.reload();

                    clearInterval(this.intervalId); // stop checking status once it's successful
                }
            } catch (error) {
                // console.error("Error:", error);
            }
        },
        async scan() {
            try {
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.id}/status`
                );
                if (statusResponse.data.status === "AUTHENTICATED") {
                    this.qrCode = "AUTHENTICATED";
                    this.access = true;
                    // router.get(route("device.index"));
                } else {
                    const res = await axios.post(
                        `http://localhost:3000/sessions/add`,
                        { sessionId: this.id }
                    );
                    this.qrCode = res.data.qr;
                    this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
                }
                return true;
            } catch (error) {
                // console.error("Error:", error);
                if (
                    error.response &&
                    error.response.data.error === "Session not found"
                ) {
                    const res = await axios.post(
                        `http://localhost:3000/sessions/add`,
                        { sessionId: this.id }
                    );
                    this.qrCode = res.data.qr;
                    this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
                } else if (
                    error.response.data.error === "Session already exists"
                ) {
                    this.logout();
                }
            }
            // router.get(route("device.index"));
        },

        async logout() {
            const response = await axios.delete(
                `http://localhost:3000/sessions/${this.id}`
            );
            if (response) {
                location.reload();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
