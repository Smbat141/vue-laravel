import Vue from 'vue'
import Vuex from  'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
      auth:{
          user:{},
          check: false
      },
        editPost:'',
    },
    mutations:{
        auth(state,user){
            state.auth.check = true;
            state.auth.user = user;
        },
        logout(state){
            state.auth.check = false;
        },
        postEdit(state,id){
            state.editPost = id;
        }
    },
    getters:{
        getAuth(state){
            return state.auth
        },
        token(state){
            return this.state.auth.user.api_token
        }
    },
})
