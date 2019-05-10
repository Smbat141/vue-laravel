import Vue from 'vue'
import Vuex from  'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
      auth:{
          user:{},
          check: false
      }
    },
    mutations:{
        auth(state,user){
            state.auth.check = true;
            state.auth.user = user;
        },
        logout(state){
            state.auth.check = false;
        }
    },
    getters:{
        getAuth(state){
            return state.auth
        }
    },
})
