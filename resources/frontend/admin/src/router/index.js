import {createRouter, createWebHistory} from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CategoriesView from "@/views/CategoriesView";
import CountriesView from "@/views/CountriesView";
import LoginView from "@/views/LoginView";
import AccountView from "@/views/AccountView";
import ShowPostView from "@/views/ShowPostView";
import UsersView from "@/views/UsersView";
import PostsView from "@/views/PostsView";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },

    {
        path: '/categories',
        name: 'categories',
        component: CategoriesView
    },

    {
        path: '/posts',
        name: 'posts',
        component: PostsView
    },

    {
        path: '/post/:id',
        name: 'post',
        component: ShowPostView
    },

    {
        path: '/users',
        name: 'users',
        component: UsersView
    },

    {
        path: '/countries',
        name: 'countries',
        component: CountriesView
    },

    {
        path: '/login',
        name: 'login',
        component: LoginView
    },

    {
        path: '/account',
        name: 'account',
        component: AccountView
    },

    {
        path: "/:pathMatch(.*)*",
        redirect: '/'
    },
]

const router = createRouter({
    history: createWebHistory('/admin/'),
    routes
})

router.beforeEach((to) => {
    const token = sessionStorage.getItem('token');
    if (to.name !== 'login') {
        if (!token) {
            return {
                name: 'login'
            };
        }
    }

    if (to.name === 'login') {
        if (token) {
            return {
                name: 'home'
            };
        }
    }

});

export default router
