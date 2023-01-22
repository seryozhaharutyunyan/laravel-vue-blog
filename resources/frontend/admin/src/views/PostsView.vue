<template>
    <header-component></header-component>
    <div class="row">
        <nav-component></nav-component>
        <div class="col-9 mt-3 m-auto">
            <div v-show="show" class="col-12 col-sm-6 m-auto mt-3">
                <h2>Add post</h2>
                <input class="form-control m-3 mb-0  p-3" v-model="requestData.name" placeholder="Name">
                <div class="text-danger text-start m-o ps-3">{{ err.name[0] }}</div>
                <select v-model="requestData.category_id" class="form-select m-3 mb-0  p-3">
                    <option disabled value="">Category</option>
                    <option v-for="(c, k) in categories" :value="c.id" :key="k">
                        {{ c.title }}
                    </option>
                </select>
                <div class="text-danger text-start m-o ps-3">{{ err.category_id[0] }}</div>
                <div class="form-control m-3 mb-0  p-1">
                        <textarea v-model="requestData.content" placeholder="Content"
                                  class="form-control p-3 col-12"></textarea>
                </div>
                <div class="text-danger text-start m-o ps-3">{{ err.content[0] }}</div>
                <div ref="images" class="btn d-block p-5 text-center  col-12 p-3 m-3 mb-0 border-2 border-dark"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-images" viewBox="0 0 16 16">
                        <path d="M4.502 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                        <path
                            d="M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"/>
                    </svg>
                    Image upload
                </div>
                <div class="text-danger text-start m-o ps-3">{{ err.images[0] }}</div>

                <button class="btn btn-info m-2" @click="addPost()">Add</button>
                <button class="btn btn-info m-2" @click="show=false">Close</button>
            </div>

            <div v-show="!show" class="col-12 mt-3 mb-3">
                <button  @click="showAdd()" class="btn btn-info">Add post</button>
            </div>
            <div v-show="!show">
                <template v-if="!showPosts">
                    <h2>Categories</h2>

                    <div class="col-12 col-sm-6 m-auto mt-3">
                        <div class="btn fs-4 border-warning m-2" v-for="(category, key) in data.data" :key="key">
                            <div @click="getPosts(category.id)">{{ category.title }}</div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                        <pagination :pagination="data" :callback="getResultsCategories" :size="'small'">

                        </pagination>
                    </div>

                </template>

                <template v-else>
                    <h2 class="m-3">Posts</h2>
                    <div v-show="!show" class="col-12 mt-3">
                        <button @click="showPosts=false; id=''" class="btn btn-info">Close</button>
                    </div>
                    <div v-for="(post, key) in posts.data" :key="key"
                         class="row col-10 radius bg-secondary mt-3 m-auto">

                        <div class="col-11 m-auto m-sm-0 col-sm-5">
                            <img :src="post.images[0].url">
                        </div>

                        <div class="col-11 col-sm-6">
                            <div class="col-12 m-auto mt-3 row">
                                <div class="col-11 col-sm-6">
                                    <span class="h5"><strong>Product name:</strong></span>
                                </div>
                                <div class="col-11 col-sm-6">
                                    <span class="h5"><i>{{ post.name }}</i></span>
                                </div>

                            </div>
                            <div class="col-12 m-auto mt-3 row">
                                <div class="col-11 col-sm-6">
                                    <span class="h5"><strong>Product category:</strong></span>
                                </div>
                                <div class="col-11 col-sm-6">
                                    <span class="h5"><i>{{ post.category.title }}</i></span>
                                </div>

                            </div>
                            <p class="display-6 mt-3 text-center"><strong>Content</strong></p>
                            <span class="p-3 ms-3 me-3 text-start" v-html="content(post.content)"></span>
                            <div class="col-12 row mb-5">
                                <div class="col-3 m-auto mt-3 text-danger text-center">
                                    <router-link :to="{ name: 'post', params: {id: post.id}}" class="text-dark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-binoculars-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z"/>
                                        </svg>
                                    </router-link>
                                </div>
                                <div class="col-3 m-auto mt-3 text-center text-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                    <span class="ms-2">{{ post.reviews_count }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center text-dark d-flex col-12 text-center justify-content-center">
                        <pagination :pagination="posts" :callback="getResultsPosts" :size="'small'">

                        </pagination>
                    </div>
                </template>
            </div>


        </div>
    </div>

</template>

<script>
import mixin from "@/mixins";
import HeaderComponent from "@/components/HeaderComponent";
import NavComponent from "@/components/NavComponent";
import PaginationComponent from "@/components/PaginationComponent";
import {Dropzone} from "dropzone";

import '@vueup/vue-quill/dist/vue-quill.snow.css';
import api from "@/assets/axios/api";

export default {
    name: "PostsView",

    mixins: [mixin],

    components: {
        HeaderComponent: HeaderComponent,
        NavComponent: NavComponent,
        pagination: PaginationComponent,
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    data() {
        return {
            id:'',
            show: false,
            err: {
                name: [''],
                user_id: [''],
                category_id: [''],
                content: [''],
                images: [''],
            },
            requestData: {
                category_id: '',
                content: '',
                name: '',
            },
            images: '',
            showPosts: false,
            posts: {},
            categories:{},
        }
    },
    methods: {
        showAdd(){


            api.get(this.url+'/categories')
            .then(r=>{
                this.categories=r.data;
                this.show=true;
            })
        },

        addPost() {
            this.err = {
                name: [''],
                user_id: [''],
                category_id: [''],
                content: [''],
                images: [''],
            };

            const data = new FormData;
            data.append('name', this.requestData.name);
            data.append('content', this.requestData.content);
            data.append('category_id', this.requestData.category_id);
            const files = this.images.getAcceptedFiles();

            files.forEach((file) => {
                data.append('images[]', file);
                this.images.removeFile(file);
            });
            api.post(this.url+'/posts', data)
                .then(() => {
                    this.requestData = {
                        category_id: '',
                        content: '',
                        name: '',
                    };

                    this.query(this.url + '/categories/show');
                })
                .catch(e => {
                    this.err = Object.assign(this.err, e.response.data.errors);
                });
        },

        getPosts(id) {
            this.id=id;
            api.get(this.url + '/posts/' + id)
                .then(r => {
                    console.log(r)
                    this.posts = r.data;
                    this.showPosts = true;
                })
                .catch(e => {
                    console.log(e);
                })
        },

        content(content) {
            if (content.length < 50) {
                return content;
            } else {
                return content.substring(0, 50) + '....';
            }
        },

        getResultsCategories(page = 1) {
            api.get(this.url + '/categories/show?page=' + page)
                .then(r => {
                    this.data = r.data;
                });
        },

        getResultsPosts(page = 1) {
            api.get(this.url + '/posts/'+this.id+'?page=' + page)
                .then(r => {
                    this.posts = r.data;
                });
        },
    },

    created() {
        this.query(this.url + '/categories/show');
    },

    mounted() {
        if (this.$refs.images) {
            this.images = new Dropzone(this.$refs.images, {
                url: '/',
                autoProcessQueue: false,
                addRemoveLinks: true,
                acceptedFiles: 'image/*',

            });
        }
    }
}
</script>

<style>
.dz-error-mark {
    display: none;
}

.dz-success-mark {
    display: none;
}

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
