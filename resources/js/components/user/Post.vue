<template>
    <div class="container w-75">

        <div class="card mb-3">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(img,index) in post.images" :class="{active:index == 0}">
                        <img class="d-block " style="width: 100%;height: 500px" :src="'./storage/' + img.path"
                             alt="Third slide">
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
                <p class="card-text">
                    <small class="text-muted">Created {{post.created_at}}</small>
                </p>
            </div>
        </div>
       <!-- <div>
            <input type="text" v-model="message" class="w-100" @keyup.enter="send" placeholder="Add Comment...">
            <div class="row text-center mt-2  " v-for="m in dataComments">
                <div class="col-sm-2 border p-2 rounded bg-secondary text-white ">
                    {{m.user}}
                </div>
                <div class="col-sm-10 border p-2 rounded">
                    {{m.message}}
                </div>
            </div>
        </div>-->
        <div class="container bg-dark">
            <textarea type="text" v-model="message" class="w-100" @keyup.enter="send" placeholder="Add Comment..."/>
            <ul class="list-group ">
                <li class="list-group-item bg-secondary text-white"  v-for="m in dataComments">
                    <span class="float-left badge badge-light  p-2">{{m.user}}</span>
                    <p class="text-center">{{m.message}}</p>
                </li>
            </ul>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Post",
        data() {
            return {
                post: {},
                message: '',
                dataComments: [],
            }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
        methods: {
            send() {
                if (this.message != '') {
                    axios({
                        method: 'get',
                        url: 'http://127.0.0.1:8000/api/comment',
                        params: {
                            message: this.message,
                            channel: this.$route.params.id,
                            user: this.auth.user.name,
                            user_id: this.auth.user.id,
                        },

                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token,
                        }
                    }).then(res => {
                        this.message = '';
                    })
                }

            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post/' + this.$route.params.id, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                if (res.status === 200) {
                    this.post = res.data;
                }
            }).catch(err => {
                console.log(err);
            })


            axios.get('http://127.0.0.1:8000/api/post/' + this.$route.params.id + '/comments ',{
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                 this.dataComments = res.data;
                 this.dataComments.reverse();
            })

        },
        mounted() {
            var socket = io('http://localhost:3000');
            socket.on("laravel_database_new-connect." + this.$route.params.id + ":App\\Events\\CommentEvent", function (data) {
                this.dataComments.push(data.message);
                this.dataComments.reverse();
            }.bind(this))
        }
    }
</script>

<style scoped>

</style>
