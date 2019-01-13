
<template>
    <button
            class="btn  btn-outline-primary"
            v-bind:class="{'btn-primary': voted}"
            v-text="text"
            v-on:click="vote"
    ></button>
</template>

<script>
    export default {
        props:['answer','count'],

        mounted() {
            this.$http.post('/api/answer/'+this.answer+'/votes/users')
                .then(res=>{
                    this.voted = res.data.voted
                });

        },
        data() {
            return {
                voted: false
            }
        },
        computed: {
            text(){
                return this.count
            }
        },
        methods:{
            vote(){
                this.$http.post('/api/answer/vote',{'answer':this.answer})
                    .then(res=>{
                        this.voted = res.data.voted;
                       res.data.voted ? this.count++ : this.count--;
                    })
            }
        }
    }
</script>
