<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <!-- {{ $page.props.auth.user }} -->

        <form @submit.prevent="submit">
            <div>
                <InputLabel
                    class="text-primary-content"
                    for="email"
                    value="Email"
                />

                <TextInput
                    id="email"
                    type="text"
                    class="mt-1 block w-full input-primary rounded-md"
                    v-model="form.email"
                    required
                    autofocus
                />

                <InputError
                    class="mt-2 text-red-600"
                    :message="form.errors.email"
                />
            </div>

            <div class="mt-4">
                <InputLabel
                    class="text-primary-content"
                    for="password"
                    value="Password"
                />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full input-primary rounded-md"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError
                    class="mt-2 text-red-600"
                    :message="form.errors.password"
                />
            </div>

            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <!-- <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link> -->

                <PrimaryButton
                    class="ms-4 bg-secondary"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
