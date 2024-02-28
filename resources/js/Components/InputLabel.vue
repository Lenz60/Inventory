<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label class="block font-medium text-sm text-neutral-content">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
