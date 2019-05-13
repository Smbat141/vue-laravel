<template>
    <!--<div class="container mt-1">
        <div class="row">
            <div class="col-sm-4 border border-dark" >
                <div>
                    <div class="card" style="width: 18rem;">
                        <img class="card-img-top"
                             src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTxt7tq4P4vK_A6COzdeobVIVottqKJmgIUasLevSPOX6cJY1g4"
                             alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text"><b>ID:</b>{{auth.user.id}}</p>
                            <p class="card-text"><b>Name:</b>{{auth.user.name}}</p>
                            <p class="card-text"><b>Email:</b>{{auth.user.email}}</p>
                            <router-link :to="{}" class="btn btn-success">My posts</router-link>
                        </div>
                        <router-link class="btn btn-success" :to="{name:'newPost'}">Add Post</router-link>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 border border-dark">
                <div >
                    <h1>
                        Posts
                    </h1>
                </div>

            </div>
        </div>
    </div>-->
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
                                    <img class="img-fluid mx-auto d-block" :src="'./storage/' + p.image" alt="slide 4">
                                </a>
                                <span class="text-white">{{p.title}}</span>
                                <p class="text-white">{{p.content}}</p>
                                <button class="btn btn-outline-dark float-right" @click="edit">Edit</button>
                                <router-link class="btn btn-info float-right " :to="{name:'post',params:{id:p.id},query:{post:p}}">View</router-link>
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
            }
        },
            computed: {
            auth() {
                return this.$store.getters.getAuth;
            },

        },
        methods:{
            edit(){
                localStorage.setItem('editPost',this);
                this.$router.push('NewPost');
            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post',{
                headers:{
                    'Authorization':'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                console.log(res);
                this.posts = res.data;
            })
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
