<template>
    <div class="container">
        <vue-stripe-checkout
                ref="checkoutRef"
                :image="image"
                :name="name"
                :description="description"
                :currency="currency"
                :amount="amount"
                :allow-remember-me="false"
                @done="done"
        ></vue-stripe-checkout>


        <div class="text-xs-center red">
            <v-dialog
                    v-model="dialog"
                    width="500"
            >
                <v-card>
                    <v-parallax
                            src="https://cdn.vuetifyjs.com/images/backgrounds/vbanner.jpg"
                            height="200"
                    >
                        <p class="display-2 white--text">Pay $40 in month</p>
                    </v-parallax>
                    <v-card-text class="indigo white--text">
                        <button @click="checkout('sub')" class="btn btn-info">
                            <i class="fa fa-user-plus">Subscribe</i>
                        </button>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
        <form class="form-horizontal" role="form" @submit.prevent enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Create Post</h2>
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
                            @click="checkout('post')"
                            v-if="button === 'Pay to create'"
                            :disabled="credentials.checkMain < 0 || isDisabled"
                    >
                        <i class="fa fa-user-plus">{{button}}</i>
                    </button>
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
                            :disabled="errors.any() || isDisabled"
                            @click="addPost"
                            v-if="button === 'Create to free'"
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
                },
                formData: new FormData(),
                button: '',
                newFiles: [],
                imgId: 0,
                routeId: '',
                imgLength: 0,
                errorMessage: '',
                image: 'https://stripe.com/img/v3/home/social.png',
                name: 'Your Card data!',
                description: 'Please pay to create a post.',
                currency: 'USD',
                dialog: false,
                amount:500
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
            addPost() {
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
                            this.$router.push('home')
                        }
                    })
                } else {
                    axios.post('http://127.0.0.1:8000/api/post', this.formData, {
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res => {
                        if (res.status === 200) {
                            this.$router.push('home')
                        }
                    }).catch(err => {
                        //console.log();
                    })
                }

            },
            imageUpload(e) {
                let rendomName = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15)
                this.newFiles.push({path: URL.createObjectURL(e.target.files[0]), name: rendomName});
                this.formData.append('images[]', e.target.files[0], rendomName);
            },
            async checkout(subscribe) {
                const {token, args} = await this.$refs.checkoutRef.open();
                if(subscribe === 'post'){
                    this.addPost();
                    console.log(this.amount);
                }

            },
            done({token, args,}) {
                if(!this.dialog){
                    axios.post('api/payment', {token: token, amount: this.amount}, {
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + this.auth.user.api_token
                            }
                        },
                    )

                }
                else{
                    axios.post('api/user-subscribe', token, {
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer ' + this.auth.user.api_token
                            }
                        },
                    ).then(res => {
                        if(res.status === 200){
                            this.dialog = false;
                            this.button = 'Create to free'
                        }

                    })
                }
            },

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

            }
            else {
                this.credentials.user_id = this.auth.user.id;
                this.button = 'Pay to create'
                axios.get('api/user-subscriptions',{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                     if(res.data === true){
                         this.button = 'Create to free'
                     }
                     else{
                         setTimeout(function () {
                             this.dialog = true
                         }.bind(this), 1000);
                     }
                })


            }


        },
        watch:{
            dialog(){
                if(this.dialog){
                    this.amount = 4000;
                }
                else{
                    this.amount = 500;
                }
            }
        }

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


