<template>
    <div>
        <router-link class="btn btn-success float-left mt-2" :to="{name:'newPost'}">Add Post</router-link>
        <router-link class="btn btn-primary float-left ml-1 mt-2" :to="{name:'myPosts'}">My Posts</router-link>
        <main role="main">
            <div class="album py-5 bg-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4" v-for="p in posts">
                            <div class="card mb-4 box-shadow">

                                <img class="card-img-top" style="width: 100%;height: 200px"
                                     src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png"
                                      v-if="postImages(p.images)">
                                <img class="card-img-top" style="width: 100%;height: 200px"
                                     :src="'./storage/' + mainImage(p.images)" alt="slide 4"
                                     v-else>
                                <div class="card-body ">
                                    <p>{{p.title}}</p>
                                    <p class="card-text">{{p.content.substring(0,100)+"..."}}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <router-link class="btn btn-sm btn-outline-secondary float-right"
                                                         :to="{name:'newPost',query:{id:p.id}}"
                                                         v-show="p.user_id == auth.user.id || role == 'admin'"
                                            >
                                                Edit
                                            </router-link>
                                            <button
                                                    class="btn btn-sm btn-outline-secondary float-right"
                                                    @click="deletePost(p.id)"
                                                    v-show="p.user_id === auth.user.id || role === 'admin'"
                                            >
                                                Delete
                                            </button>
                                            <router-link
                                                    class="btn btn-sm btn-outline-secondary float-right"
                                                    :to="{name:'post',params:{id:p.id}}"
                                            >
                                                View
                                            </router-link>
                                        </div>
                                        <small class="text-muted">9 mins</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <paginate
                            :page-count="4"
                            :page-range="1"
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
                </div>

            </div>
        </main>
    </div>
</template>

<script>
    import axios from 'axios';
    import Paginate from 'vuejs-paginate'

    export default {
        name: "Profile",
        data() {
            return {
            }
        },
        components:{
            Paginate,
        },
        computed: {
            // get auth user from vuex
            auth() {
                return this.$store.getters.getAuth;
            },
            paginate(){
                return this.$store.getters.paginate;
            },
            posts() {
                return this.$store.getters.getPosts;
            },
        },
        methods: {
            //paginate posts
            clickCallback (pageNum){
                console.log(pageNum)
                this.$store.dispatch('paginate',pageNum)

            },
            //return image path where main = 1
            //images array in my post images
            mainImage(images) {
                return images.find(img => img.main === 1).path
            },
            // delete post where id = post.id
            deletePost(id) {
                axios.post('http://127.0.0.1:8000/api/post/' + id, {_method: 'DELETE'}, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token,
                    }
                }).then(res => {
                    if (res.status === 200) {
                        this.$router.go('/profile');
                    }
                })
            },
            postImages(images){
              let match =  images.find(img => img.main === 1);
                if(match) {
                    return false;
                }
                return true;
            }
        },
        created() {
            this.$store.dispatch('getPosts');
            this.role = this.auth.user.roles[0].name;
        }

    }
</script>

<style>
    .page-item {
        padding: 5px 13px 5px 13px;
        border: 1px solid #dcdbde;
        margin: 2px;
    }
    .test a{
        color:white;
    }
</style>
