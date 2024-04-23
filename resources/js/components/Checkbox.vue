<script>
export default {
    name: "Checkbox",
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
        },
        label: {
            required: false,
            type: String
        },
        id: {
            required: true,
            type: String
        },
        helperText: {
            required: false,
            type: String,
        }
    },
    methods: {
        inputChange(e) {
            this.$emit("onChange", e.target.checked);
        }
    }
}
</script>

<template>
    <div :class="'flex ' + this.classes">
        <div v-if="this.helperText" class="flex items-center h-5">
            <input :id="this.id" :name="this.id" type="checkbox"
                   :value="true" @input="inputChange" :required="required" :checked="!!this.value"
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        </div>
        <div v-if="this.helperText" class="ms-2 text-sm">
            <label :for="this.id" class="font-medium text-gray-900 dark:text-gray-300">{{ this.label + (this.required ? '*' : '') }}</label>
            <p class="text-xs font-normal text-gray-500 dark:text-gray-300">{{ this.helperText }}</p>
        </div>

        <div v-if="!this.helperText" class="flex items-center mb-4">
            <input :id="this.id" :name="this.id" type="checkbox"
                   :value="true" @input="inputChange" :required="required" :checked="!!this.value"
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label :for="this.id" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ this.label + (this.required ? '*' : '') }}</label>
        </div>
    </div>
</template>
