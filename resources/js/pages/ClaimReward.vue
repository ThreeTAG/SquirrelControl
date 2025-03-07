<script>

export default {
    name: "ClaimReward",
    props: {
        token: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            username: '',
            response: null,
            error: null,
            blockInputs: false,
        }
    },
    mounted() {
        console.log(this.token);
    },
    methods: {
        claim() {
            if (!this.blockInputs) {
                console.log(this.username);
                axios
                    .post('/rewards/' + this.token + '/confirm', {
                        username: this.username,
                    })
                    .then((response) => {
                        this.response = response.data.message;
                        this.error = null;
                        this.blockInputs = true;
                        console.log(response.data);
                    })
                    .catch((error) => {
                        this.response = null;
                        this.error = [error.response.data.message];
                        this.blockInputs = false;
                        console.log(error.response);
                    });
            }
        },
    }
}
</script>

<template>
    <div>
        <heading>
            Claim your Palladium Accessories
        </heading>

        <text-input id="player_name" label="Username" v-model="username" placeholder="Your Minecraft Username"
                    :errors="this.error" :disabled="!!this.response"
                    required/>

        <div v-if="this.response" class="mt-2 text-sm text-green-600 dark:text-green-500">
            {{ this.response }}
        </div>

        <sub-heading class="mt-4"/>

        <xbutton @click="claim" :disabled="blockInputs">Claim</xbutton>
    </div>
</template>
