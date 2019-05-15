<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">

        <div class="collapse navbar-collapse text-white" id="navbarNavDropdown" >
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link class="nav-link text-white" :to="{path:'/'}" v-show="!auth.check">Login</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link text-white" :to="{name:'register'}" v-show="!auth.check">Register</router-link>
                </li>
                <li class="nav-item dropdown" v-show="auth.check">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" >
                        <router-link class="dropdown-item" :to="{name:'profile'}">Profile Page</router-link>
                        <a class="dropdown-item btn " @click="logout">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "Navbar",
        computed:{
            auth(){
                return this.$store.getters.getAuth;
            }
        },
        methods:{
            logout(){
                this.$store.dispatch('logout');
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>

</style>
