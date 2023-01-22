<template>
    <header-component></header-component>
    <div class="row">
        <nav-component></nav-component>
        <div class="col-sm-9 col-9 mt-3 m-0 m-sm-auto">

            <div v-show="show" class="col-12 col-sm-6 m-auto mt-3">
                <h2>Update post</h2>
                <input class="form-control m-3 mb-0  p-3" v-model="requestData.name" placeholder="Name">
                <div class="text-danger text-start m-o ps-3">{{ err.name[0] }}</div>
                <select v-model="requestData.category_id" class="form-select m-3 mb-0  p-3">
                    <option disabled value="">Category</option>
                    <option v-for="(c, k) in data.categories" :value="c.id" :key="k">
                        {{ c.title }}
                    </option>
                </select>
                <div class="text-danger text-start m-o ps-3">{{ err.category_id[0] }}</div>
                <div class="form-control m-3 mb-0  p-1">
                    <textarea v-model="requestData.content" placeholder="Content"
                              class="form-control p-3 col-12 radius"></textarea>
                </div>
                <div class="text-danger text-start m-o ps-3">{{ err.content[0] }}</div>

                <div class="row col-12 m-3 mb-0  p-3">
                    <div class="col-3" v-for="(i, k) in img" :key="k">
                        <img class="img" :src="i.url" :alt="data.post.title" @click="deleteImg(k)">
                    </div>
                </div>

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

                <button class="btn btn-info m-2" @click="update()">Update</button>
                <button class="btn btn-info m-2" @click="show=false">Close</button>
            </div>

            <div v-show="!show" class="col-11  justify-content-center ms-5 mt-5  p-3">
                <div class="col-12 mb-3 bg-dark m-auto text-light radius">
                    <div class=" corusel col-12">
                        <div class="corusel-a">
                            <span v-for="(img, k) in data.post.images" :key="k" ref="dots" class="dot"
                                  @click="currentSlide(k+1)"></span>
                        </div>
                        <div v-for="(img, k) in data.post.images" :key="k" ref="slides" class="corusel-v">
                            <img :src="img.url" :alt="data.post.name">
                            <div class="text"><a href=""></a></div>
                        </div>
                        <a class="prev text-light" @click="goSlide(-1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                            </svg>
                        </a>
                        <a class="next text-light" @click="goSlide(1)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                            </svg>
                        </a>
                    </div>
                    <div class=" col-12 m-auto mt-3 row">
                        <div class="col-sm-6 col-12">
                            <span class="display-6"><strong>Product name:</strong></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span class="display-6"><i>{{ data.post.name }}</i></span>
                        </div>

                        <div class="col-sm-6 col-12">
                            <span class="display-6"><strong>Product category:</strong></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span class="display-6"><i>{{ data.post.category.title }}</i></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span class="display-6"><strong>Post creat:</strong></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span
                                class="display-6"><i>{{
                                    data.post.created_at.substring(0, 10) + ' ' + data.post.created_at.substring(12, 19)
                                }}</i></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span class="display-6"><strong>Post update:</strong></span>
                        </div>
                        <div class="col-sm-6 col-12">
                            <span
                                class="display-6"><i>{{
                                    data.post.updated_at.substring(0, 10) + ' ' + data.post.updated_at.substring(12, 19)
                                }}</i></span>
                        </div>

                        <p class="display-6 mt-3 text-center"><strong>Content</strong></p>
                        <span class="p-3 ms-3 me-3" v-html="data.post.content"></span>
                    </div>
                    <div class="col-12 row mb-5 ">
                        <div class="col-3 m-auto mt-5 mb-5 text-center">
                            <a class="btn text-info" @click.prevent="showUp()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                    <path
                                        d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="col-3 m-auto mt-5 mb-5 text-center">
                            <a class="btn text-danger" @click.prevent="deletePost()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </a>
                        </div>
                        <div class=" col-3 m-auto mt-5 mb-5 text-danger text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-balloon-heart-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                      d="M8.49 10.92C19.412 3.382 11.28-2.387 8 .986 4.719-2.387-3.413 3.382 7.51 10.92l-.234.468a.25.25 0 1 0 .448.224l.04-.08c.009.17.024.315.051.45.068.344.208.622.448 1.102l.013.028c.212.422.182.85.05 1.246-.135.402-.366.751-.534 1.003a.25.25 0 0 0 .416.278l.004-.007c.166-.248.431-.646.588-1.115.16-.479.212-1.051-.076-1.629-.258-.515-.365-.732-.419-1.004a2.376 2.376 0 0 1-.037-.289l.008.017a.25.25 0 1 0 .448-.224l-.235-.468ZM6.726 1.269c-1.167-.61-2.8-.142-3.454 1.135-.237.463-.36 1.08-.202 1.85.055.27.467.197.527-.071.285-1.256 1.177-2.462 2.989-2.528.234-.008.348-.278.14-.386Z"/>
                            </svg>
                            <span class="ms-2">{{ data.likes.length }}</span>
                        </div>
                        <div class="col-3 m-auto mt-5 mb-5  text-center text-muted">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                            <span class="ms-2">{{ data.post.reviews_count }}</span>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-11 m-auto">
                <div v-for="(comment, key) in data.comments.data" :key="key"
                     class="col-12 bg-dark m-auto text-light p-3 mb-3 radius">
                    <div class="radius border-light border-3">
                        <div class="col-12">
                            <div class="h5 d-inline-block ps-3 col-12 text-start">User nik name:
                                {{ comment.user.nik_name }}
                            </div>
                            <div class="h5 d-inline-block ps-3 col-12 text-start">User email: {{
                                    comment.user.email
                                }}
                            </div>
                            <div class="h5 d-inline-block p-3 col-12  text-end">
                                {{
                                    comment.created_at.substring(0, 10) + ' ' + comment.created_at.substring(12, 19)
                                }}
                            </div>
                        </div>
                        <p class="comment" v-html="comment.comment"></p>
                        <div class="col-12 m-auto mt-5 text-end">
                            <a class="btn text-danger" @click.prevent="deleteComment(comment.id)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="m-auto d-flex justify-content-center">
                    <pagination class="m-auto" :callback="getResults" :pagination="data.comments" :size="'small'"/>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import mixin from "@/mixins";
