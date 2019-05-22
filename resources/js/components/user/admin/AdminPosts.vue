<template>
    <table class="table w-75 m-auto">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Main Pictur</th>
            <th scope="col">User</th>
            <th scope="col">Functions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(p,index) in 10">
            <td>{{index}}</td>
            <td>Mark</td>
            <td>
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80"
                     alt=""
                     style="width: 50px;height: 50px"
                >
            </td>
            <td>Otto</td>
            <td>
                @mdo
            </td>
            <td>
                <span class="btn btn-outline-secondary">View</span>
                <span class="btn btn-outline-secondary">Edit</span>
                <span class="btn btn-outline-secondary">Deltete</span>
            </td>
        </tr>
        </tbody>
    </table>

</template>

<script>
    export default {
        name: "AdminPosts"
    }
</script>

<style scoped>

</style>
