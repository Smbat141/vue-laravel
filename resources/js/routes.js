import VueRouter from 'vue-router'
import Register from "./components/Register";
import Login from "./components/Login";
import Home from "./components/Home";


export default new VueRouter({
    routes:[
        {path:'/',component:Home,name:'home'},
        {path:'/register',component:Register,name:'register'},
        {path:'/login',component:Login,name:'login'},
    ],
    mode:'history'
})
