import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegistrationView from "@/views/RegistrationView";
import InfoView from "@/views/InfoView";
import LoginView from "@/views/LoginView";
import ShowPostsView from "@/views/ShowPostsView";
import AccountView from "@/views/AccountView";
import ShowPostView from "@/views/ShowPostView";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },

    {
        path: '/registration',
        name: 'registration',
        component: RegistrationView
    },

    {
        path: '/info',
        name: 'info',
        component: InfoView
    },

    {
        path: '/login',
        name: 'login',
        component: LoginView
    },

    {
        path: '/category/:id',
        name: 'categoryPosts',
        component: ShowPostsView
    },

    {
        path: '/account',
        name: 'account',
        component: AccountView,
    },

    {
        path: '/post/:id',
        name: 'post',
        component: ShowPostView,
    },

    {
        path: "/:pathMatch(.*)*",
        redirect: '/'
    },

]

const router = createRouter({
    history: createWebHistory('/'),
    routes
})



export default router
