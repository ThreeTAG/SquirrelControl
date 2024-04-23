<script>

export default {
    name: "AddonPackTemplateGenerator",
    props: {},
    data() {
        return {
            input: {
                name: '',
                description: '',
                version: '1.0.0',
                pack_id: '',
                logo: undefined,
                forge_support: true,
                fabric_support: true,
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
        convertBase64(file) {
            return new Promise((resolve, reject) => {
                const fileReader = new FileReader();
                fileReader.readAsDataURL(file);

                fileReader.onload = () => {
                    resolve(fileReader.result);
                };

                fileReader.onerror = (error) => {
                    reject(error);
                };
            });
        },
        startDownload(logoBase64) {
            let url = window.location.origin + '/template-generator/download';
            let first = true;

            for (let inputKey in this.input) {
                url += first ? '?' : '&';
                first = false;

                if (inputKey === 'logo') {
                    if (logoBase64) {
                        url += `${inputKey}=${encodeURIComponent(logoBase64)}`;
                    }
                } else {
                    url += `${inputKey}=${encodeURIComponent(this.input[inputKey])}`;
                }
            }

            console.log(url);
            window.location = url;
        },
        save() {
            this.errors.name = !this.input.name ? ['Name is required!'] : undefined;
            this.errors.version = !this.input.version ? ['Version is required!'] : undefined;
            this.errors.pack_id = !this.input.pack_id ? ['Pack ID is required!'] : undefined;
            this.errors.description = !this.input.description ? ['Description is required!'] : undefined;

            if (!this.errors.name && !this.errors.pack_id && !this.errors.pack_id && !this.errors.description) {
                this.convertBase64(this.input.logo).then(result => {
                    this.startDownload(result);
                }).catch(error => {
                    this.startDownload(null);
                })
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

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <text-input id="name" label="Name" :value="input.name" @onChange="setName" placeholder="Name of Addon Pack"
                        :errors="this.errors.name"
                        required/>
            <text-input id="pack_id" label="Pack ID" v-model="input.pack_id" :errors="this.errors.pack_id" required/>
            <text-input id="version" label="Version" v-model="input.version" placeholder="Version of Addon Pack"
                        :errors="this.errors.version" required/>
            <text-input id="description" label="Description" v-model="input.description"
                        :errors="this.errors.description"
                        placeholder="Short Description of Addon Pack" required/>
        </div>

<!--        <file-input id="logo" @onChange="f => input.logo = f" label="Logo" accept="image/png"-->
<!--                    class="mb-4"></file-input>-->

        <sub-heading>Advanced</sub-heading>

        <checkbox id="forge_support" v-model="input.forge_support" label="Forge Modloading Support" class="mb-2"
                  helperText="If you package your pack as a .jar with this, Forge will be able to load it by putting it in the mods folder. Useful for publishing the pack to Modrinth."/>
        <checkbox id="fabric_support" v-model="input.fabric_support" label="Fabric Modloading Support"
                  helperText="If you package your pack as a .jar with this, Fabric will be able to load it by putting it in the mods folder. Useful for publishing the pack to Modrinth."/>

        <sub-heading class="mt-4"/>

        <div class="hidden">
            <p v-for="error in this.errors">
                {{ error }}
            </p>
        </div>

        <div class="text-sm mb-5 text-red-700">
            *Required
        </div>

        <xbutton @click="save">Generate</xbutton>
    </div>
</template>
