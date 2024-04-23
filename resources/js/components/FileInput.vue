<script>


export default {
    name: "FileInput",
    props: {
        disabled: {
            required: false,
            type: Boolean,
            default: false,
        },
        required: {
            required: false,
            type: Boolean,
            default: false,
        },
        label: {
            required: false,
            type: String
        },
        id: {
            required: true,
            type: String
        },
        errors: {
            required: false,
            type: Array,
        },
        helperText: {
            required: false,
            type: String,
        },
        accept: {
            required: false,
            type: String,
        }
    },
    methods: {
        inputChange(e) {
            this.$emit("onChange", e.target.files[0]);
        }
    }
}
</script>

<template>
    <div>
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" :for="this.id">
            {{ this.label + (this.required ? '*' : '') }}
        </label>
        <input :id="this.id" :name="this.id" type="file" :required="this.required" :disabled="this.disabled" @change="this.inputChange" :accept="this.accept"
               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
        <p v-if="this.helperText" class="mt-1 text-sm text-gray-500 dark:text-gray-300">
            {{ this.helperText }}
        </p>
    </div>
</template>
