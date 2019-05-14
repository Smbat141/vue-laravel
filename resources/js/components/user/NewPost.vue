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
                            <input v-model="credentials.title" v-validate="'required|min:5'" type="text" name="title"
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
                            <textarea v-validate="'required|min:30'" type="text" name="content" class="form-control"
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
                                <input type="file"
                                       class="custom-file-input"
                                       v-validate="'ext:jpg,png,bmp,svg|required'"
                                       data-vv-as="image"
                                       name="image"
                                       aria-describedby="inputGroupFileAddon01"
                                       @change="imageUpload"
                                       id="image">
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
                    <button
                            type="submit"
                            class="btn btn-success"
                            :disabled="!upload || errors.any()"
                            @click="addNews"
                            v-if="button === 'create'"
                    >
                        <i class="fa fa-user-plus">Create</i>
                    </button>
                    <button
                            type="submit"
                            class="btn btn-success"
                            :disabled="errors.any()"
                            @click="addNews"
                            v-if="button === 'update'"
                    >
                        <i class="fa fa-user-plus">Update</i>
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
        data() {
            return {
                credentials: {
                    title: '',
                    content: '',
                    user_id: '',
                },
                categories: [],
                formData: new FormData(),
                button:'',
                upload:false,
            }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth
            },

        },
        methods: {
            addNews() {
                for (let key in this.credentials) {
                    this.formData.append(key, this.credentials[key])
                }

                let id = this.$route.query.id
                if(id){
                    axios.post('http://127.0.0.1:8000/api/post/' + id, this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization':'Bearer ' + this.auth.user.api_token,
                        },

                    }).then(res => {
                        if (res.status === 200) {
                             this.$router.push('profile')
                        }
                    })
                }
                else{
                    console.log('store');
                    axios.post('http://127.0.0.1:8000/api/post', this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization':'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res => {
                        if (res.status === 200) {
                            console.log(res.data);
                            this.$router.push('profile')
                        }
                    })
                }

            },
            imageUpload(event) {
                this.upload = true
                this.formData.append('image', event.target.files[0]);
            }
        },
        created() {

            let id = this.$route.query.id

            if(id){
                axios.get('http://127.0.0.1:8000/api/post/' + id,{
                    headers:{
                        'Accept': 'application/json',
                        'Authorization':'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    this.button = 'update';
                    this.credentials = {...res.data};
                    this.credentials.user_id = this.auth.user.id
                    this.credentials._method = 'PUT';
                    this.edit = true
                })

            }
            else{
                this.credentials.user_id = this.auth.user.id
                this.button = 'create';
                 this.$validator.validateAll().then(res => {
                    console.log(res);
                    if(res){
                        this.uploat = true
                    }
                });


            }


        },

    }
</script>
