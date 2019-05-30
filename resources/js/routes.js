import VueRouter from 'vue-router'
import Register from "./components/Register";
import Login from "./components/Login";
import Home from "./components/user/Home";
import Profile from "./components/user/Profile";
import NewPost from "./components/user/NewPost";
import Post from "./components/user/Post";
import MyPosts from "./components/user/MyPosts";
import UserSettings from "./components/user/UserSettings";
import AdminPage from "./components/user/admin/AdminPage";
import AdminPosts from "./components/user/admin/AdminPosts";
import AdminUsers from "./components/user/admin/AdminUsers";
import ErrorPage from "./components/ErrorPage";



export default new VueRouter({
    routes:[
        {path:'/',component:Login,beforeEnter(to, from, next) {
                let user = localStorage.getItem('user');
                if(!user){
                    next(true)
                }
                else {
                    next('errorPage')
                }
            }},
        {path:'/register',component:Register,name:'register',beforeEnter(to,from,next){
                let user = localStorage.getItem('user');

                if(!user){
                    next(true)
                }
                else {
                    next('errorPage')
                }
            }},
        {path:'/home',component:Home,name:'home',beforeEnter(to,from,next){
                let user = localStorage.getItem('user');

                if(user){
                    next(true)
                }
                else {
                    next('errorPage')
                }
            }},
        {
            path:'/admin',component:AdminPage,name:'admin',beforeEnter(to, from, next) {
                let user = localStorage.getItem('user');

                if(JSON.parse(user).roles[0].name === 'admin'){
                    next(true)
                }
                else{
                    next('errorPage')
                }

            },
            children:[
                {
                    path:'posts',
                    component:AdminPosts,
                    name:'adminPosts',
                },
                {
                    path:'users',
                    component:AdminUsers,
                    name:'adminUsers',
                }
            ]
        },
        {path:'/profile',component:Profile,name:'profile',
            children:[
                {
                    path:'userSettings',
                    component:UserSettings,
                    name:'userSettings',
                },
            ]
        },
        {path:'/newPost',component:NewPost,name:'newPost'},
        {path:'/post/:id',component:Post,name:'post'},
        {path:'/myPosts',component:MyPosts,name:'myPosts'},
        {path:'/errorPage',component:ErrorPage,name:'errorPage'},

    ],
})
