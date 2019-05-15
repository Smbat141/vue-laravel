import Vue from 'vue'
import Vuex from  'vuex'
import axios from 'axios'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
      auth:{
          user:{},
          check: false
      },
        editPost:'',
    },
    actions:{
      logout(context){
          context.commit('logout')
          axios.post('http://127.0.0.1:8000/api/logout',{},{
              headers:{'Authorization':'Bearer ' + context.getters.token}
          }).then(res => {
              console.log(res);
          }).catch(err =>{
              console.log(err);
          })
      }
    },
    mutations:{
        auth(state,user){
            state.auth.check = true;
            state.auth.user = user;
        },
        logout(state){
            localStorage.removeItem('user');
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
            return state.auth.user.api_token
        }
    },
})
