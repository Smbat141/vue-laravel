<template>
    <div>
        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
            <div class="card-header"><h1>Hello {{auth.user.name}}</h1></div>
            <div class="card-body">
                <router-link class="btn btn-success" :to="{name:'newPost'}">Add Post</router-link>
                <router-link class="btn btn-primary" :to="{name:'myPosts'}">My Posts</router-link>

            </div>
        </div>
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <button class="page-link" @click="previous">Previous</button>
                            </li>
                            <li class="page-item" v-for="pages in lastPage" :key="pages" @click="thisPage(pages)">
                                <button class="page-link">{{pages}}</button>
                            </li>
                            <li class="page-item">
                                <button class="page-link" @click="next">Next</button>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>
        </main>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "Profile",
        data() {
            return {
                posts: [],
                role: '',
                page: '',
                lastPage: '',
            }
        },
        computed: {
            // get auth user from vuex
            auth() {
                return this.$store.getters.getAuth;
            },
        },
        methods: {
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
            //get next page
            next() {
                if (this.page < this.lastPage) {
                    this.page++;
                    axios.get('http://127.0.0.1:8000/api/post?page=' + this.page, {
                        headers: {'Authorization': 'Bearer ' + this.auth.user.api_token}
                    }).then(response => {
                        this.posts = response.data.data
                    })
                }
            },
            //get previous page
            previous() {
                if (this.page > 1) {
                    this.page--;
                    axios.get('http://127.0.0.1:8000/api/post?page=' + this.page, {
                        headers: {'Authorization': 'Bearer ' + this.auth.user.api_token}
                    }).then(response => {
                        this.posts = response.data.data
                    })
                }
            },
            //get page where page = {page}
            thisPage(page) {
                axios.get('http://127.0.0.1:8000/api/post?page=' + page, {
                    headers: {'Authorization': 'Bearer ' + this.auth.user.api_token}
                }).then(response => {
                    this.page = response.data.current_page;
                    this.posts = response.data.data;
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
            axios.get('http://127.0.0.1:8000/api/post', {
                headers: {
                    'Authorization': 'Bearer ' + this.auth.user.api_token
                }
            }).then(res => {
                // console.log(res.data.data);
                this.posts = res.data.data;
                this.page = res.data.current_page;
                this.lastPage = res.data.last_page;

            })
            this.role = this.auth.user.roles[0].name;
        }

    }
</script>

<style scoped>

</style>
