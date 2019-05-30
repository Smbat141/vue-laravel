<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="collapse navbar-collapse text-white" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link class="nav-link text-white" :to="{path:'/'}" v-show="!auth.check">Login
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link text-white" :to="{name:'register'}" v-show="!auth.check">Register
                        </router-link>
                    </li>
                    <ul class="navbar-nav" v-show="auth.check">
                        <li class="nav-item">
                            <router-link class="nav-link text-white" :to="{name:'home'}">Home</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link text-white" :to="{name:'profile'}">Profile Page</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link
                                    class="nav-link text-white"
                                    :to="{name:'admin'}"
                                    v-show="auth.check && auth.user.roles[0].name === 'admin'"
                            >
                                Admin
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white btn " @click="logout">Log out</a>
                        </li>

                    </ul>
                </ul>
            </div>
            <div class="border rounded text-white" v-show="auth.check">
                <span>{{auth.user.name}}</span>
                <img src="https://image.flaticon.com/icons/png/512/206/206853.png" alt="" style="width: 50px;height: 50px">
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        name: "Navbar",
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
        methods: {
            logout() {
                if(window.confirm("Are you Sure")){
                    this.$store.dispatch('logout');
                    this.$router.push('/');
                }

            }
        }
    }
</script>

<style scoped>

</style>
