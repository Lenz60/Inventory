<template>
    <Head title="Manage" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-neutral overflow-hidden shadow-sm card">
                    <div class="p-6 text-neutral-content">
                        You're logged in!
                    </div>
                    <div class="p-6 text-neutral-content">
                        Hello Master Admin
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
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
