<template>
    <AuthenticatedLayout>
        <div class="m-5 p-5">
            <div class="m-5">
                <img v-if="qrCode" :src="qrCode" alt="QR Code" />
            </div>
            <button class="btn btn-success" @click="scan(id)">Button</button>
            <button class="btn btn-error" @click="logout()">logout</button>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, onMounted, onUpdated } from "vue";
import QRCode from "qrcode";
import axios from "axios";
export default {
    components: {
        AuthenticatedLayout,
    },
    setup() {
        const qrCode = ref(null);
        let statusResponse = ref("");
        const id = "TheId";
        const deviceName = "TheId";
        const status = ref("");
        const reloadPage = ref("");
        let intervalId = null;

        return {
            qrCode,
            statusResponse,
            id,
            deviceName,
            status,
            reloadPage,
            intervalId,
        };
    },
    watch: {
        id: {
            immediate: true,
            handler(newId) {
                const scan = this.scan(newId);
                if (this.intervalId) {
                    clearInterval(this.intervalId);
                }
                this.intervalId = setInterval(this.checkStatus, 2000); // checks status every 2 seconds
            },
        },
    },
    beforeUnmount() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    },
    methods: {
        async checkStatus() {
            try {
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.deviceName}/status`
                );
                if (statusResponse.data.status === "AUTHENTICATED") {
                    // replace 'success' with the actual success status
                    this.qrCode =
                        "https://freepngimg.com/download/success/6-2-success-png-image.png";
                    clearInterval(this.intervalId); // stop checking status once it's successful
                } else {
                }
            } catch (error) {
                console.error("Error:", error);
            }
        },
        async scan(id) {
            // console.log("here");
            try {
                //check if session is exists
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.deviceName}/status`
                );
                console.log(statusResponse.data.status);
                if (statusResponse.data.status === "AUTHENTICATED") {
                    // replace 'success' with the actual success status
                    this.qrCode =
                        "https://freepngimg.com/download/success/6-2-success-png-image.png";
                    clearInterval(this.intervalId); // stop checking status once it's successful
                } else {
                    try {
                        const res = await axios.post(
                            `http://localhost:3000/sessions/add`,
                            { sessionId: this.deviceName }
                        );
                        this.qrCode = res.data.qr;
                        //If QR code Valid or scanned and login
                        return true;
                    } catch (error) {
                        console.error("Error:", error);
                        console.log(
                            error.response.data.error ===
                                "Session already exists"
                        );
                        if (
                            error.response.data.error ===
                            "Session already exists"
                        ) {
                            this.logout();
                        }
                    }
                }
            } catch (error) {
                // this.intervalId = true;
                console.log(error.response.data.error == "Session not found");
                if (error.response.data.error == "Session not found") {
                    // console.log("here");
                    try {
                        const res = await axios.post(
                            `http://localhost:3000/sessions/add`,
                            { sessionId: this.deviceName }
                        );
                        this.qrCode = res.data.qr;
                        //If QR code Valid or scanned and login
                        return true;
                    } catch (error) {
                        console.error("Error:", error);
                    }
                }
            }
        },

        async logout() {
            const response = await axios.delete(
                `http://localhost:3000/sessions/${this.deviceName}`
            );
            if (response) {
                location.reload();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
