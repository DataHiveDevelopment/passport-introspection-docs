<template>
    <div>
        <button v-on:click="go()">Make Request</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        methods: {
            go: function () {
                axios.get('/api/examples/user')
                    .then(response => {
                        console.log(response.data);
                    });
            }
        }
    }
</script>
