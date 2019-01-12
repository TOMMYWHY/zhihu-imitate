<template>
    <div id="">
        <button class="btn btn-success" @click="follow" v-text="text"></button>
    </div>
</template>

<script>
    export default {
        name: "QuestionFollowButton",
        props:['question'],

        data(){
            return{
                followed:null,
            }
        },
        computed:{
            text: function(){
                console.log('computed',this.followed);
                return this.followed ? "Followed" : "Follow";
            },
        },

        created(){
              this.axios.post('/api/questions/follower',{
                'question':this.question,
                // 'user':this.user,
            }).then(res =>{
                console.log('/api/questions/follower',res.data);
                  this.followed = res.data.followed;
            });
        },

        methods:{
            follow(){
                console.log('follow methods');
                window.axios.post('/api/questions/follow',{
                    'question':this.question,
                    // 'user':this.user,
                }).then(res =>{

                    console.log(res.data);
                    this.followed = res.data.followed;
                });
            }
        },
    }
</script>

<style scoped>

</style>