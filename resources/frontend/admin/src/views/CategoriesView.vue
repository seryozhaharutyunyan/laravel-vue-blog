<template>
    <header-component></header-component>
    <div class="row">
        <nav-component></nav-component>
        <div class="col-9 mt-3 m-auto">
            <h2 class="m-3">Categories</h2>
            <div v-show="show" class="col-6 m-auto mt-3">
                <input class="form-control" v-model="requestData.title" placeholder="Title">
                <div class="text-danger">{{ err.title[0] }}</div>
                <button class="btn btn-info m-2" @click="addCategory()">Add</button>
                <button class="btn btn-info m-2" @click="show=false">Close</button>
            </div>
            <div v-show="!show" class="col-12 mt-3" @click="show=true; updateId=''">
                <button class="btn btn-info">Add</button>
            </div>
            <div class="d-flex mt-3 col-12 text-center justify-content-center ">
                <div class="col-sm-5 col-12 m-sm-auto">
                    <table class="table">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">TITLE</th>
                            <th scope="col">UPDATE</th>
                            <th scope="col">DELETE</th>
                        </tr>
                        </thead>

                        <tbody>

                        <template v-for="(category, key) in data.data" v-bind:key="key">
                            <tr :class="!isShow(category.id) ? '' : 'd-none'">
                                <td>{{ key + 1 }}</td>
                                <td>{{ category.title }}</td>
                                <td>
                                    <a class="text-info" @click.prevent="change(category)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a class="text-danger" @click.prevent="destroy(url, category.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            <tr :class="isShow(category.id) ? '' : 'd-none'">
                                <td>{{ key + 1 }}</td>
                                <td>
                                    <input type="text" v-model="requestData.title" class="form-control">
                                    <div class="text-danger text-start m-o ps-3">{{ err.title[0] }}</div>
                                </td>
                                <td>
                                    <a class="text-info" @click.prevent="updateCategory(category.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                            <path
                                                d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                        </svg>
                                    </a>
                                </td>
                                <td>
                                    <a class="text-danger" @click.prevent="destroy(this.url, category.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </template>

                        </tbody>
                    </table>
                    <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                        <pagination :pagination="data" :callback="getResults" :size="'small'">

                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavComponent from "@/components/NavComponent";
import HeaderComponent from "@/components/HeaderComponent";
import mixin from "@/mixins";
import PaginationComponent from "@/components/PaginationComponent";
import api from "@/assets/axios/api";

export default {
    name: "CategoriesView",


    components: {
        HeaderComponent: HeaderComponent,
        NavComponent: NavComponent,
        pagination: PaginationComponent,

    },

    mixins: [mixin],

    computed: {
        url() {
            return this.$store.getters.getUrl + '/categories'
        }
    },

    data() {
        return {
            show: false,
            err: {
                title: [''],
            },
            updateId: '',
        }
    },

    methods: {
        addCategory() {
            this.err = {
                title: [''],
            }

            this.add(this.url);
        },

        updateCategory(id){
            this.err={
                title: [''],
            }
            this.update(this.url, id);
        },

        isShow(id) {
            return id === this.updateId;
        },

        change(category) {
            this.show=false;
            this.requestData.title = category.title;
            this.updateId = category.id;
        },
        getResults(page = 1) {
            api.get(this.url +'/show?page=' + page)
                .then(r => {
                    this.data = r.data;
                });
        },
    },

    created() {
        this.query(this.url+'/show')
    }
}
</script>

<style scoped>

</style>
