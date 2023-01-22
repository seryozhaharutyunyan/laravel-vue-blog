import api from "@/assets/axios/api";
import store from "@/store";

export default {
    data() {
        return {
            user: {},
            data: {},
        }
    },

    methods: {
        getUser() {
            if (localStorage.getItem('token')) {
                api.post(store.getters.getUrl + '/auth/me')
                    .then(r => {
                        this.user = r.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            } else {
                this.user = {};
            }

        },

        query(url) {
            api.get(url)
                .then((r) => {
                    console.log(r)
                    this.data = r.data;
                })
                .catch(e => {
                    console.log(e)
                })
        },
    },

    created() {
        this.getUser();
        store.dispatch('setAuth');
    }

}
