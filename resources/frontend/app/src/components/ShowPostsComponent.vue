<template>
    <div class="col-sm-8 col-12">

        <div class="col-6 m-3">
            <input type="search" @input="search($event)" class="form-control p-2 mt-2 mb-2"
                   placeholder="Search">
            <div class="m-auto">
                <span class="display-6 text-danger">{{ success }}</span>
            </div>
        </div>
        <div v-show="!add" class="col-12 p-3 m-2">
            <button class="btn btn-info" @click="showAdd()">Add post</button>
        </div>
        <div v-show="add" class="col-12 col-sm-6 m-auto mt-3">
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
            <button class="btn btn-info m-2" @click="add=false">Close</button>
        </div>

        <div v-show="!add">
            <template v-if="show">
                <div v-for="(post, key) in searchData.data" :key="key"
                     class="row col-10 radius bg-secondary m-auto mb-3">

                    <div class="col-11 m-auto m-sm-0 col-sm-5">
                        <img :src="post.images[0].url">
                    </div>

                    <div class="col-11 col-sm-6">
                        <div class="col-12 m-auto mt-3 row">
                            <div class="col-6">
                                <span class="h5"><strong>Post name:</strong></span>
                            </div>
                            <div class="col-6">
                                <span class="h5"><i>{{ post.name }}</i></span>
                            </div>

                        </div>
                        <div class="col-12 m-auto mt-3 row">
                            <div class="col-6">
                                <span class="h5"><strong>Post category:</strong></span>
                            </div>
                            <div class="col-6">
                                <span class="h5"><i>{{ post.category.title }}</i></span>
                            </div>
                        </div>
                        <div class="col-12 m-auto mt-3 row">
                            <h2>Content</h2>
                            <p v-html="content(post.content)"></p>
                        </div>
                        <div class="col-12 row mb-5">
                            <div class="col-3 m-auto mt-5 text-danger text-center">
                                <router-link :to="{ name: 'post', params: {id: post.id}}" class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-binoculars-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z"/>
                                    </svg>
                                </router-link>
                            </div>
                            <div class="col-3 m-auto mt-5 text-center text-info">
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
                    <pagination :callback="getResults" :pagination="searchData" :size="'small'">

                    </pagination>
                </div>
            </template>
            <template v-else>
                <div v-for="(post, key) in data.data" :key="key" class="row col-10 radius bg-secondary m-auto mb-3">

                    <div class="col-11 m-auto m-sm-0 col-sm-5">
                        <img :src="post.images[0].url">
                    </div>

                    <div class="col-11 col-sm-6">
                        <div class="col-12 m-auto mt-3 row">
                            <div class="col-6">
                                <span class="h5"><strong>Post name:</strong></span>
                            </div>
                            <div class="col-6">
                                <span class="h5"><i>{{ post.name }}</i></span>
                            </div>

                        </div>
                        <div class="col-12 m-auto mt-3 row">
                            <div class="col-6">
                                <span class="h5"><strong>Post category:</strong></span>
                            </div>
                            <div class="col-6">
                                <span class="h5"><i>{{ post.category.title }}</i></span>
                            </div>
                        </div>
                        <div class="col-12 m-auto mt-3 row">
                            <h2>Content</h2>
                            <p v-html="content(post.content)"></p>
                        </div>
                        <div class="col-12 row mb-5">
                            <div class="col-3 m-auto mt-5 text-danger text-center">
                                <router-link :to="{ name: 'post', params: {id: post.id}}" class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                         class="bi bi-binoculars-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z"/>
                                    </svg>
                                </router-link>
                            </div>
                            <div class="col-3 m-auto mt-5 text-center text-info">
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
                    <pagination :callback="getResults" :pagination="data" :size="'small'">

                    </pagination>
                </div>
            </template>
        </div>


    </div>

</template>

<script>
import mixin from "@/mixins/mixin";
import PaginationComponent from "@/components/PaginationComponent";
import api from "@/assets/axios/api";
import {Dropzone} from "dropzone";

export default {
    name: "ShowPostsComponent",

    props: {path: String},

    components: {
        Pagination: PaginationComponent,
    },

    computed: {
        url() {
            return this.$store.getters.getUrl;
        }
    },

    mixins: [mixin],

    data() {
        return {
            success: '',
            searchData: {},
            show: false,
            add: false,
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
            categories:{},
        }
    },

    methods: {
        showAdd() {
            this.add = true;
            api.get(this.url + '/categories')
                .then(r => {
                    this.categories = r.data
                })
                .catch(e => {
                    console.log(e)
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
            api.post(this.url + '/admin/posts', data)
                .then(() => {
                    this.requestData = {
                        category_id: '',
                        content: '',
                        name: '',
                    };

                    this.query(this.url);
                })
                .catch(e => {
                    this.err = Object.assign(this.err, e.response.data.errors);
                });
        },

        search(event) {
            let text = event.target.value;
            this.add = false;
            if (text.length >= 3) {
                api.post(this.url + '/search', {text})
                    .then(r => {
                        this.searchData = r.data;
                        this.show = true;
                        this.success = '';
                        if (r.data.data.length === 0) {
                            this.success = 'Nothing found!!!';
                        }
                    })
                    .catch(e => {
                        console.log(e);
                    })
            }
            if (text === '') {
                this.show = false;
                this.success = '';
            }
        },

        content(content) {
            if (content.length >= 50) {
                return content.substring(0, 60) + '....';
            } else {
                return content;
            }
        },

    },

    watch: {
        '$route'() {
            if (this.$route.params.id) {
                this.query(this.url + '/posts/' + this.$route.params.id);
            }
        },
    },

    created() {
        this.query(this.url + this.path)

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
img {
    width: 100%;
    padding: 3px;
    height: 300px;
    border-radius: 10px;
}

.dz-error-mark {
    display: none;
}

.dz-success-mark {
    display: none;
}
</style>
