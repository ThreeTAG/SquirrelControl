<script>
import TextInput from "../components/TextInput.vue";

export default {
    name: "AddonPackTemplateGenerator",
    components: {TextInput},
    props: {},
    data() {
        return {
            input: {
                name: '',
                description: '',
                version: '1.0.0',
                pack_id: '',
            },
            errors: {
                name: undefined,
                description: undefined,
                version: undefined,
                pack_id: undefined,
            }
        }
    },
    methods: {
        setName(name) {
            this.input.name = name;
            this.input.pack_id = name.replace(/\W+/g, " ")
                .split(/ |\B(?=[A-Z])/)
                .map(word => word.toLowerCase())
                .join('_');
        },
        save() {
            this.errors.name = !this.input.name ? ['Name is required!'] : undefined;
            this.errors.version = !this.input.version ? ['Version is required!'] : undefined;
            this.errors.pack_id = !this.input.pack_id ? ['Pack ID is required!'] : undefined;
            this.errors.description = !this.input.description ? ['Description is required!'] : undefined;

            console.log(this.errors);
            console.log((!this.errors.name && !this.errors.pack_id && !this.errors.pack_id && !this.errors.description));

            if (!this.errors.name && !this.errors.pack_id && !this.errors.pack_id && !this.errors.description) {
                window.location = window.location.origin +
                    `/template-generator/download?name=${encodeURIComponent(this.input.name)}&description=${encodeURIComponent(this.input.description)}&version=${encodeURIComponent(this.input.version)}&pack_id=${encodeURIComponent(this.input.pack_id)}`;
            }
        }
    }
}
</script>

<template>
    <div>
        <heading>
            Addon Pack Template Generator
        </heading>

        <text-input id="name" label="Name" :value="input.name" @onChange="setName" placeholder="Name of Addon Pack"
                    :errors="this.errors.name"
                    required/>
        <text-input id="pack_id" label="Pack ID" v-model="input.pack_id" :errors="this.errors.pack_id" required/>
        <text-input id="version" label="Version" v-model="input.version" placeholder="Version of Addon Pack"
                    :errors="this.errors.version" required/>
        <text-input id="description" label="Description" v-model="input.description" :errors="this.errors.description"
                    placeholder="Short Description of Addon Pack" required/>

        <sub-heading></sub-heading>

        <div class="hidden">
            <p v-for="error in this.errors">
                {{ error }}
            </p>
        </div>

        <xbutton @click="save">Generate</xbutton>
    </div>
</template>
