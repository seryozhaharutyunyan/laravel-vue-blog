import api from '../assets/axios/api';
import store from "@/store";
import router from "@/router";

export default {
    data() {
        return {
            data: {},
            requestData: {},
            user: {},
        }
    },
    methods: {
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

        add(url, data=this.requestData) {
            api.post(url, data)
                .then((r) => {
                    console.log(r)
                    this.requestData = {};
                    this.query(url);
                })
                .catch(e => {
                    console.log(e)
                    this.err = Object.assign(this.err, e.response.data.errors);
                });
        },

        update(url, id) {
            api.patch(url + `/${id}`, this.requestData)
                .then(() => {
                    this.addData = {};
                    this.query(url);
                    this.updateId = '';
                })
                .catch(e => {
                    console.log(e)
                    this.err = Object.assign(this.err, e.response.data.errors);
                });
        },

        destroy(url, id) {
            api.delete(url + `/${id}`)
                .then(() => {
                    this.query(url);
                })
                .catch(e => {
                    console.log(e);
                });
        },

        getResults(page = 1) {
            api.get(this.url + '?page=' + page)
                .then(r => {
                    this.data = r.data;
                });
        },

        getUser() {

            if (sessionStorage.getItem('token')) {
                api.post(store.getters.getUrlRoot + '/auth/me')
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
    },

    created() {
        this.getUser();
        store.dispatch('getAuth');
        if (!this.user) {
            router.push({name: 'login'})
        }
    }

}

