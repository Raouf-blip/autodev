<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },
    value: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div class="card-property">
        <div class="name">{{ name }} : </div>
        <div class="value">{{ value }}</div>
    </div>
</template>
