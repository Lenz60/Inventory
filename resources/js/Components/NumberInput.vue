<script setup>
import { onMounted, ref } from "vue";

const model = defineModel({
    type: Number,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute("autofocus")) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="input input-bordered input-primary w-full max-w-xs"
        v-model="model"
        ref="input"
    />
</template>
