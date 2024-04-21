<script>
export default {
    name: "SelectInput",
    model: {
        prop: 'value',
        event: 'onChange',
    },
    props: {
        classes: {
            required: false,
            type: String,
            default: '',
        },
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
        value: {
            required: true,
            type: String,
        },
        label: {
            required: false,
            type: String
        },
        id: {
            required: false,
            type: String
        },
        options: {
            required: true,
            type: Array,
        },
        errors: {
            required: false,
            type: Array,
        },
        helperText: {
            required: false,
            type: String,
        }
    },
    methods: {
        inputChange(e) {
            this.$emit("onChange", e.target.value);
        }
    }
}
</script>

<template>
    <div :class="classes">
        <label v-if="label" :for="id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ label }}</label>
        <select :id="id" :required="required" :name="id"
                :value="value" @input="inputChange"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option v-for="option in options" :key="option.id" :value="option.id" @click="inputChange">
                {{ option.label }}
            </option>
        </select>
        <p v-for="error in errors" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ error }}</p>
        <p v-if="helperText" class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ helperText }}</p>
    </div>
</template>
