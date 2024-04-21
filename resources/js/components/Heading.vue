<script>
export default {
    name: "Heading",
}
</script>

<template>
    <div>
        <div class="text-2xl text-gray-900 dark:text-white">
            <slot></slot>
        </div>
        <hr class="h-1 mb-8 mt-2 bg-gray-200 border-0 dark:bg-gray-700">
    </div>
</template>
