<template>
    <div class="container">
        <div class="text-xs-center">
            <v-dialog
                    v-model="dialog"
                    width="500"
            >

                <v-card>
                    <v-card-title
                            class="headline blue lighten-2 justify-center"
                            primary-title
                    >
                        Warning
                    </v-card-title>
                    <v-card-text>
                       <h3>
                           You have already used your monthly plan.
                           To add a post, you must pay 1$
                       </h3>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                flat
                                @click="accept"
                        >
                            I accept
                        </v-btn>
                        <v-btn
                                color="red"
                                flat
                                @click="dialog = false"
                        >
                            Cancel
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
        <div class="alert alert-danger" role="alert" v-if="!active_card">
            To add a message, you must first add a credit card.
            <router-link class="btn btn-sml btn-outline-success" :to="{name:'payments'}">Add credit card</router-link>
        </div>
        <form v-else class="form-horizontal" role="form" @submit.prevent enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="alert alert-warning" role="alert" v-if="Object.keys(subscribe_plan.name).length === 0">
                        <h3>To create a post with your card will be paid 1$</h3>
                        <h4>If you want subscribe the plan push
                            <router-link
                                    :to="{name:'payments'}"
                                    class="btn btn-sml btn-outline-success"
                            >
                                Subscribe
                            </router-link>
                        </h4>
                    </div>
                    <div class="alert alert-info" role="alert" v-else>
                        <h3>You subscribe to Monthly plan</h3>
                    </div>
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
                                 <textarea v-validate="'required|min:30'" type="text" name="content"
                                           class="form-control"
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
                                <div class="col-sm-3 p-2 " v-for="(img,index) in newFiles">
                                    <img :src="img.path" style="width:100px;height:100px">
                                    <div class="col">
                                        <i class="fas fa-minus-circle float-right m-1"
                                           @click="deleteImage(index,true)"></i>
                                        <input class="form-check-input" type="radio"
                                               id="blank" :value="img.name" v-model="credentials.checkMain"
                                               aria-label="...">
                                    </div>
                                </div>
                            </div>
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

                                <div class="col-sm-3 p-2" v-for="(img,index) in newFiles">
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
                            :disabled="errors.any() || isDisabled"
                            @click="addPost"
                            v-if="button === 'Update'"
                    >
                        <i class="fa fa-user-plus">{{button}}</i>
                    </button>
                    <button
                            type="submit"
                            class="btn btn-success"

                            @click="addPost"
                            v-if="button === 'Create'"
                    >
                        <i class="fa fa-user-plus">{{button}}</i>
                    </button>
                </div>
            </div>
        </form>
    </div>


</template>
<script>

    import axios from 'axios';

    export default {
        name: "NewPost",
        data() {
            return {
                credentials: {
                    title: '',
                    content: '',
                    user_id: '',
                    checkMain: -1,
                    plan_id: '',
                    accept:false,
                },
                formData: new FormData(),
                button: '',
                newFiles: [],
                imgId: 0,
                routeId: '',
                imgLength: 0,
                errorMessage: '',
                customer_id: '',
                active_card: false,
                subscribe_plan: '',
                dialog:false,
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
            createPost() {
                for (let key in this.credentials) {
                    this.formData.append(key, this.credentials[key])
                }
                let id = this.$route.query.id;
                if (id) {
                    this.formData.delete('images');
                    axios.post('http://127.0.0.1:8000/api/post/' + id, this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token,
                        },

                    }).then(res => {
                        if (res.status === 200) {
                            this.$router.push('home')
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
                              if (!res.data) {
                                  console.log('return false');
                                  this.dialog = true;
                              } else {
                                  console.log('ok');
                                 // this.$router.push('home')
                              }
                            // this.$router.push('home')
                        }
                    }).catch(err => {
                        //console.log();
                    })
                }
            },
            addPost() {
                if (Object.keys(this.subscribe_plan.name).length === 0)
                    axios.post('api/create-post', {customer_id: this.customer_id}, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res => {
                        if (res.status === 200) {
                            this.createPost();
                        }
                    });
                else {
                    this.createPost();

                }

            },
            accept(){
                this.dialog = false;
                this.credentials.accept = true;
                //if user click (i accept) pay for post,then add post
                axios.post('api/create-post', {customer_id: this.customer_id}, {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    if (res.status === 200) {
                        if(res.data){
                                axios.post('http://127.0.0.1:8000/api/post', this.formData, {
                                    headers: {
                                        'Accept': 'application/json',
                                        'Authorization': 'Bearer ' + this.auth.user.api_token
                                    }
                                }).then(res => {
                                    if(res.status === 200){
                                        this.$router.push('home');
                                    }
                                })
                        }

                    }
                });

            },
            deleteImage(proto, newFile, uploadIndex = null) {
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
                        if (uploadIndex == i) {
                            this.credentials.images.splice(i, 1)
                        }
                    });
                    this.$store.dispatch('deleteImage', proto)
                }

            },
            imageUpload(e) {
                let rendomName = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
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
                    this.button = 'Update';
                    this.credentials = {...res.data.post};
                    this.credentials.user_id = this.auth.user.id;
                    this.credentials._method = 'PUT';
                    this.edit = true;
                    if (Object.keys(this.credentials.images).length) this.imgLength = true;
                })

            } else {
                this.credentials.user_id = this.auth.user.id;
                axios.get('api/user-subscriptions', {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    if (res.status === 200) {
                        if (res.data !== false) {
                            if (res.data.subscribe_plan !== false) {
                                this.subscribe_plan = res.data.subscribe_plan;
                                this.credentials.plan_id = res.data.subscribe_plan.plan_id
                            }
                            this.active_card = true;
                            this.button = 'Create';
                            this.customer_id = res.data.customer_id;
                        }
                    }
                }).catch()
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


<!--:disabled="credentials.checkMain < 0 || isDisabled"-->
