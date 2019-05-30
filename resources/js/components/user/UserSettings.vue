<template>
    <form>
        <div class="form-group">
            <p>Profile name -- <b>{{auth.user.name}}</b> </p>
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" :value="auth.user.email">
        </div>
        <div class="form-group">

        </div>

    </form>
</template>

<script>
    export default {
        name: "UserSettings",
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
    }
</script>

<style scoped>

</style>
