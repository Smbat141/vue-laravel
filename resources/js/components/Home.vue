<template>
   <main role="main">
      <div class="album py-5 bg-light">
         <div class="container">
            <div class="row">
                  <post v-for="p in 10" :key="p"></post>
            </div>
         </div>
      </div>

   </main>
</template>

<script>
    import Post from "./Post";

    export default {
        name: "Home",
       components:{
           Post:Post
       }
    }
</script>

<style scoped>

</style>
