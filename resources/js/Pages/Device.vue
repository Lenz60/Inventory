<template>
    <Head title="Device Login" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-300 overflow-hidden shadow-sm card">
                    <div
                        class="p-6 text-center flex flex-col text-neutral-content"
                    >
                        <div class="">
                            <h2>Device Login</h2>
                        </div>
                        <div class="flex flex-row">
                            <div
                                class="w-[40%] text-center items-center bg-base-100 card rounded-md flex flex-col"
                            >
                                <div class="m-5 p-2">
                                    <!-- <p>{{ access }}</p> -->
                                    <div v-if="access">
                                        <img
                                            class="h-52 w-52"
                                            :src="successLogo"
                                            alt="Success Logo"
                                        />
                                    </div>
                                    <div v-else>
                                        <div v-if="qrCode">
                                            <img
                                                class="h-52 w-52"
                                                v-if="qrCode"
                                                :src="qrCode"
                                                alt="QR Code"
                                            />
                                        </div>
                                        <div v-else>
                                            <div v-if="!showErrorMessage">
                                                <span
                                                    class="loading loading-spinner loading-lg"
                                                ></span>
                                            </div>
                                            <div v-else>
                                                <h1 class="text-lg">
                                                    Failed to fetch QR code
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="access" class="p-2">
                                    <button
                                        class="btn btn-error"
                                        @click="logout()"
                                    >
                                        Logout
                                    </button>
                                </div>
                            </div>
                            <div class="w-full">
                                <div v-if="deviceName" class="p-5">
                                    <h1>Welcome {{ deviceName }}</h1>
                                    <h2>Your number is {{ deviceNumber }}</h2>
                                </div>
                                <div v-else>
                                    <h1 class="mt-5">
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
import { usePage, Head } from "@inertiajs/vue3";
import axios from "axios";
import successLogo from "../../assets/logo/success.png";
export default {
    components: {
        AuthenticatedLayout,
        Head,
        successLogo,
    },
    props: ["deviceId", "deviceName"],
    setup(props) {
        const qrCode = ref(null);
        let statusResponse = ref("");
        const id = usePage().props.auth.user.uuid;
        const access = ref(false);
        let deviceNumber = ref("");
        const showErrorMessage = ref(false);

        // const deviceName = "TheId";
        const status = ref("");
        let intervalId = null;

        if (props.deviceId) {
            deviceNumber.value = ref("+" + props.deviceId.split(":")[0]);
        } else {
            deviceNumber.value = ref(null);
        }

        // console.log(successLogo);
        // console.log(deviceNumber.value);

        return {
            qrCode,
            statusResponse,
            id,
            status,
            intervalId,
            deviceNumber,
            access,
            successLogo,
            showErrorMessage,
        };
    },
    watch: {
        id: {
            immediate: true,
            async handler(newId) {
                const scan = await this.scan(newId);
                // console.log(scan);
                if (scan) {
                    this.showErrorMessage = false;
                } else {
                    this.showErrorMessage = true;
                }
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
                    `http://localhost:3000/sessions/${this.id}/status`,
                    {
                        headers: {
                            "x-api-key": "testAPI",
                        },
                    }
                );
                if (
                    statusResponse.data.status === "connected" ||
                    statusResponse.data.status === "AUTHENTICATED"
                ) {
                    // replace 'success' with the actual success status
                    this.qrCode = "connected";
                    this.access = true;
                    // localStorage.setItem("isAuthenticated", "true"); // set the flag
                    location.reload();
                    // router.get(route("device.index"));
                    // location.reload();

                    clearInterval(this.intervalId); // stop checking status once it's successful
                }
            } catch (error) {
                // console.error("Error:", error);
                const res = await axios.post(
                    `http://localhost:3000/sessions/add`,
                    { sessionId: this.id },
                    {
                        headers: {
                            "x-api-key": "testAPI",
                        },
                    }
                );
                this.qrCode = res.data.qr;
                this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
            }
        },
        async scan() {
            try {
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.id}/status`,
                    {
                        headers: {
                            "x-api-key": "testAPI",
                        },
                    }
                );
                if (
                    statusResponse.data.status === "connected" ||
                    statusResponse.data.status === "AUTHENTICATED"
                ) {
                    this.qrCode = "connected";
                    this.access = true;
                    // router.get(route("device.index"));
                } else {
                    const res = await axios.post(
                        `http://localhost:3000/sessions/add`,
                        { sessionId: this.id },
                        {
                            headers: {
                                "x-api-key": "testAPI",
                            },
                        }
                    );
                    this.qrCode = res.data.qr;
                    this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
                }
                this.showErrorMessage = false;
                return true;
            } catch (error) {
                console.error("Error:", error.code);
                console.log(error);
                if (error.code == "ERR_NETWORK") {
                    this.showErrorMessage = true;
                } else {
                    //If the erorr is not caused by network errors, check the error of the API
                    if (
                        error.response &&
                        error.response.data.error === "Session not found"
                    ) {
                        const res = await axios.post(
                            `http://localhost:3000/sessions/add`,
                            { sessionId: this.id },
                            {
                                headers: {
                                    "x-api-key": "testAPI",
                                },
                            }
                        );
                        this.qrCode = res.data.qr;
                        this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
                    } else if (
                        error.response.data.error === "Session already exists"
                    ) {
                        this.logout();
                    }
                }
            }
            // router.get(route("device.index"));
        },

        async logout() {
            const response = await axios.delete(
                `http://localhost:3000/sessions/${this.id}`,
                { headers: { "x-api-key": "testAPI" } }
            );
            if (response) {
                location.reload();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
