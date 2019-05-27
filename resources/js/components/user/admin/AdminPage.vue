<template>
    <div>
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'adminPosts'}">Posts</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{name:'adminUsers'}">Users</router-link>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="container">
                    <router-view></router-view>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "AdminPage",
        data(){
          return {
          }
        },
        computed:{

        },
        created() {

        }
    }
</script>

<style scoped>

</style>
