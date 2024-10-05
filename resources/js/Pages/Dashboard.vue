<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-base-300 overflow-hidden shadow-sm card">
                    <div class="p-6 text-neutral-content">
                        You're logged in!
                    </div>
                    <div class="p-6 text-neutral-content">
                        <p>Your role is :</p>
                        <div v-if="$page.props.auth.user.role == 1">
                            <p>You are Master Admin</p>
                        </div>
                        <div v-else>
                            <p>You are regular Admin</p>
                        </div>
                        <p>
                            There are {{ orderCounts }} invoices that needs to
                            be resent
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: ["orderCounts"],
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
