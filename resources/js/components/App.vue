<template>
    <div>
        <app-navbar></app-navbar>
        <router-view></router-view>
        <app-footer></app-footer>
    </div>
</template>

<script>

    import Navbar from "./Navbar";
    import Footer from "./Footer";

    export default {
        name: "App",
        components: {
            appNavbar: Navbar,
            appFooter: Footer
        }
    }
</script>

<style scoped>

</style>
