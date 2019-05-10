<template>
    <div class="container">

        <form class="form-horizontal" role="form" @submit.prevent enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Create News</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="title">Title</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <input v-model="credentials.title" v-validate="'required|min:3'" type="text" name="title" class="form-control" id="title"  placeholder="Title">
                        </div>
                    </div>

                </div>
                <div class="col-md-3 ">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('title')">
                            <i class="fas fa-window-close" > {{errors.first('title')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="content">Content</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <textarea v-validate="'required|min:5'" type="text" name="content" class="form-control" id="content" v-model="credentials.content"   placeholder="Content"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('content')">
                            <i class="fas fa-window-close" > {{errors.first('content')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="short_content">Short Content</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <textarea v-validate="'required'" type="text" name="short_content" class="form-control" id="short_content" v-model="credentials.short_content"
                                      placeholder="Description" required autofocus/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('short_content')">
                            <i class="fas fa-window-close" > {{errors.first('short_content')}}</i>
                        </span>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="category">Category</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-danger">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <select class="custom-select" name="category" id="category" v-model="credentials.category_id">
                                <option disabled value="">Categories</option>
                                <option v-for="cat in categories" :value="cat.id" :key="cat.id">{{cat.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                         <span class="text-danger align-middle" v-show="errors.has('password')">
                            <i class="fas fa-window-close" > {{errors.first('password')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="image">Image</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <input type="file" class="custom-file-input"
                                   aria-describedby="inputGroupFileAddon01" @change="imageUpload" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('image')">
                            <i class="fas fa-window-close" > {{errors.first('image')}}</i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit"  class="btn btn-success" :disabled="errors.any()" @click="addNews">
                        <i class="fa fa-user-plus">Create</i>
                    </button>
                </div>
            </div>
        </form>

    </div>

</template>

<script>
    import axios from 'axios'
    export default {
        name: "NewPost",
        data(){
            return {
                credentials: {
                    title:'',
                    content:'',
                    short_content:'',
                    user_id:0,
                    category_id:'',
                },
                categories:[],
                formData: new FormData()
            }
        },
        computed:{
        },
        methods:{
            addNews(){
                

            },
            imageUpload(event){
                this.formData.append('image', event.target.files[0]);
            }
        },
        created(){

        }
    }
</script>

<style scoped>
</style>
