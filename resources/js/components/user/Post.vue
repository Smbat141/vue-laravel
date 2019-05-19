<template>
    <div class="container w-75">

        <div class="card mb-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(img,index) in post.images" :class="{active:index == 0}">
                        <img class="d-block " style="width: 100%;height: 500px" :src="'./storage/' + img.path" alt="Third slide">
                    </div>
                </div>
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators"
                        class="active"
                        v-for="(img,index) in post.images"
                        :class="{active:index == 0}"
                        :data-slide-to="index"
                    ></li>
                </ol>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div class="card-body bg-info">
                <h5 class="card-title">{{post.title}}</h5>
                <p class="card-text">{{post.content}}</p>
                <p class="card-text"><small class="text-muted">Created {{post.created_at}}</small></p>
            </div>
        </div>
        <input type="text"  v-model="message">
        <button class="btn btn-success" @click="send">Send</button>
        {{data}}
    </div>


</template>

<script>
    import axios from 'axios';
    export default {
        name: "Post",
        data(){
            return {
                post:{},
                message:'',
                data:[],
            }
        },
        computed:{
          auth(){
              return this.$store.getters.getAuth;
          }
        },
        methods:{
            send(){
                axios({
                    method:'get',
                    url:'http://127.0.0.1:8000/comment',
                    params:{message:this.message,channel:this.$route.params.id}
                }).then(res =>{
                   /* console.log(res);
                    this.data.push(res.data)*/
                    this.message = '';
                })
            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post/' + this.$route.params.id,{
                headers:{
                    'Accept': 'application/json',
                    'Authorization':'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                if(res.status === 200){
                    this.post = res.data;
                }
            }).catch(err => {
                console.log(err);
            })
        },
        mounted() {
            var socket = io('http://localhost:3000');

            socket.on("laravel_database_new-connect." + this.$route.params.id + ":App\\Events\\CommentEvent",function (data) {
                console.log(data);
                this.data.push(data.message)
            }.bind(this))
        }
    }
</script>

<style scoped>

</style>
