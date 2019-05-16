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
    </div>

</template>

<script>
    import axios from 'axios';
    export default {
        name: "Post",
        data(){
            return {
                post:{}
            }
        },
        computed:{
          auth(){
              return this.$store.getters.getAuth;
          }
        },
        methods:{
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
        }
    }
</script>

<style scoped>

</style>
