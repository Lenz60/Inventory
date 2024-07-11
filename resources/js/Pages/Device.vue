<template>
    <AuthenticatedLayout>
        <div class="m-5 p-5">
            <div class="m-5">
                <img v-if="qrCode" :src="qrCode" alt="QR Code" />
            </div>
            <button class="btn btn-success" @click="scan(id)">Button</button>
            <button class="btn btn-error" @click="logout()">logout</button>
            <p>
                It should be noted that the implementation of the planned tasks
                significantly conditions the creation of the step-by-step
                consistent development of the society. There's no doubt that
                social economic development requires the clarification of forms
                of influence. However, one should not forget the understanding
                of nature of resource saving technologies requires the
                clarification of new propositions.
            </p>
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
        const id = "RaflyAndrian";

        async function postSession(id) {
            const response = await fetch("http://localhost:3000/sessions/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ sessionId: id }),
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log(data);
            qrCode.value = data.qr;
        }

        // onUpdated(() => {
        //     checkStatus();
        // });

        onMounted(async () => {
            // checkStatus();
            // console.log(statusResponse.data);
            try {
                const res = await axios.get(
                    `http://localhost:3000/sessions/RaflyAndrian/status`
                );
                statusResponse = res;
                if (statusResponse.data.status == "AUTHENTICATED") {
                    qrCode.value =
                        "https://freepngimg.com/download/success/6-2-success-png-image.png";
                    // location.reload();
                } else {
                }
            } catch (error) {
                // postSession("RaflyAndrian"); // replace 'your-session-id' with your actual session ID
                console.error("Error fetching status:", error);
            }
        });

        return { qrCode, statusResponse, id };
    },
    methods: {
        // async checkStatus() {
        //     const res = await axios.get(
        //         `http://localhost:3000/sessions/RaflyAndrian/status`
        //     );
        //     this.statusResponse = res;
        //     // console.log(res);
        //     console.log(this.statusResponse.data.status);
        // },
        async scan(id) {
            const response = await fetch("http://localhost:3000/sessions/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ sessionId: id }),
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            console.log(data.qr);
            this.qrCode = data.qr;
        },
        async logout() {
            const response = await fetch(
                "http://localhost:3000/sessions/RaflyAndrian",
                {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );
        },
    },
};
</script>

<style lang="scss" scoped></style>
