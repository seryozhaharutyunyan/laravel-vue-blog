<template>
    <header-component></header-component>
    <div class="row">
        <nav-component></nav-component>
        <div class="col-9 col-sm-9 p-3 mt-5">
            <h2>Users</h2>
            <div v-for="(user, key) in data.data" :key="key" class="row col-12 radius bg-secondary mt-3 m-auto">

                <div class="col-11 m-auto m-sm-0 col-sm-5">
                    <img :src="$store.getters.getURL+'/'+user.img">
                </div>

                <div class="col-11 col-sm-6">
                    <div class="col-12 m-auto mt-3 row">
                        <div class="col-11 col-sm-6">
                            <span class="h5"><strong>Nik name:</strong></span>
                        </div>
                        <div class="col-11 col-sm-6">
                            <span class="h5"><i>{{ user.nik_name }}</i></span>
                        </div>

                    </div>
                    <div class="col-12 m-auto mt-3 row">
                        <div class="col-11 col-sm-6">
                            <span class="h5"><strong>Email:</strong></span>
                        </div>
                        <div class="col-11 col-sm-6">
                            <span class="h5"><i>{{ user.email }}</i></span>
                        </div>


                    </div>
                    <div class="col-12 row mb-5">
                        <div class="col-3 m-auto mt-3 text-danger text-center">
                            <a v-if="!user.block" @click.prevent="block(user.id)" class="btn text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                                </svg>
                            </a>
                            <a v-else class="btn text-info" @click.prevent="block(user.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col-3 m-auto mt-3 text-danger text-center">
                            <a class="btn text-danger" @click.prevent="destroy(this.url+`/${user.id}`)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                <pagination :pagination="data" :callback="getResults" :size="'small'">

                </pagination>
            </div>
        </div>
    </div>
</template>

<script>
import mixin from "@/mixins";
import HeaderComponent from "@/components/HeaderComponent";
import NavComponent from "@/components/NavComponent";
import PaginationComponent from "@/components/PaginationComponent";
import api from "@/assets/axios/api";

export default {
    name: "UsersView",
    mixins: [mixin],
    components: {
        HeaderComponent: HeaderComponent,
        NavComponent: NavComponent,
        pagination: PaginationComponent,
    },

    computed: {
        url() {
            return this.$store.getters.getUrl + '/users'
        }
    },

    methods: {
        block(id) {
            api.get(this.url + `/${id}`)
                .then(()=>{
                    this.query(this.url);
                })
                .catch(e=>{
                    console.log(e);
                })
        }
    },

    created() {
        this.query(this.url);
    },
}
</script>

<style scoped>
img {
    width: 100%;
    padding: 3px;
    height: 325px;
    border-radius: 10px;
}

.radius {
    border-radius: 10px;
}
</style>
