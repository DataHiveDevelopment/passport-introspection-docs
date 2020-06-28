<template>
    <div>
        <button class="btn btn-primary" v-on:click="go()">Make Request</button>
        <textarea rows="5" class="form-control" onfocus="this.select();" readonly v-model="response"></textarea>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        props: {
            url: {
                type: String
            }
        },

        data() {
            return {
                response: null
            }
        },

        methods: {
            go: function () {
                axios.get(this.url)
                    .then(response => {
                        this.response = JSON.stringify(response.data);
                    });
            }
        }
    }
</script>
