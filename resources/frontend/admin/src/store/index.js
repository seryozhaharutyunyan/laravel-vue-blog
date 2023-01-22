import {createStore} from 'vuex';
import router from "@/router";

export default createStore({
    state: {
        url: 'http://myblog.loc/api/admin',
        urlRoot: 'http://myblog.loc/api',
        URL:'http://myblog.loc',
        auth: false,
    },
    getters: {
        getUrl(state) {
            return state.url;
        },

        getURL(state){
            return state.URL
        },

        getUrlRoot(state) {
            return state.urlRoot;
        },


        getAuth(state) {
            return state.auth
        }
    },
    mutations: {
        updateAuth(state) {
            if (sessionStorage.getItem('token')) {
                state.auth=true;
            }else {
                state.auth=false;
                router.push({name: 'login'})
            }
        }
    },
    actions: {
        getAuth(context){
            context.commit("updateAuth");
        }
    },
    modules: {}
})
