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
    },
    actions: {
        logout(context) {
            context.commit('logout')
            axios.post('http://127.0.0.1:8000/api/logout', {}, {
                headers: {'Authorization': 'Bearer ' + context.getters.token}
            }).then(res => {
                // console.log(res);
            }).catch(err => {
                // console.log(err);
            })
        },
        deleteImage(context,id){
            axios.post('http://127.0.0.1:8000/api/post/deleteImg/' + id, {'_method':'DELETE'}, {
                headers: {'Authorization': 'Bearer ' + context.getters.token}
            }).then(res => {
                if(res.status === 200){
                    // console.log(res);
                }
            }).catch(err => {
                // console.log(err);
            })
        },
        sendEmail(context,email){
            axios.get('http://127.0.0.1:8000/api/comment/send-email',  {
                headers: {'Authorization': 'Bearer ' + context.getters.token},
                params:{user:context.getters.getAuth.user.name,email:email}
            }).then(res =>{
                //console.log(res.data);
            });
        }
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
        }
    },
    getters: {
        getAuth(state) {
            return state.auth
        },
        token(state) {
            return state.auth.user.api_token
        },
    },
})
