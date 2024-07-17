<template>
    <AuthenticatedLayout>
        <div class="m-5 p-5">
            <div class="m-5">
                <img
                    class="h-52 w-52"
                    v-if="qrCode"
                    :src="qrCode"
                    alt="QR Code"
                />
            </div>
            <button class="btn btn-success" @click="scan()">Button</button>
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
                this.intervalId = setInterval(
                    () => this.checkStatus(newId),
                    2000
                ); // checks status every 2 seconds
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
                    `http://localhost:3000/sessions/${this.id}/status`
                );
                if (statusResponse.data.status === "AUTHENTICATED") {
                    // replace 'success' with the actual success status
                    this.qrCode =
                        "https://freepngimg.com/download/success/6-2-success-png-image.png";
                    clearInterval(this.intervalId); // stop checking status once it's successful
                }
            } catch (error) {
                console.error("Error:", error);
            }
        },
        async scan() {
            try {
                const statusResponse = await axios.get(
                    `http://localhost:3000/sessions/${this.id}/status`
                );
                if (statusResponse.data.status === "AUTHENTICATED") {
                    this.qrCode =
                        "https://freepngimg.com/download/success/6-2-success-png-image.png";
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
