import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        auth: {
            user: {},
            check: false
        },
        editPost: '',
        posts: [],
        users: [],
    },
    actions: {
        logout(context) {
            context.commit('logout')
            axios.post('http://127.0.0.1:8000/api/logout', {}, {
                headers: {'Authorization': 'Bearer ' + context.getters.token}
            })
        },
        deleteImage(context, id) {
            axios.post('http://127.0.0.1:8000/api/post/deleteImg/' + id, {'_method': 'DELETE'}, {
                headers: {'Authorization': 'Bearer ' + context.getters.token}
            }).then(res => {
            })
        },
        sendEmail(context, email) {
            axios.get('http://127.0.0.1:8000/api/comment/send-email', {
                headers: {'Authorization': 'Bearer ' + context.getters.token},
                params: {user: context.getters.getAuth.user.name, email: email}
            })
        },
        getUsers(context) {
            axios.get('http://127.0.0.1:8000/api/admin/users', {
                headers: {'Authorization': 'Bearer ' + context.getters.token},
            }).then(res => {
                context.commit('getUsers', res.data);
            });
        },
        deletePost(context, id) {
            axios.post('http://127.0.0.1:8000/api/post/' + id, {_method: 'DELETE'}, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + context.state.auth.user.api_token,
                }
            });
        },
    },
    mutations: {
        auth(state, user) {
            state.auth.check = true;
            state.auth.user = user;
        },
        logout(state) {
            localStorage.removeItem('user');
            state.auth.check = false;
        },
        postEdit(state, id) {
            state.editPost = id;
        },
        getUsers(state, users) {
            state.users = users
        },

    },
    getters: {
        getAuth(state) {
            return state.auth
        },
        token(state) {
            return state.auth.user.api_token
        },
        getUsers(state) {
            return state.users
        },

    },
})
