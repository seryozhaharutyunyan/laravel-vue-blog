import { createStore } from 'vuex'

export default createStore({
  state: {
      url: 'http://myblog.loc/api',
      URL:'http://myblog.loc',
      auth: false,
  },
  getters: {
      getUrl(state){
          return state.url;
      },

      getAuth(state){
          return state.auth;
      },

      getURL(state){
          return state.URL
      },
  },
  mutations: {
      updateAuth(state) {
          if (localStorage.getItem('token')) {
              state.auth=true;
          }else {
              state.auth=false;
          }
      }
  },
  actions: {
      setAuth(context){
          context.commit("updateAuth");
      }
  },
  modules: {
  }
})
