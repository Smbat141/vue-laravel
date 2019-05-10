<template>
    <div>
        <form class="form-signin" @submit.prevent>
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" v-validate="'email'" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus
                   v-model="email">
            <span class="text-danger" v-show="errors.has('email')">{{errors.first('email')}}</span>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" v-validate="'min:8'" name="password" id="inputPassword" class="form-control" placeholder="Password" required
                   v-model="password">
            <span class="text-danger" v-show="errors.has('password')">{{errors.first('password')}}</span>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit" :disabled="errors.any() || !isComplete" @click="login">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
        {{email}}
        {{password}}
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "Login",
        data() {
            return {
                email: '',
                password: '',
            }
        },
        methods: {
            login() {
                let url = 'http://127.0.0.1:8000/api/login';
                let data = {
                    email:this.email,
                    password:this.password
                };
                axios.post(url,data).then(response => {
                    if (response.status === 200) {
                        localStorage.setItem('user',JSON.stringify(response.data))
                        this.$router.push('profile');
                        this.$store.commit('auth',response.data)
                    }
                })
            }
        },
        computed: {
            isComplete () {
                return this.email && this.password
            }
        }
    }
</script>

<style scoped>
    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
