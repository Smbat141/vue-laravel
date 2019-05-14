<template>
    <div>
        <h1>Hello  {{auth.user.name}}</h1>
        <router-link class="btn btn-success" :to="{name:'newPost'}">Add Post</router-link>

        <div class="container-fluid bg-secondary p-3">
            <div id="carouselExample" class="carousel slide" data-ride="carousel" data-interval="9000">
                <div class="carousel-inner row w-100 mx-auto" role="listbox">
                    <div class="carousel-item col-md-3" v-for="(p,index) in posts" :class="{active:index==0}">
                        <div class="panel panel-default">
                            <div class="panel-thumbnail">
                                <a href="#" title="image 5" class="thumb">
                                    <img class="img-fluid mx-auto d-block" style="width: 300px;height: 200px" :src="'./storage/' + p.image" alt="slide 4">
                                </a>
                                <span class="text-white">{{p.title}}</span>
                                <p class="text-white">{{p.content}}</p>
                                <router-link class="btn btn-primary float-right"
                                             :to="{name:'newPost',query:{id:p.id}}"
                                             v-show="p.user_id == auth.user.id || role == 'admin'"
                                >
                                    Edit
                                </router-link>
                                <button class="btn btn-danger float-right" @click="deletePost(p.id)">Delete</button>

                                <router-link
                                        class="btn btn-info float-right"
                                        :to="{name:'post',params:{id:p.id}}"
                                >
                                    View
                                </router-link>
                            </div>
                        </div>
                    </div>

                </div>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next text-faded" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Profile",
        data() {
            return {
                posts: [],
                role:'',
            }
        },
            computed: {
            auth() {
                return this.$store.getters.getAuth;
            },
        },
        methods:{
            deletePost(id){
                axios.post('http://127.0.0.1:8000/api/post/' + id, {_method:'DELETE'}, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization':'Bearer ' + this.auth.user.api_token,
                    }}).then(res => {
                    if (res.status === 200) {
                        this.$router.go('/profile');
                    }
                })
            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post',{
                  headers:{
                      'Authorization':'Bearer ' + this.auth.user.api_token
                  }
              }).then(res => {
                  this.posts = res.data;

              })
            this.role = this.auth.user.roles[0].name;

        }

    }
</script>

<style scoped>
    @media (min-width: 768px) {

        /* show 3 items */
        .carousel-inner .active,
        .carousel-inner .active + .carousel-item,
        .carousel-inner .active + .carousel-item + .carousel-item,
        .carousel-inner .active + .carousel-item + .carousel-item + .carousel-item  {
            display: block;
        }

        .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
        .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item,
        .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item,
        .carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item + .carousel-item {
            transition: none;
        }

        .carousel-inner .carousel-item-next,
        .carousel-inner .carousel-item-prev {
            position: relative;
            transform: translate3d(0, 0, 0);
        }

        .carousel-inner .active.carousel-item + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
            position: absolute;
            top: 0;
            right: -25%;
            z-index: -1;
            display: block;
            visibility: visible;
        }

        /* left or forward direction */
        .active.carousel-item-left + .carousel-item-next.carousel-item-left,
        .carousel-item-next.carousel-item-left + .carousel-item,
        .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item,
        .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item,
        .carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
            position: relative;
            transform: translate3d(-100%, 0, 0);
            visibility: visible;
        }

        /* farthest right hidden item must be abso position for animations */
        .carousel-inner .carousel-item-prev.carousel-item-right {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            display: block;
            visibility: visible;
        }

        /* right or prev direction */
        .active.carousel-item-right + .carousel-item-prev.carousel-item-right,
        .carousel-item-prev.carousel-item-right + .carousel-item,
        .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item,
        .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item,
        .carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
            position: relative;
            transform: translate3d(100%, 0, 0);
            visibility: visible;
            display: block;
            visibility: visible;
        }

    }

    /* Bootstrap Lightbox using Modal */

    #profile-grid { overflow: auto; white-space: normal; }
    #profile-grid .profile { padding-bottom: 40px; }
    #profile-grid .panel { padding: 0 }
    #profile-grid .panel-body { padding: 15px }
    #profile-grid .profile-name { font-weight: bold; }
    #profile-grid .thumbnail {margin-bottom:6px;}
    #profile-grid .panel-thumbnail { overflow: hidden; }
    #profile-grid .img-rounded { border-radius: 4px 4px 0 0;}
</style>
