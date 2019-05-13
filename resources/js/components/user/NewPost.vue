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
                            <input v-model="credentials.title" v-validate="'required|min:3'" type="text" name="title"
                                   class="form-control" id="title" placeholder="Title">
                        </div>
                    </div>

                </div>
                <div class="col-md-3 ">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('title')">
                            <i class="fas fa-window-close"> {{errors.first('title')}}</i>
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
                            <textarea v-validate="'required|min:5'" type="text" name="content" class="form-control"
                                      id="content" v-model="credentials.content" placeholder="Content"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('content')">
                            <i class="fas fa-window-close"> {{errors.first('content')}}</i>
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
                            <i class="fas fa-window-close"> {{errors.first('image')}}</i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success" :disabled="errors.any()" @click="addNews">
                        <i class="fa fa-user-plus">Create</i>
                    </button>
                </div>
            </div>

        </form>
        {{postEdit}}
    </div>

</template>

<script>
    import axios from 'axios'

    export default {
        name: "NewPost",
        data() {
            return {
                credentials: {
                    title: '',
                    content: '',
                    user_id: '',
                },
                categories: [],
                formData: new FormData(),
                val:'Choose file',
            }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth
            },
            postEdit(){
                return this.$store.state.editPost
            }

        },
        methods: {
            addNews() {
                for (let key in this.credentials) {
                    this.formData.append(key, this.credentials[key])
                }
                axios.post('http://127.0.0.1:8000/api/post', this.formData, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization':'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    if (res.status === 200) {
                        console.log(res);
                        this.$router.push('profile')
                    }
                })
            },
            imageUpload(event) {
                console.log(event);
                this.formData.append('image', event.target.files[0]);
            }
        },
        created() {
            let edit = localStorage.getItem('editPost');

            this.credentials.user_id = this.auth.user.id
        }
    }
</script>
