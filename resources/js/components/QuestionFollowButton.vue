<template>
    <div id="">
        <!--<button @click="follow"  class="btn  btn-success" >
            &lt;!&ndash;{{followed ? "followed" : "Haven't follow"}}&ndash;&gt;
            {{text}}
        </button>-->
        <h1>testing....</h1>
        <!--<button @click="login">xxxx</button>-->
        <p>{{msg}}</p>
        <button class="btn btn-danger"  @click="login()">login</button>

    </div>
</template>

<script>
    export default {
        name: "QuestionFollowButton",
        props:['question','user'],

        data(){
            return{
                // followed:null,
                msg:'ofadsffdaoo'
            }
        },
        computed:{
            text: function(){
                console.log('computed',this.followed);
                return this.followed ? "followed" : "Haven't follow"
            },
        },
        created(){
            this.msg = 'tommy';
            console.log(1);
            this.fetchData();
        },

        /*created(){
              //异步请求
              this.axios.post('/api/questions/follower',{
                'question':this.question,
                'user':this.user,
            }).then(res =>{
                console.log('/api/questions/follower',res.data);
                  this.followed = res.data.follow;
            });
        },*/
        methods:{
            fetchData(){
                this.axios.post('/api/questions/follower',{
                    'question':this.question,
                    'user':this.user,
                }).then(res=>{
                    console.log(res.data);
                    this.news = res.data; //此处data 是一个数组，内部存储的是对象；遍历是时使用 in
                });
            },

            login(){
                this.msg = 'tommy';
                console.log(1)
            }
        },
        /*methods:{
            onSubmit(){
                this.msg='xxx';
            },



            follow(){
                console.log(12222);
                window.axios.post('/api/questions/follow',{
                    'question':this.question,
                    'user':this.user,
                }).then(res =>{
                    console.log(res.data);
                    this.followed = res.data.followed;
                });
            }
        },*/
    }
</script>

<style scoped>

</style>