<template>
    <div>
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
        <button @click="checkout">Checkout</button>
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
                amount: 1000
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
            async checkout () {

                const { token, args } = await this.$refs.checkoutRef.open()

            },
            done ({token, args,}) {
                 axios.post('api/payment',{token:token,amount:this.amount},{
                    headers:{'Accept':'application/json'},
                    },
                ).then(res => {
                    console.log(res);
                })
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


