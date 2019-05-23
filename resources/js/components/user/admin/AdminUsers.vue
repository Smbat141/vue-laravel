<template>
    <div>
        <table class="table w-100 m-auto">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Main Picture</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(u,index) in users">
                <td>{{u.id}}</td>
                <td>{{u.name}}</td>
                <td>{{u.email}}</td>
                <td>
                    <img src="https://image.flaticon.com/icons/png/512/206/206853.png" alt=""
                         style="width: 50px;height: 50px">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "AdminUsers",
        computed: {
            users() {
                return this.$store.getters.getUsers;
            }
        },
        created() {
            this.$store.dispatch('getUsers');
        }
    }
</script>

<style scoped>

</style>
