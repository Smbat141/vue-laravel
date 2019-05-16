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
                                   v-validate="'required'"
                                   data-vv-as="image"
                                   name="image"
                                   aria-describedby="inputGroupFileAddon01"
                                   @change="imageUpload"
                                   id="image"
                                   ref="myFiles"
                                   multiple>
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="bg-info images" v-if="url && !routeId">
                            <h5 class="text-white text-center" v-if="!Object.keys(url).length">Your images</h5>
                                <div class="row bg-light" >
                                    <div class="col-sm-3 p-2 uploadImg" v-for="u in url">
                                        <img :src="u.path" style="width:100px;height:100px"
                                             @dblclick="getImgId(u.id)">
                                        <span>
                                            <i  :class="{'fas fa-check-square':checkbox === u.id,'far fa-square':checkbox !== u.id}"></i>
                                        </span>
                                    </div>
                                </div>
                        </div>
                        <div class="bg-info images" v-else>
                            <h5 class="text-white text-center"
                                v-if="!Object.keys(url).length && !imgLength"
                            >
                                Your images
                            </h5>
                            <h5 class="text-white text-center"
                                v-else
                            >
                                Please double click to select a picture
                                <h3 v-show="imgLength">
                                    click to delete image
                                </h3>
                            </h5>

                            <div class="row m-4 bg-light" v-if="url && routeId">
                                <div class="col-sm-3 p-2 " v-for="img in credentials.images" >
                                    <img :src="'./storage/' + img.path" style="width:100px;height:100px" :alt="img.title">
                                    <i class="fas fa-minus-circle" @click="deleteImage(img.id)"></i>
                                </div>


                                <div class="col-sm-3 p-2" v-for="u in url">
                                    <img :src="u.path" @dblclick="getImgId(u.id)" style="width:100px;height:100px;border: 2px solid blue">
                                    <span>
                                            <i  :class="{'fas fa-check-square':checkbox === u.id,'far fa-square':checkbox !== u.id}"></i>
                                    </span>
                                </div>

                               <!-- <span v-if="Object.keys(url).length">{{u}}</span>
                                <span>{{credentials.mainPicture}}</span>-->
                            </div>

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
                            :disabled=" errors.any()"
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
            {{credentials.mainPicture}}
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
                    mainPicture: 0,
                },
                categories: [],
                formData: new FormData(),
                button: '',
                upload: false,
                url: [],
                files: [],
                imgId: 0,
                routeId: '',
                checkbox:'',
                imgLength:0
            }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth
            },
        },
        methods: {
            deleteImage(id){
                this.$store.dispatch('deleteImage',id)
               this.$router.go('');
            },
            getImgId(id){
                console.log(123);
                this.credentials.mainPicture = id;
                this.checkbox = id;
            },
            addNews() {
                for (let key in this.credentials) {
                    this.formData.append(key, this.credentials[key])
                }

                let id = this.$route.query.id
                if (id) {
                    axios.post('http://127.0.0.1:8000/api/post/' + id, this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token,
                        },

                    }).then(res => {
                        if (res.status === 200) {
                            console.log(res);
                            //this.$router.push('profile')
                        }
                    })
                } else {
                    console.log('store');
                    axios.post('http://127.0.0.1:8000/api/post', this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res => {
                        if (res.status === 200) {
                            this.$router.push('profile')
                        }
                    }).catch(err => {
                        console.log();
                    })
                }

            },
            imageUpload(e) {
                this.url.push({path: URL.createObjectURL(e.target.files[0]), id: this.imgId++});
                this.formData.append('imageData[]', e.target.files[0], this.imgId - 1);
            }
        },
        created() {

            let id = this.$route.query.id;
            this.routeId = this.$route.query.id;
            if (id) {
                axios.get('http://127.0.0.1:8000/api/post/' + id, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    this.button = 'update';
                    this.credentials = {...res.data};
                    this.credentials.user_id = this.auth.user.id
                    this.credentials._method = 'PUT';
                    this.edit = true
                    if(Object.keys(this.credentials.images).length) this.imgLength = true;


                })

            } else {
                this.credentials.user_id = this.auth.user.id
                this.button = 'create';
                this.$validator.validateAll().then(res => {
                    if (res) {
                        this.uploat = true
                    }
                });
            }


        },

    }
</script>
<style scoped>
    .images {
        height: auto;
        padding: 20px;
        margin-top: 20px;
        border-radius: 12px;
    }
.uploadImg:hover{
    opacity: 0.5
}
</style>
