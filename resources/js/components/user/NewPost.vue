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
                        <div class="bg-info images" v-if="!routeId">
                            <h5 class="text-white text-center" v-if="!newFiles.length">Your images</h5>
                            <h5 class="text-white text-center" v-else>Select your post Main picture</h5>
                            <div class="row bg-light">
                                <div class="col-sm-3 p-2 uploadImg" v-for="(img,index) in newFiles">
                                    <img :src="img.path" style="width:100px;height:100px">
                                    <i class="fas fa-minus-circle" @click="deleteImage(index,true)"></i>
                                    <div class="form-check float-right">
                                        <input class="form-check-input position-static" type="radio"
                                               id="blank" :value="img.name" v-model="credentials.checkMain"
                                               aria-label="...">
                                    </div>
                                </div>
                            </div>
                            {{credentials.pictureChecked}}
                        </div>
                        <div class="bg-info images" v-else>
                            <h5 class="text-white text-center" v-if="routeId">
                                Select your post Main picture
                                <div>OR</div>
                                Delete
                            </h5>
                            <div class="row m-4 bg-light" v-if="routeId">
                                <div class="col-sm-3 p-2 " v-for="(img,index) in credentials.images">
                                    <img :src="'./storage/' + img.path"
                                         style="width:100px;height:100px"
                                         :alt="img.title">
                                    <i class="fas fa-minus-circle" @click="deleteImage(img.id,false,index)"></i>
                                    <div class="form-check float-right">
                                        <input class="form-check-input position-static" type="radio"
                                               :value="img.id"
                                               v-model="credentials.checkMain"
                                               aria-label="...">
                                    </div>
                                </div>

                                <div class="col-sm-3 p-2"  v-for="(img,index) in newFiles" >
                                    <img :src="img.path"
                                         style="width:100px;height:100px;border: 5px solid blue"
                                         :alt="img.title"
                                    >
                                    <i class="fas fa-minus-circle" @click="deleteImage(index,true)"></i>
                                    <div class="form-check float-right">
                                        <input class="form-check-input position-static" type="radio"
                                               :value="img.name"
                                               v-model="credentials.checkMain"
                                               aria-label="...">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button
                            type="submit"
                            class="btn btn-success"
                            @click="addNews"
                            :disabled="credentials.checkMain < 0 || isDisabled"
                            v-if="button === 'create'"
                    >
                        <i class="fa fa-user-plus">Create</i>
                    </button>
                    <button
                            type="submit"
                            class="btn btn-success"
                            :disabled="errors.any() || isDisabled"
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
                    checkMain: -1,
                },
                formData: new FormData(),
                button: '',
                newFiles: [],
                imgId: 0,
                routeId: '',
                imgLength: 0,
            }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth
            },
            isDisabled: function () {
                return !this.credentials.title || !this.credentials.content;
            }
        },
        methods: {
            deleteImage(proto, newFile, ubloadIndex = null) {
                if (newFile) {
                    let images = this.formData.getAll('images[]');
                    images.map((img, i) => {
                        if (i === proto) {
                            images.splice(i, 1)
                        }
                    });
                    this.formData.delete('images[]');
                    images.forEach((key, i) => {
                        this.formData.append('images[]', key);
                    })

                    this.newFiles.map((map, i) => {
                        if (i === proto) {
                            this.newFiles.splice(i, 1)
                        }
                    })
                } else {
                    this.credentials.images.map((img, i) => {
                        if (ubloadIndex == i) {
                            this.credentials.images.splice(i, 1)
                        }
                    });
                    this.$store.dispatch('deleteImage', proto)
                }

            },
            addNews() {
                for (let key in this.credentials) {
                    this.formData.append(key, this.credentials[key])
                }

                let id = this.$route.query.id
                if (id) {
                    this.formData.delete('images');
                    axios.post('http://127.0.0.1:8000/api/post/' + id, this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token,
                        },

                    }).then(res => {
                        if (res.status === 200) {
                            this.$router.push('profile')
                        }
                    })
                }
                else {
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
                let rendomName = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
                this.newFiles.push({path: URL.createObjectURL(e.target.files[0]), name: rendomName});
                this.formData.append('images[]', e.target.files[0], rendomName);
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
                    this.credentials.user_id = this.auth.user.id;
                    this.credentials._method = 'PUT';
                    this.edit = true;
                    if (Object.keys(this.credentials.images).length) this.imgLength = true;
                })

            } else {
                this.credentials.user_id = this.auth.user.id
                this.button = 'create';

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

</style>


