<template>
    <div>
        <router-link class="btn btn-success float-left mb-3" :to="{name:'newPost'}">Add Post</router-link>
        <router-link class="btn btn-primary float-left ml-3" :to="{name:'myPosts'}">My Posts</router-link>
        <table class="table w-100 m-auto" style="height:300px">

            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Main Picture</th>
                <th scope="col">User</th>
                <th scope="col">Functions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(p,index) in posts">
                <td>{{p.id}}</td>
                <td>{{p.title}}</td>
                <td>
                    <a class="btn btn-primary" data-toggle="collapse" role="button"
                       aria-expanded="false" aria-controls="collapseExample" :href=" '#' + 'id'+ p.id">
                        {{p.content.substring(0,40)+"..."}}
                    </a>
                    <div class="collapse" :id="'id' + p.id" style="width:580px">
                        <div class="card card-body">
                            {{p.content}}
                        </div>
                    </div>
                </td>
                <td>
                    <img :src="'storage/' + mainImage(p.images)"
                         alt=""
                         style="width: 50px;height: 50px"
                    >
                </td>
                <td>
                    {{p.user.name}}
                </td>
                <td>
                    <router-link class="btn btn-sm btn-outline-secondary float-right"
                                 :to="{name:'newPost',query:{id:p.id}}"
                    >
                        Edit
                    </router-link>
                    <button
                            class="btn btn-sm btn-outline-secondary float-right"
                            @click="deletePost(p.id)"
                    >
                        Delete
                    </button>
                    <router-link
                            class="btn btn-sm btn-outline-secondary float-right"
                            :to="{name:'post',params:{id:p.id}}"
                    >
                        View
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
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
    </div>

</template>

<script>
    import Paginate from 'vuejs-paginate';
    import axios from 'axios';
    export default {
        name: "AdminPosts",
        components:{
          Paginate,
        },
        data() {
            return {
                page:0,
                lastPage:0,
                posts:[]
            }
        },
        methods: {
            //paginate posts
            clickCallback (pageNum){
                axios.get('http://127.0.0.1:8000/api/post?page=' + pageNum, {
                    headers: {'Authorization': 'Bearer ' + this.$store.getters.token}
                }).then(response => {
                    this.posts = response.data.data
                })

            },
            //return image path where main = 1
            //images array in my post images
            mainImage(images) {
                return images.find(img => img.main === 1).path
            },
            // delete post where id = post.id
            deletePost(id) {
                if(window.confirm('Delete Post?')){
                    this.$store.dispatch('deletePost', id);
                    this.$router.go('/admin/posts');
                }
            },
        },
        computed: {
            paginate() {
                return this.$store.getters.paginate;
            },
        },
        created(){
            axios.get('http://127.0.0.1:8000/api/post', {
                headers: {'Authorization': 'Bearer ' + this.$store.getters.token},
            }).then(res => {
                this.posts = res.data.data;
                this.page = res.data.current_page;
                this.lastPage = res.data.last_page;
            });

        }

    }
</script>

<style lang="css" scoped>
    .page-item {
        padding: 5px 13px 5px 13px;
        border: 1px solid #dcdbde;
        margin: 2px;
    }
    .test a{
        color:white;
    }

</style>
