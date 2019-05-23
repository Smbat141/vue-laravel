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
                       aria-expanded="false" aria-controls="collapseExample" :href=" '#' + p.title + p.id">
                        {{p.content.substring(0,40)+"..."}}
                    </a>
                    <div class="collapse" :id="p.title + p.id" style="width:580px">
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
        {{lastPage}}
    </div>

</template>

<script>
    import Paginate from 'vuejs-paginate';
    export default {
        name: "AdminPosts",
        components:{
          Paginate,
        },
        data() {
            return {
                lastPage:0
            }
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
                if(window.confirm('Delete Post?')){
                    this.$store.dispatch('deletePost', id);
                    this.$router.go('/profile');
                }
            },
        },
        computed: {
            posts() {
                return this.$store.getters.getPosts;
            },
            paginate() {
                return this.$store.getters.paginate;
            },
            pages(){
                let pages = [];
                for(let i = this.paginate.page;i <=this.paginate.lastPage;i++){
                        pages.push(i)
                }
                return pages;
            }
        },
        created() {
            axios.get('http://127.0.0.1:8000/api/post',  {
                headers: {'Authorization': 'Bearer ' + this.$store.state.auth.user.api_token},
            }).then(res =>{
                this.$store.commit('getPosts',res.data.data);
                this.$store.commit('paginate',res.data);
                this.lastPage = res.data.last_page

            });

        },

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
