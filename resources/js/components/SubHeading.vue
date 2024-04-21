<script>
export default {
    name: "SubHeading"
}
</script>

<template>
    <div>
        <div class="text-lg text-gray-900 dark:text-white">
            <slot></slot>
        </div>
        <hr class="h-0.5 mb-8 mt-2 bg-gray-200 border-0 dark:bg-gray-700">
    </div>
</template>
