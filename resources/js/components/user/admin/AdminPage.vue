<template>
    <div>
        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="'admin/posts'">Posts</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="#">Disabled</a>
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
        name: "AdminPage"
    }
</script>

<style scoped>

</style>
