<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-neutral overflow-hidden shadow-sm card">
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
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
