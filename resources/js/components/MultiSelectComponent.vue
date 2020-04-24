<!-- Vue SFC -->
<template>
    <div>
        <treeselect
            multiple
            v-model="model"
            :name="name"
            :options="options"
            noResultsText="Nothing found"
            placeholder=""
        ></treeselect>
    </div>
</template>

<script>
    // import the component
    import Treeselect from '@riophae/vue-treeselect'
    // import the styles
    import '@riophae/vue-treeselect/dist/vue-treeselect.css'

    export default {
        components: {Treeselect},

        props: {
            options: Array,
            name: String,
            value: Array,
        },

        data() {
            return {
                model: null,
            }
        },

        mounted() {
            // prefill old values
            this.model = this.value ? this.value : null
        }
    }
</script>
