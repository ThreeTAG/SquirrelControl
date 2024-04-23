<script>


export default {
    name: "TextInput",
    model: {
        prop: 'value',
        event: 'onChange',
    },
    props: {
        type: {
            required: false,
            type: String,
            default: 'text',
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
        placeholder: {
            required: false,
            type: String
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
    <div>
        <label v-if="label" :for="id"
               :class="'block mb-2 text-sm font-medium' + (errors ? 'text-red-700 dark:text-red-500' : 'text-gray-900 dark:text-white')">
            {{ label + (required ? '*' : '') }}
        </label>
        <input :type="type" :id="id" :placeholder="placeholder ? placeholder : label" :required="required" :name="id"
               :value="value" @input="inputChange" :disabled="this.disabled"
               :class="errors ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500' :
               'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'">
        <p v-for="error in errors" class="mt-2 text-sm text-red-600 dark:text-red-500">{{ error }}</p>
        <p v-if="helperText" class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ helperText }}</p>
    </div>
</template>
