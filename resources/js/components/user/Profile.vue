<template>
    <div class="container mt-1">
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
    </div>
</template>

<script>
    export default {
        name: "Profile",
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
        methods:{

        }

    }
</script>

<style scoped>

</style>
