<template>
    <div class="container">
        <div class="card mb-2">
            <img class="card-img-top" :src="'./storage/' + post.image"  alt="Card image cap" style="width: 100%;height: 400px">
            <div class="card-body bg-info" >
                <h5 class="card-title"></h5>
                <p class="card-text">{{post.title}}</p>
                <p class="card-text">{{post.content}}</p>
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
        created() {
            axios.get('http://127.0.0.1:8000/api/post/' + this.$route.params.id,{
                headers:{
                    'Accept': 'application/json',
                    'Authorization':'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                console.log(res);
                this.post = res.data;
            })
        }
    }
</script>

<style scoped>

</style>
