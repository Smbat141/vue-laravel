import VueRouter from 'vue-router'
import Register from "./components/Register";
import Login from "./components/Login";
import Profile from "./components/user/Profile";
import NewPost from "./components/user/NewPost";
import ErrorPage from "./components/ErrorPage";


export default new VueRouter({
    routes:[
        {path:'/',component:Login},
        {path:'/register',component:Register,name:'register'},
        {path:'/profile',component:Profile,name:'profile',beforeEnter(to,from,next){
                let user = localStorage.getItem('user')
                if(user){
                    next(true)
                }
                else {
                    next('errorPage')
                }
            }},
        {path:'/newPost',component:NewPost,name:'newPost'},
        {path:'/errorPage',component:ErrorPage,name:'errorPage'},

    ],
})
