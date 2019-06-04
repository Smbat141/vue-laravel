<template>
    <div class="container">
        <div class="row border">
            <div class="col-xm-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Name <b>{{auth.user.name}}</b></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Email <small><b>{{auth.user.email}}</b></small></li>
                        <li class="list-group-item">
                            <router-link
                                    class="card-link btn btn-outline-primary"
                                    :to="{name:'userSettings'}"
                            >
                                Settings
                            </router-link>
                        </li>
                        <li class="list-group-item">
                            <router-link
                                    class="card-link btn btn-outline-primary"
                                    :to="{name:'billing'}"
                            >
                                Billing
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-8">
                <router-view></router-view>
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
    }
</script>

<style scoped>

</style>
