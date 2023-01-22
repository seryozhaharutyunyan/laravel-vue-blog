import axios from "axios";
import store from "@/store";

const api = axios.create();
api.interceptors.request.use(
    (config) => {
        if (localStorage.getItem('token')) {
            config.headers.authorization = `Bearer ${localStorage.getItem('token')}`;
        }

        return config;
    },
    (error) => {
        console.log(error)
    });

api.interceptors.response.use(
    (response) => {
        return response;
    },
    async (error) => {

        if (error.response.data.message === 'Token has expired') {
            return axios.post(`${store.getters.getUrl}/auth/refresh`, {}, {
                headers: {
                    authorization: `Bearer ${localStorage.getItem('token')}`
                }
            }).then(r => {
                localStorage.setItem('token', r.data.access_token);

                error.config.headers.authorization = `Bearer ${localStorage.getItem('token')}`
                return api.request(error.config);
            });
        } else {
            return Promise.reject(error);
        }
    })

export default api;
