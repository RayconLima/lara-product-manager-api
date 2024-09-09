<template>
    <div :class="`p-4 text-white`" :style="`background-color: ${color}`">
        <h2 class="text-xl font-semibold">{{ title }}</h2>
        <p class="text-3xl">{{ dataCount }}</p>
    </div>
</template>
<script>
export default {
    name: "CardDash",
    props: {
        title: {
            type: String,
            default: "Card",
        },
        color: {
            type: String,
            default: "blue",
        },
        dataCount: {
            type: Number,
            default: 0,
        },
    }
}
</script>