<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import backgroundImage from "../../assets/background/background.jpg";
</script>

<template>
    <div
        class="bg-fixed min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"
        data-theme="corporate"
        :style="{
            backgroundImage: `url(${backgroundImage})`,
            backgroundSize: 'cover',
        }"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-white" />
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-base-100 shadow-2xl card overflow-hidden sm:rounded-md"
        >
            <slot />
        </div>
    </div>
</template>
