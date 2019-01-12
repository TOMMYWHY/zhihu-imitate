
<template>
    <button
            class="btn btn-success"
            v-bind:class="{'btn-success': followed}"
            v-text="text"
            v-on:click="follow"
    ></button>
</template>

<script>
    export default {
        props:['user'],

        mounted() {

            this.axios.get('/api/user/followers/'+ this.user).then(response => {
                this.followed = response.data.followed;
                // console.log(11);
                console.log(response.data);
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? 'Followed' : 'Follow User'
            }
        },
        methods:{
            follow() {
                console.log('props',this.user);
                this.axios.post('/api/user/follow',{'user':this.user}).then(response => {
                    this.followed = response.data.followed
                })
            }
        }
    }
</script>
