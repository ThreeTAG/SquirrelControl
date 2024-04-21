<script>
export default {
    name: "Button",
    props: {
        type: {
            type: String,
            required: false,
            default: 'primary',
        },
        icon: {
            type: String,
            required: false,
        },
        url: {
            type: String,
            required: false,
        },
        disabled: {
            type: Boolean,
            required: false,
        },
        color: {
            type: String,
            required: false,
            default: 'blue',
        }
    },
    methods: {
        clicked() {
            this.$emit('click');

            if (this.url) {
                window.location.href = this.url;
            }
        }
    }
}
</script>

<template>
    <button type="button"
            :class="`text-white bg-${this.color}-700 hover:bg-${this.color}-800 focus:ring-4 focus:ring-${this.color}-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-${this.color}-600 dark:hover:bg-${this.color}-700 focus:outline-none dark:focus:ring-${this.color}-800` + (disabled ? 'cursor-not-allowed' : '')"
            @click="clicked">
        <i v-if="icon" :class="'fa-solid fa-' + icon"></i>
        <slot></slot>
    </button>
</template>