import HeaderComponent from "@/components/HeaderComponent";
import NavComponent from "@/components/NavComponent";
import {Dropzone} from "dropzone";
import api from "@/assets/axios/api";

import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    name: "ShowPostView",

    mixins: [mixin],

    components: {
        HeaderComponent: HeaderComponent,
        NavComponent: NavComponent,
    },

    computed: {
        url() {
            return this.$store.getters.getUrl + '/posts/show'
        }
    },

    data() {
        return {
            id: this.$route.params.id,
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
            index: 1,
            img: [],
            images: '',
            deleteImage: [],
        }
    },
    methods: {
        showUp() {
            this.requestData = {
                category_id: this.data.post.category_id,
                content: this.data.post.content,
                name: this.data.post.name,
            };
            this.img = this.data.post.images
            this.show = true;
        },

        deleteImg(k) {
            this.deleteImage.push(this.img[k]);

            let arr = this.img.filter((v, i) => {
                return i !== k;
            });

            this.img = arr;
        },

        deleteComment(id) {
            api.delete(this.$store.getters.getUrl + '/comments/' + id)
                .then(() => {
                    this.query(this.url + '/' + this.data.post.id);
                })
                .catch(e => {
                    console.log(e);
                })
        },

        deletePost() {
            api.delete(this.url + `/${this.data.post.id}`)
                .then(() => {
                    this.$router.push({name: 'posts'})
                })
                .catch(e => {
                    console.log(e);
                });
        },

        update() {
            this.err = {
                name: [''],
                images: [''],
                category_id: [''],
                content: [''],
            };
            const data = new FormData();
            data.append('name', this.requestData.name);
            data.append('content', this.requestData.content);
            data.append('category_id', this.requestData.category_id);
            const files = this.images.getAcceptedFiles();

            files.forEach((file) => {
                data.append('images[]', file);
                this.images.removeFile(file);
            });

            data.append('img', JSON.stringify(this.img));

            data.append('img_d', JSON.stringify(this.deleteImage));

            api.post(this.url + '/update/' + this.id, data)
                .then((r) => {
                    if (r.data.err) {
                        this.err.images[0] = r.data.err;
                    } else {
                        this.show = false;
                        this.query(this.url + '/' + this.id);
                    }

                })
                .catch(err => {
                    if (err.response.data.errors) {
                        this.err = Object.assign(this.err, err.response.data.errors);
                    }
                });

        },


        /**** slider ****/
        start() {
            setInterval(this.goSlide
                , 3000);
        },

        showSlides(n) {
            const slides = this.$refs.slides;
            const dots = this.$refs.dots
            if (n > slides.length) {
                this.index = 1
            }
            if (n < 1) {
                this.index = slides.length
            }
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace("active", "");
            }
            slides[this.index - 1].style.display = "block";
            dots[this.index - 1].className += " active";
        },

        goSlide() {
            this.showSlides(this.index += 1);
        },

        currentSlide(k) {
            this.index = k
            this.showSlides(this.index);
        }
    },

    created() {
        this.query(this.url + '/' + this.id);
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

        this.showSlides(this.index);
        this.start();

    }
}
</script>

<style scoped>
.radius {
    border-radius: 10px;
}

/*CORUSEL*/
.corusel {
    height: 400px;
    margin: auto;
    position: relative;
}

.corusel .corusel-v img {
    width: 100%;
    height: 400px;
    border-radius: 10px 10px 0 0;
}

.prev, .next {
    font-size: 1.8rem;
    position: absolute;
    top: 38%;
    width: auto;
    padding: 16px;
    margin-top: -22px;
    font-weight: bold;
    transition: 0.5s;
    border-radius: 0 3px 3px 0;
}

.prev {
    left: 0;
    border-radius: 3px 0 0 3px;
}

.next {
    right: 0;
    border-radius: 3px 0 0 3px;
}

.prev:hover, .next:hover {
    cursor: pointer;
    background-color: rgb(0, 0, 0, 0.5)
}

.text {
    display: block;
    font-size: 1.5rem;
    padding: 10px;
    position: absolute;
    top: 0;
    margin-top: 5px;
    padding: 0;
    background-color: #000;
    width: 100%;
    text-align: center;
    opacity: 0.7;
    color: #fff;
}

.corusel-a {
    display: block;
    position: absolute;
    left: 48%;
    bottom: 0.6rem;
}

.dot {
    cursor: pointer;
    height: 13px;
    width: 13px;
    background-color: #bdb9b9;
    border-radius: 50%;
    display: inline-block;
    transition: background-color 0.6s ease;
}

.active, .dot:hover {
    background-color: rgb(56, 56, 56);
}

.img {
    width: 100%;
    padding: 3px;
    height: 100px;
    border-radius: 10px;
}
</style>
