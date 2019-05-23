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
        posts:[],
        paginate:{},
        users:[],
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
        },
        getPosts(context){
            axios.get('http://127.0.0.1:8000/api/post',  {
                headers: {'Authorization': 'Bearer ' + context.getters.token},
            }).then(res =>{
                context.commit('getPosts',res.data.data);
                context.commit('paginate',res.data);

            });
        },
        getUsers(context){
            axios.get('http://127.0.0.1:8000/api/admin/users',  {
                headers: {'Authorization': 'Bearer ' + context.getters.token},
            }).then(res =>{
                console.log(res.data);
                context.commit('getUsers',res.data);
            });
        },
        deletePost(context,id){
            axios.post('http://127.0.0.1:8000/api/post/' + id, {_method: 'DELETE'}, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + context.state.auth.user.api_token,
                }
            });
        },
        paginate(context,page){
             axios.get('http://127.0.0.1:8000/api/post?page=' + page, {
                    headers: {'Authorization': 'Bearer ' + context.state.auth.user.api_token}
                }).then(response => {
                 context.commit('getPosts',response.data.data)
                })
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
        getPosts(state,posts){
            state.posts = posts
        },
        getUsers(state,users){
            state.users = users
        },
        paginate(state,posts){
            state.paginate = {page:posts.current_page,lastPage:posts.last_page}
        }
    },
    getters: {
        getAuth(state) {
            return state.auth
        },
        token(state) {
            return state.auth.user.api_token
        },
        getPosts(state){
            return state.posts
        },
        getUsers(state){
            return state.users
        },
        paginate(state){
            return state.paginate
        }
    },
})
