<template>
    <Head title="Manage" />

    <AuthenticatedLayout>
        <div class="flex flex-col">
            <div
                class="text-xl text-center text-neutral-content leading-tight m-5"
            >
                <h1>Admin Management</h1>
            </div>
            <div class="w-full sm:px-6 lg:px-8">
                <div class="bg-neutral overflow-hidden card">
                    <div class="flex flex-col p-2">
                        <form @submit.prevent="submit">
                            <div
                                class="bg-info-content flex flex-col card m-2 p-5"
                            >
                                <h2 class="text-center">Create new admin</h2>
                                <div class="w-full flex flex-row">
                                    <div class="w-[50%] items-center p-2">
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">Name</h1>
                                            <TextInput
                                                id="name"
                                                v-model="form.name"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.name"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Username
                                            </h1>
                                            <TextInput
                                                id="username"
                                                v-model="form.username"
                                                type="text"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.username"
                                            />
                                        </div>
                                    </div>
                                    <div class="w-[50%] items-center p-2">
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Password
                                            </h1>
                                            <TextInput
                                                id="password"
                                                v-model="form.password"
                                                type="password"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="form.errors.password"
                                            />
                                        </div>
                                        <div class="flex flex-col p-2">
                                            <h1 class="m-2 text-start">
                                                Confirm Password
                                            </h1>
                                            <TextInput
                                                id="password_confirmation"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                type="password"
                                                placeholder="Type here"
                                                class="input input-bordered input-primary w-full max-w-xs"
                                            />
                                            <InputError
                                                class="mt-2"
                                                :message="
                                                    form.errors
                                                        .password_confirmation
                                                "
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button
                                        class="btn m-4 px-10 btn-primary"
                                        :disabled="form.processing"
                                    >
                                        <div v-if="form.processing">
                                            <span
                                                class="loading loading-spinner loading-sm text-primary"
                                                >Create</span
                                            >
                                        </div>
                                        <div v-else>
                                            <span>Create</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="bg-primary-content card m-2 p-5">
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <!-- head -->
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- row 1 -->
                                        <tr
                                            v-for="(admin, no) in admins"
                                            class="hover:bg-neutral"
                                        >
                                            <td>{{ no + 1 }}</td>
                                            <td>{{ admin.username }}</td>
                                            <td>{{ admin.name }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-outline btn-error"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- row 2 -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="p-6 text-neutral-content">
                        You're logged in!
                    </div>
                    <div class="p-6 text-neutral-content">
                        Hello Master Admin
                    </div> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head } from "@inertiajs/vue3";
import { useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { onUpdated } from "vue";
export default {
    props: ["admins", "success"],
    components: {
        AuthenticatedLayout,
        TextInput,
        InputError,
        Head,
    },
    setup(props) {
        const form = useForm({
            username: "",
            name: "",
            password: "",
            password_confirmation: "",
        });

        onUpdated(() => {
            if (usePage().props.flash.message == "admin:200") {
                Swal.fire({
                    icon: "success",
                    title: "Your work has been saved",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        });

        const submit = () => {
            form.post(route("manage.create"));
        };
        return { form, submit };
    },
};
</script>

<style lang="scss" scoped></style>
