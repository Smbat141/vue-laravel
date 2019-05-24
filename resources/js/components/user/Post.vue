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
                <h3 class="card-title">The post was created by <b>{{PostUser.name}}</b></h3>
                <h5 class="card-title">{{post.title}}</h5>
                <p class="card-text">{{post.content}}</p>
                <p class="card-text">
                    <small class="text-muted">Created {{post.created_at}}</small>
                </p>
            </div>
        </div>
        <paginate
                :page-count="lastPage"
                :page-range="page"
                :margin-pages="1"
                :click-handler="clickCallback"
                :active-class="'bg-info test'"
                :prev-text="'<<'"
                :next-text="'>>'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :prev-class="'page-item'"
                :next-class="'page-item'"
        >
        </paginate>
            <textarea type="text" v-model="message" class="w-100" @keyup.enter="send" placeholder="Add Comment..."/>
            <div class="card bg-info">
                <ul class="list-group list-group-flush bg-info" v-for="m in dataComments">
                    <li class="list-group-item w-100 text-center bg-light">
                        <div  class="float-left border-right p-3">
                            <img
                                    src="https://image.flaticon.com/icons/png/512/206/206853.png"
                                    style="width: 50px;height: 50px"
                                    class="float-left"
                            >
                            <p >{{m.user}}</p>
                        </div>
                        {{m.message}}
                    </li>
                </ul>
            </div>

    </div>
</template>

<script>
    import axios from 'axios';
    import Paginate from 'vuejs-paginate';

    export default {
        name: "Post",
        components:{
            Paginate
        },
        data() {
            return {
                post: {},
                message: '',
                dataComments: [],
                PostUser: '',
                page:0,
                lastPage:0,
                lastPageUrl: ''
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
            },
            clickCallback (pageNum){
                axios.get('http://127.0.0.1:8000/api/post/'+ this.$route.params.id + '?page=' + pageNum, {
                    headers: {'Authorization': 'Bearer ' + this.$store.getters.token}
                }).then(res => {
                    this.dataComments = []
                    res.data.comments.data.forEach(key =>{
                        this.dataComments.push({user:key.user.name,message:key.text})
                    })
                })

            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post/' + this.$route.params.id, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.user.api_token
                }
            })
               .then(res => {
                if (res.status === 200) {
                    if (res.data.post.user.id === this.auth.user.id) this.PostUser = {name: 'I am'};
                    else {this.PostUser = {name:res.data.post.user.name}}
                    this.post = res.data.post;
                    this.lastPageUrl = res.data.comments.first_page_url;
                    this.lastPage = res.data.comments.last_page;
                    this.page = res.data.comments.current_page;
                    axios.get(this.lastPageUrl, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res => {
                        res.data.comments.data.forEach(key =>{
                            this.dataComments.push({user:key.user.name,message:key.text})
                        })

                    })

                }
            }).catch(err => {
                console.log(err);
            });


        },
        mounted() {
            var socket = io('http://localhost:3000');
            socket.on("laravel_database_new-connect." + this.$route.params.id + ":App\\Events\\CommentEvent", function (data) {
                this.dataComments.unshift(data.message);
                this.$store.dispatch('sendEmail', this.PostUser.email);
            }.bind(this))
        }
    }
</script>

<style scoped>

</style>


